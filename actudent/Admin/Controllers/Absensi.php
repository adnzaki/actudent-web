<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AbsensiModel;
use Actudent\Guru\Models\SchedulePresenceModel;
use PDFCreator;
use OstiumDate;

class Absensi extends Actudent
{
    /**
     * @var Actudent\Admin\Models\AbsensiModel
     */
    private $absensi;

    /**
     * @var Actudent\Guru\Models\SchedulePresenceModel
     */
    protected $jadwalHadir;

    private $pdfCreator;

    private $ostiumDate;

    private $days = [
        'minggu', 'senin', 'selasa',
        'rabu', 'kamis', 'jumat', 'sabtu'
    ];

    public function __construct()
    {
        $this->absensi = new AbsensiModel;
        $this->jadwalHadir = new SchedulePresenceModel;
        $this->pdfCreator = new PDFCreator;
        $this->ostiumDate = new OstiumDate;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminAbsensi.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\absensi\absensi-view');
    }

    public function exportJournal($gradeID, $day, $date)
    {
        $data                   = $this->common();
        $data['title']          = lang('AdminAbsensi.absensi_judul_laporan_jurnal');
        $data['grade']          = $this->absensi->kelas->getClassDetail($gradeID);
        $gradeMember            = $this->absensi->kelas->getClassMember($gradeID);
        $data['gradeMember']    = count($gradeMember);
        $data['day']            = $this->days[$day];
        $data['date']           = $this->ostiumDate->format('d-MM-Y', reverse($date, '-', '-'));
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

        $this->pdfCreator->create($html, $filename, true, 'A4', 'portrait');
        //return $html;
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
        return $this->response->setJSON($this->_getListAbsensi($grade, $journal, $date));
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
                    'status'    => '',
                    'note'      => '',
                    'statusID'  => '',
                ];
            }
        }

        return $presenceWrapper;
    }

    public function getJournalArchives($gradeID, $date)
    {
        if($_SESSION['userLevel'] === '1')
        {
            $data = $this->absensi->getJournalArchives($gradeID, $date);
        }
        else 
        {
            $teacher = $this->jadwalHadir->getTeacherByUserID($_SESSION['id']);
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

        return $this->response->setJSON($data);
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

        return $this->response->setJSON($formatter);
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
        $formatter = [];

        if($jurnal['homework'] !== null)
        {
            foreach($jurnal['homework'] as $key)
            {
                $date = explode(' ', $key->due_date);
                $key->due_date = $date[0];
            }
        }

        return $this->response->setJSON($jurnal);
    }

    public function copyJournal($scheduleID, $date)
    {
        $hasCreated = $this->absensi->journalHasCreatedBefore($scheduleID, $date);
        $result = [];
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

    public function savePresence($status, $journalID, $date)
    {
        $data = $this->request->getPost('absen');
        $request = json_decode($data, true);

        foreach($request as $key)
        {
            $this->absensi->savePresence($key, $journalID, $date);
        }

        return $this->response->setJSON(['status' => 'OK']);
    }

    public function validateMark()
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

    public function save($scheduleID, $date, $includeHomework)
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
            $saved;
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
            return $this->response->setJSON([
                'status'    => 'false',
                'id'        => null,
            ]);
        }
        else 
        {
            return $this->response->setJSON([
                'status'    => 'true',
                'id'        => $jurnal[0]->journal_id,
            ]);
        }
    }
}