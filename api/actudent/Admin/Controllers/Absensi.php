<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Core\Controllers\Resources;
use Actudent\Admin\Models\AbsensiModel;
use Actudent\Admin\Models\JadwalModel;
use Actudent\Guru\Models\SchedulePresenceModel;
use PDFCreator;

class Absensi extends \Actudent
{
    /**
     * @var Actudent\Admin\Models\AbsensiModel
     */
    private $absensi;

    /**
     * @var Actudent\Admin\Models\JadwalModel
     */
    private $jadwal;

    /**
     * @var Actudent\Guru\Models\SchedulePresenceModel
     */
    protected $jadwalHadir;

    private $pdfCreator;

    private $days = [
        'minggu', 'senin', 'selasa',
        'rabu', 'kamis', 'jumat', 'sabtu'
    ];

    public function __construct()
    {
        $this->absensi = new AbsensiModel;
        $this->jadwal = new JadwalModel;
        $this->jadwalHadir = new SchedulePresenceModel;
        $this->pdfCreator = new PDFCreator;
    }

    public function getPeriodSummary($gradeId, $period, $year)
    {
        // 1 = Odd semester
        // 2 = Even semester
        $acceptedPeriod = [1 => range(7, 12), 2 => range(1, 6)];
        
        // generate start month
        $monthStart = $acceptedPeriod[$period][0] < 10 
                    ? '0' . $acceptedPeriod[$period][0]
                    : $acceptedPeriod[$period][0];
        
        // generate end month
        $monthEnd = $acceptedPeriod[$period][5] < 10 
                    ? '0' . $acceptedPeriod[$period][5]
                    : $acceptedPeriod[$period][5];
        
        $dateStart = "{$year}-{$monthStart}-01";
        $dateEnd = "{$year}-{$monthEnd}-" . os_date()->daysInMonth($acceptedPeriod[$period][5], $year);

        $journal = $this->absensi->getTotalJournals($gradeId, $dateStart, $dateEnd);
        $wrapper = [];

        if($journal > 0) {
            $classMember = $this->absensi->kelas->getClassMember($gradeId);
            foreach($classMember as $res) {
                $result = [];
                foreach($acceptedPeriod[$period] as $val) {
                    $result[] = $this->countPresence($res->student_id, $gradeId, $val, $year);
                }
        
                $result = array_values(array_merge(
                    $result[0],
                    $result[1],
                    $result[2],
                    $result[3],
                    $result[4],
                    $result[5],
                ));
        
                $present = $this->getPresenceStatusNumber($result, '1');
                $permit = $this->getPresenceStatusNumber($result, '2');
                $sick = $this->getPresenceStatusNumber($result, '3');
                $absent = $this->getPresenceStatusNumber($result, 0);
                $hasAbsent = $present + $permit + $sick + $absent;
                $notAbsent = $journal - $hasAbsent;
    
                $wrapper[$res->student_name] = [
                    'present'       => $present . $this->getPercentage($present, $journal),
                    'permit'        => $permit . $this->getPercentage($permit, $journal),
                    'sick'          => $sick . $this->getPercentage($sick, $journal),
                    'absent'        => $absent . $this->getPercentage($absent, $journal),
                    'incomplete'    => $notAbsent . $this->getPercentage($notAbsent, $journal)
                ];
            }
        } else {
            $wrapper = lang('Admin.no_data');
        }

        $response = [
            'activeDays'    => $journal,
            'summary'       => $wrapper
        ];

        return $this->response->setJSON($response);
    }

    private function getPercentage($a, $b)
    {
        return ' (' . number_format(($a / $b) * 100, 1) . '%)';
    }

    private function getPresenceStatusNumber($array, $status)
    {
        return count(array_filter($array, fn($val) => $val === $status));
    }

    public function getMonthlySummary($month, $year, $gradeId)
    {
        // Load the class member
        $classMember = $this->absensi->kelas->getClassMember($gradeId);
        $studentPresence = [];

        foreach($classMember as $res) {
            $studentPresence[$res->student_name] = $this->countPresence($res->student_id, $gradeId, $month, $year);
        }

        return $this->response->setJSON($studentPresence);
    }

    private function countPresence($studentId, $gradeId, $month, $year)
    {
        $presenceData = [];
        $totalDays = os_date()->daysInMonth($month, $year);

        // Loop the days from the selected month
        for($i = 1; $i <= $totalDays; $i++) {
            $date = reverse(os_date()->shortDate($i, $month, $year), '-', '-');
            $journals = $this->absensi->getJournalByDate($date, $gradeId, true);

            if(count($journals) === 0) {
                $presenceData[$date] = '-';
            } else {
                // Create a storage for presence of all journals
                $todayPresence = [];
                foreach($journals as $key) {
                    $getPresence = $this->absensi->getPresence($key->journal_id, $studentId, $date);
                    $todayPresence[] = $getPresence !== null ? $getPresence->presence_status : '-';
                }
                
                // Do search only if a student has presence data
                if(array_search('-', $todayPresence) === false) {
                    
                    // Search if a student has absent today or not
                    $hasAbsent = array_search(0, $todayPresence);

                    // If there is an absent, then presenceData should be 0 (absent)
                    if($hasAbsent !== false) {
                        $presenceData[$date] = 0;
                    } else {
                        // If presence_status is 1 (present) in the first and last lesson hour...
                        if($todayPresence[0] === 1 && end($todayPresence) === 1) {

                            // We have to check again if today presence is more than 2 data
                            if(count($todayPresence) > 2) {
                                // Create a storage for presence between first and last lesson
                                $presenceBetween = array_slice($todayPresence, 1, count($todayPresence) - 2);

                                // If there is presence status which has value 3 
                                // in $presenceBetween, then the student presence is 3 (sick)                                
                                if(array_search(3, $presenceBetween) !== false) {
                                    $presenceData[$date] = 3;
                                } else {
                                    // otherwise (if it is 1 or 2), 
                                    // the status of the student is 1 (present)
                                    $presenceData[$date] = 1;
                                }
                            } else {
                                $presenceData[$date] = 1;
                            }
                        } else {
                            $presenceData[$date] = end($todayPresence);
                        }
                    }
                } else {
                    $presenceData[$date] = '-';
                }
            }
        }

        return $presenceData;
    }

    public function exportPresence($gradeID, $day, $date)
    {
        if(is_admin())
        {
            $resource   = new Resources();
            $data       = $this->common();
            
            foreach($resource->getReportData() as $key => $val)
            {
                $data[$key] = $val;
            }

            $data['title']  = lang('AdminAbsensi.absensi_judul_laporan_absen');
            $data['grade']  = $this->absensi->kelas->getClassDetail($gradeID);
            $gradeMember    = $this->absensi->kelas->getClassMember($gradeID);
            $data['day']    = $this->days[$day];
            $data['date']   = os_date()->format('d-MM-Y', reverse($date, '-', '-'));
            $journals       = $this->absensi->getJournalByDate($date, $gradeID, true);
            $jadwal         = $this->jadwal->getSchedules($gradeID, $this->days[$day]);
    
            // Lesson hours will be used for table header column
            $lessonHours = [];
    
            // lesson started
            $init = 1;
    
            foreach($journals as $res)
            {
                $lessonHours[] = $res->lesson_code;    
            }
    
            $studentPresence = [];
            foreach($gradeMember as $res)
            {
                $formatted = [];
                foreach($journals as $key)
                {
                    $presence = $this->absensi->getPresence($key->journal_id, $res->student_id, $date);
                    $status = ['Alfa', 'Hadir', 'Izin', 'Sakit'];
                    if($presence === null)
                    {
                        $formatted[] = [
                            'journal_id'    => '-',
                            'status'        => '-',
                        ];
                    }
                    else
                    {
                        $formatted[] = [
                            'journal_id'    => $presence->journal_id,
                            'status'        => $status[$presence->presence_status],
                        ];                    
                    }
                }
    
                $studentPresence[] = [
                    'students'  => $res,
                    'data'      => $formatted,
                ];
            }
    
            $data['column']     = $lessonHours;
            $data['presence']   = $studentPresence;
            $data['colspan']    = count($lessonHours);
    
            $html       = view('Actudent\Admin\Views\absensi\ekspor-absen', $data);
            $filename   = 'Laporan Absen '. $data['grade']->grade_name . ' ' . $date .'_'. time();
    
            $this->pdfCreator->create($html, $filename, true, 'A4', 'portrait');
        }
    }

    public function exportJournal($gradeID, $day, $date)
    {
        if(is_admin())
        {
            $resource   = new Resources();
            $data       = $this->common();
            
            foreach($resource->getReportData() as $key => $val)
            {
                $data[$key] = $val;
            }
    
            $data['title']          = lang('AdminAbsensi.absensi_judul_laporan_jurnal');
            $data['grade']          = $this->absensi->kelas->getClassDetail($gradeID);
            $gradeMember            = $this->absensi->kelas->getClassMember($gradeID);
            $data['gradeMember']    = count($gradeMember);
            $data['day']            = $this->days[$day];
            $data['date']           = os_date()->format('d-MM-Y', reverse($date, '-', '-'));
            $journals               = $this->absensi->getJournalByDate($date, $gradeID);
            $data['journals']       = $journals;
    
            // get number of presence
            $presenceWrapper = [];
            $absentStudents = [];
            foreach($journals as $j)
            {
                $presenceWrapper[] = $this->absensi->getPresenceCount($j->journal_id);
                
                // get absent student(s)
                $getPresence = $this->_getListAbsensi($gradeID, $j->journal_id, $date);
                $absentStudents[] = array_filter($getPresence, function($item) {
                    return $item['statusID'] !== '1' && $item['statusID'] !== '';
                });
            }
    
            $data['presence']       = $presenceWrapper;
            $data['absence']        = $absentStudents;
            $html                   = view('Actudent\Admin\Views\absensi\ekspor-jurnal', $data);
            $filename               = 'Laporan Jurnal '. $data['grade']->grade_name . ' ' .$date .'_'. time();
    
            // return $html;
            $this->pdfCreator->create($html, $filename, true, 'A4', 'portrait');            
        }
    }

    /**
     * Get list of presence data
     * 
     * @param int $grade
     * @param int|string $journal
     * @param string $date
     * 
     * @return JSON
     */
    public function getListAbsensi($grade, $journal, $date)
    {
        return $this->createResponse($this->_getListAbsensi($grade, $journal, $date));
    }

    /**
     * Get list of presence data
     * 
     * @param int $grade
     * @param int|string $journal
     * @param string $date
     * 
     * @return array
     */
    private function _getListAbsensi($grade, $journal, $date)
    {
        // Get all member of a class group
        $student = $this->absensi->kelas->getClassMember($grade);

        // Presence data to be wrapped
        $presenceWrapper = [];

        // Presence status category
        // Absent|Absen, Present|Hadir, Permit|Izin, Sick|Sakit
        $presenceCategory = [
            lang('AdminAbsensi.absensi_alfa'),
            lang('AdminAbsensi.absensi_hadir'),
            lang('AdminAbsensi.absensi_izin'),
            lang('AdminAbsensi.absensi_sakit')
        ];

        foreach($student as $key)
        {          
            // Get presence of a student
            $presence = $this->absensi->getPresence($journal, $key->student_id, $date);

            if($presence !== null && $journal !== 'null')
            {
                $presenceWrapper[] = [
                    'id'        => $key->student_id,
                    'name'      => $key->student_name,
                    'status'    => $presenceCategory[$presence->presence_status],
                    'note'      => $presence->presence_mark,
                    'statusID'  => $presence->presence_status,
                ];
            }
            else 
            {
                // Set default presence data to empty
                $presenceWrapper[] = [
                    'id'        => $key->student_id,
                    'name'      => $key->student_name,
                    'status'    => '-',
                    'note'      => '-',
                    'statusID'  => '',
                ];
            }
        }

        return $presenceWrapper;
    }

    public function getJournalArchives($gradeID, $date)
    {
        if(valid_token()) {
            $decodedToken = jwt_decode(bearer_token());
            $userLevel = $decodedToken->userLevel;

            if($userLevel === '1')
            {
                $data = $this->absensi->getJournalArchives($gradeID, $date);
            }
            else 
            {
                $teacher = $this->jadwalHadir->getTeacherByUserID($decodedToken->id);
                $data = $this->absensi->getJournalArchives($gradeID, $date, $teacher->staff_id);
            }
    
            if(count($data) > 0)
            {
                foreach($data as $res)
                {
                    $res->homework = $this->absensi->getHomeworkArchive($res->journal_id);
                    if(! empty($res->homework))
                    {
                        $res->homework = [
                            'title' => $res->homework->homework_title,
                            'due_date' => $res->homework->due_date
                        ];
                    }
                }
            }
    
            return $this->response->setJSON([$data, $decodedToken]);
        }
    }

    public function getAnggotaRombel($grade)
    {
        $student = $this->absensi->kelas->getClassMember($grade);
        return $this->response->setJSON($student);
    }

    public function getJadwal($day, $grade)
    {
        $schedule = $this->absensi->getJadwal($this->days[$day], $grade);
        $formatter = [];
        foreach($schedule as $res)
        {
            $formatter[] = [
                'id' => $res->schedule_id,
                'text' => $res->lesson_name
            ];
        }

        return $this->createResponse($formatter, 'is_admin');
    }

    public function getRombel()
    {
        $data = $this->absensi->getRombel();
        $formatter = [];
        foreach($data as $res)
        {
            $formatter[] = [
                'id' => $res->grade_id,
                'text' => $res->grade_name
            ];
        }

        return $this->response->setJSON($formatter);
    }

    public function getJournal($journalID)
    {
        $jurnal = $this->absensi->getJournal($journalID);

        if($jurnal['homework'] !== null)
        {
            $date = explode(' ', $jurnal['homework']->due_date);
            $jurnal['homework']->due_date = $date[0];
        }

        return $this->createResponse($jurnal);
    }

    public function copyJournal($scheduleID, $date)
    {
        if(valid_token())
        {
            $hasCreated = $this->absensi->journalHasCreatedBefore($scheduleID, $date);
            if($hasCreated !== false)
            {
                return $this->response->setJSON([
                    'status'    => 'OK',
                    'msg'       => lang('AdminAbsensi.absensi_salin_jurnal_sukses'),
                    'id'        => $hasCreated,
                ]);
            }
            else 
            {
                return $this->response->setJSON([
                    'status'    => 'ERROR',
                    'msg'       => lang('AdminAbsensi.absensi_salin_jurnal_gagal'),
                    'id'        => null
                ]);
            }
        }
    }

    public function savePresence($journalID, $date)
    {
        if(valid_token())
        {
            $data = $this->request->getPost('absen');
            $request = json_decode($data, true);
    
            foreach($request as $key)
            {
                $this->absensi->savePresence($key, $journalID, $date);
            }
    
            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function validateMark()
    {
        if(valid_token())
        {
            $mark = ['presence_mark' => $this->request->getPost('presence_mark')];
    
            $rules = [
                'presence_mark' => 'required',
            ];
    
            $messages = [
                'presence_mark' => [
                    'required' => lang('AdminAbsensi.absensi_izin_error')
                ],
            ];
    
            $validation = [$rules, $messages];
    
            if(! $this->validate($validation[0], $validation[1]))
            {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            }
            else 
            {
                return $this->response->setJSON([
                    'code' => '200',
                    'msg' => 'OK',
                ]);
            }
        }
    }

    public function save($scheduleID, $date, $includeHomework)
    {
        if(valid_token())
        {
            if($includeHomework === 'true')
            {
                $includeHomework = true;
            }
            else 
            {
                $includeHomework = false;
            }
    
            $validation = $this->validation($includeHomework); // [0 => $rules, 1 => $messages]
    
            if(! $this->validate($validation[0], $validation[1]))
            {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            }
            else 
            {
                $data = $this->formData();
                $saved = null;
                if($includeHomework) 
                {
                    // save journal with homework
                    $saved = $this->absensi->saveJournal($data, $scheduleID, $date, true);
                }
                else
                {
                    // save journal without homework
                    $saved = $this->absensi->saveJournal($data, $scheduleID, $date);
                }
                
                return $this->response->setJSON([
                    'code' => '200',
                    'data' => $saved,
                ]);
            }
        }
    }

    private function validation($includeHomework)
    {
        $form = $this->formData();

        $rules = [
            'description'   => 'required',
        ];

        $messages = [
            'description' => [
                'required' => lang('AdminAbsensi.absensi_err_jurnal_required')
            ],
        ];

        if($includeHomework)
        {
            $homeworkRules = [
                'homework_title'        => 'required',
                'homework_description'  => 'required',
                'due_date'              => 'required|valid_date[Y-m-d]'
            ];

            $homeworkMessages = [
                'homework_title' => [
                    'required' => lang('AdminAbsensi.absensi_err_title_required')
                ],
                'homework_description' => [
                    'required' => lang('AdminAbsensi.absensi_err_desc_required')
                ],
                'due_date' => [
                    'required'      => lang('AdminAbsensi.absensi_err_duedate_required'),
                    'valid_date'    => lang('AdminAbsensi.absensi_err_duedate_format')
                ],
            ];

            foreach($homeworkRules as $rule => $val)
            {
                $rules[$rule] = $val;
            }

            foreach($homeworkMessages as $msg => $val)
            {
                $messages[$msg] = $val;
            }
        }

        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'description'           => $this->request->getPost('description'),
            'homework_title'        => $this->request->getPost('homework_title'),
            'homework_description'  => $this->request->getPost('homework_description'),
            'due_date'              => $this->request->getPost('due_date')
        ];
    }

    public function checkJournal($scheduleID, $date)
    {
        $jurnal = $this->absensi->journalExists($scheduleID, $date);
        if(! $jurnal)
        {
            return $this->createResponse([
                'status'    => 'false',
                'id'        => null,
            ]);
        }
        else 
        {
            return $this->createResponse([
                'status'    => 'true',
                'id'        => $jurnal[0]->journal_id,
            ]);
        }
    }
}