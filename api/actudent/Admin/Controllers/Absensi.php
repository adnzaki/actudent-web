<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Models\AbsensiModel;
use Actudent\Admin\Models\JadwalModel;
use Actudent\Guru\Models\JadwalKehadiranModel;
use Actudent\Admin\Models\SettingModel;
use PDFCreator;

class Absensi extends \Actudent
{
    /**
     * @var \Actudent\Admin\Models\AbsensiModel
     */
    private $absensi;

    /**
     * @var \Actudent\Admin\Models\JadwalModel
     */
    private $jadwal;

    /**
     * @var \Actudent\Guru\Models\JadwalKehadiranModel
     */
    protected $jadwalHadir;

    /**
     * @var \PDFCreator
     */
    private $pdfCreator;

    private $reportSetting;



    protected $days = [
        'minggu', 'senin', 'selasa',
        'rabu', 'kamis', 'jumat', 'sabtu'
    ];

    public function __construct()
    {
        $this->absensi = new AbsensiModel;
        $this->jadwal = new JadwalModel;
        $this->jadwalHadir = new JadwalKehadiranModel;
        $this->pdfCreator = new \PDFCreator;
        $this->reportSetting = new SettingModel;
    }

    public function excelMonthlySummary($month, $year, $gradeId, $token)
    {
        if(valid_token($token)) {
            $excel          = new \ExcelCreator;
            $signs          = $this->resources->getReportData($token);
            $grade          = $this->absensi->kelas->getClassDetail($gradeId);
            $data           = $this->_getMonthlySummary($month, $year, $gradeId);
            $spreadsheet    = $excel->spreadsheet;
            $monthYear      = os_date()->getMonthName($month) . ' ' . $year;
            $title          = $monthYear . '-' . $grade->grade_name;
            $totalDays      = os_date()->daysInMonth($month, $year);
            $signSetting    = $this->reportSetting->getSignSetting('monthly_presence_sign');
    
            // set properties
            $spreadsheet->getProperties()
                        ->setCreator('Wolestech')
                        ->setLastModifiedBy('Actudent')
                        ->setTitle('Rekap Absen Bulanan ' . $title);
    
            $spreadsheet->setActiveSheetIndex(0);
    
            $titleCell  = ["Daftar Absensi Bulan {$monthYear}" ];
            $gradeCell  = ["Kelas {$grade->grade_name}"];
            $header     = ['No.', 'NIS', 'Nama Siswa', 'Tanggal'];
            $note       = ['Keterangan'];
            $summary    = ['H', 'I', 'S', 'A'];
            $knownBy    = [
                ['Mengetahui,'],
                ['Kepala Sekolah']
            ];
    
            $headMaster = [
                [$signs['kepalaSekolah']],
                ['NIP. ' . $signs['nipKepsek']]
            ];
    
            $includeWaka = ['Waka. Kurikulum'];
            $wakaName    = [
                [$signs['wakaKurikulum']],
                ['NIP. ' . $signs['nipWakasek']]
            ];
    
            $dateLocation = [
                [$signs['lokasiSekolah'] . ', ' . os_date()->fullDate('', '', '', false)],
                ['Wali Kelas']
            ];
    
            $homeroomTeacher = [
                [$grade->staff_name],
                ['NIP/NIK. ..............................']
            ];
            
            $record = [];
            $no = 1;
            foreach($data['students'] as $key) {
                $initRecord = [$no, $key['nis'], $key['name']];
                $replacements = [
                    '1' => '●', 3 => 's',
                    '2' => 'i', 0 => '×'                 
                ];
    
                $formattedStatus = [];
                foreach($key['data'] as $k) {
                    if($k !== '-') {
                        $k = $replacements[$k];
                    }
    
                    $formattedStatus[] = $k;
                }
    
                $presenceSummary = array_values($key['summary']);
    
                $record[] = array_merge($initRecord, $formattedStatus, $presenceSummary);
                $no++;
            }
    
            $dateFields = [
                28 => 'AE', 29 => 'AF',
                30 => 'AG', 31 => 'AH',
                
                // for next field
                32 => 'AI', 33 => 'AJ',
                34 => 'AK', 35 => 'AL'
            ];
    
            $noteFields     = $dateFields[$totalDays + 1];
            $endFields      = $dateFields[$totalDays + 4];
            $endRows        = 5 + count($data['students']);
            $signRows       = $endRows + 2;
            $spaces         = 6;
            $spacedSignRows = $signRows + $spaces;
    
            // fill cell...
            $excel->fillCell($titleCell);
            $excel->fillCell($gradeCell, 'A2');
            $excel->fillCell($header, 'A4');
            $excel->fillCell($data['days'], 'D5');
            $excel->fillCell($note, $noteFields . '4');
            $excel->fillCell($summary, $noteFields . '5');
            $excel->fillCell($record, 'A6');
            
            if($signSetting === 'kepsek,waka,walas') {
                $excel->fillCell($knownBy, 'B' . $signRows);
                $excel->fillCell($headMaster, 'B' . $spacedSignRows);
                $excel->fillCell($includeWaka, 'K' . ($signRows + 1));
                $excel->fillCell($wakaName, 'K' . $spacedSignRows);
                $excel->fillCell($dateLocation, 'AB' . $signRows);
                $excel->fillCell($homeroomTeacher, 'AB' . $spacedSignRows);                
            } elseif($signSetting === 'kepsek,walas') {
                $excel->fillCell($knownBy, 'B' . $signRows);
                $excel->fillCell($headMaster, 'B' . $spacedSignRows);
                $excel->fillCell($dateLocation, 'AB' . $signRows);
                $excel->fillCell($homeroomTeacher, 'AB' . $spacedSignRows);  
            } else {
                $excel->fillCell($dateLocation, 'AB' . $signRows);
                $excel->fillCell($homeroomTeacher, 'AB' . $spacedSignRows);  
            }
    
            // merge cells
            $excel->mergeCells('A1:' . $endFields . '1');
            $excel->mergeCells('A2:' . $endFields . '2');
            $excel->mergeCells('A4:A5');
            $excel->mergeCells('B4:B5');
            $excel->mergeCells('C4:C5');
            $excel->mergeCells('D4:' . $dateFields[$totalDays] . '4');
            $excel->mergeCells($noteFields . '4:' . $endFields . '4');
    
            $tableStyle = [
                'borders' => [
                    'top' => ['borderStyle' => $excel->border::BORDER_THIN],
                    'bottom' => ['borderStyle' => $excel->border::BORDER_THIN],
                    'right' => ['borderStyle' => $excel->border::BORDER_THIN],
                    'left' => ['borderStyle' => $excel->border::BORDER_THIN],
                ],
            ];
    
            $titleStyle = [
                'alignment' => [
                    'horizontal' => $excel->alignment::HORIZONTAL_CENTER,
                    'vertical' => $excel->alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ],
            ];
    
            $headerStyle = [
                'alignment' => $titleStyle['alignment'],
                'fill' => [
                    'fillType' => $excel->fill::FILL_SOLID,
                    'color' => ['argb' => 'D9E1F2'],
                ],
                'borders' => $tableStyle['borders']
            ];
    
            $numStyle = [
                'alignment' => $titleStyle['alignment'],
                'borders' => $tableStyle['borders']
            ];
    
            // style for presence status
            $presenceRecordStyle = [
                'alignment' => $titleStyle['alignment'],
                'borders' => $tableStyle['borders']
            ];
    
            $signsStyle = [
                'font' => [
                    'bold' => true
                ]
            ];
    
            $excel->applyStyle($titleStyle, 'A1:' . $endFields . '2');
            $excel->applyStyle($tableStyle, 'A4:' . $endFields . $endRows);
            $excel->applyStyle($headerStyle, 'A4:' . $endFields . '5');
            $excel->applyStyle($numStyle, 'A6:' . 'B' . $endRows);
            $excel->applyStyle($presenceRecordStyle, 'D6:' . $endFields . $endRows);
            $excel->applyStyle($signsStyle, 'B'.$spacedSignRows.':AL'.$spacedSignRows);
    
            // set columns width and rows height
            $excel->setDefaultColumnWidth(4);
            $excel->setColumnWidth('A', 6);
            $excel->setColumnWidth('B', 15);
            $excel->setColumnWidth('C');
            $excel->setMultipleRowsHeight('6-' . $endRows, 18);
            
            $excel->save("$title.xlsx");
        }
    }

    public function exportMonthlySummary($month, $year, $gradeId, $token)
    {
        if(valid_token($token)) {
            $data = [];     
            foreach($this->resources->getReportData($token) as $key => $val) {
                $data[$key] = $val;
            }
    
            $title                  = 'Rekapitulasi Absensi Bulan ' . os_date()->getMonthName($month);
            $data['title']          = $title . ' ' . $year;
            $data['grade']          = $this->absensi->kelas->getClassDetail($gradeId);
            $data['data']           = $this->_getMonthlySummary($month, $year, $gradeId);
            $data['signSetting']    = $this->reportSetting->getSignSetting('monthly_summary_sign');
            
            $filename       = $data['title'] .'_'. time();
    
            $html = view('Actudent\Admin\Views\absensi\ekspor-rekap-bulanan', $data);
            // return $html;
            PDFCreator::create($html, $filename); 
        }
    }

    public function exportPeriodSummary($gradeId, $period, $year, $token)
    {
        if(valid_token($token)) {
            $data = [];        
            foreach($this->resources->getReportData($token) as $key => $val) {
                $data[$key] = $val;
            }

            $semester = $period === '1' ? 'Ganjil' : 'Genap';
            $yearPeriod = $year . ' / ' . ($year + 1);
    
            $title                  = 'Rekapitulasi Absensi Semester ' . $semester;
            $data['title']          = $title;
            $data['period']         = 'Tahun Ajaran ' . $yearPeriod;
            $data['grade']          = $this->absensi->kelas->getClassDetail($gradeId);
            $data['data']           = $this->_getPeriodSummary($gradeId, $period, $year);
            $filename               = $title . '_' . $yearPeriod . '_'. time();
            $data['signSetting']    = $this->reportSetting->getSignSetting('semester_summary_sign');
            
    
            $html = view('Actudent\Admin\Views\absensi\ekspor-rekap-semester', $data);
            // return $html;
            PDFCreator::create($html, $filename); 
        }
    }

    public function getPeriodSummary($gradeId, $period, $year)
    {
        if(valid_token()) {
            return $this->response->setJSON($this->_getPeriodSummary($gradeId, $period, $year));
        }
    }

    public function _getPeriodSummary($gradeId, $period, $year)
    {
        // 1 = Odd semester (start from July to December [month 7-12])
        // 2 = Even semester (start from January to June [month 1-6])
        $acceptedPeriod = [1 => range(7, 12), 2 => range(1, 6)];
        
        // generate start month
        $monthStart = $acceptedPeriod[$period][0] < 10 
                    ? '0' . $acceptedPeriod[$period][0]
                    : $acceptedPeriod[$period][0];
        
        // generate end month
        $monthEnd = $acceptedPeriod[$period][5] < 10 
                    ? '0' . $acceptedPeriod[$period][5]
                    : $acceptedPeriod[$period][5];
        
        $year = $period === '2' ? $year + 1 : $year;
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
        
                $result = array_merge(
                    $result[0],
                    $result[1],
                    $result[2],
                    $result[3],
                    $result[4],
                    $result[5],
                );
        
                $present = $this->getPresenceStatusNumber($result, '1');
                $permit = $this->getPresenceStatusNumber($result, '2');
                $sick = $this->getPresenceStatusNumber($result, 3);
                $absent = $this->getPresenceStatusNumber($result, 0);

                // reformatted to handle string
                $formatted = [
                    'present'   => $present === '-' ? 0 : $present,
                    'permit'    => $permit === '-' ? 0 : $permit,
                    'sick'      => $sick === '-' ? 0 : $sick,
                    'absent'    => $absent === '-' ? 0 : $absent
                ];

                // count incomplete absent
                $hasAbsent = $formatted['present'] + $formatted['permit'] + $formatted['sick'] + $formatted['absent'];
                $notAbsent = $journal - $hasAbsent;
    
                $wrapper[] = [
                    'nis'           => $res->student_nis,
                    'name'          => $res->student_name,
                    'present'       => $present . str_replace(['(', ')'], ['[', ']'], $this->getPercentage($present, $journal)),
                    'permit'        => $permit,
                    'sick'          => $sick,
                    'absent'        => $absent,
                    'incomplete'    => $notAbsent
                ];
            }
        } else {
            $wrapper = get_lang('Admin.no_data');
        }

        $response = [
            'activeDays'    => $journal,
            'summary'       => $wrapper,
            'year'          => $year
        ];

        return $response;
    }

    private function getPercentage($a, $b)
    {
        if($a > 0) {
            return ' (' . number_format(($a / $b) * 100, 1) . '%)';
        }
    }

    private function getPresenceStatusNumber($array, $status)
    {
        $result = count(array_filter($array, fn($val) => $val === $status));

        return $result > 0 ? $result : '-';
    }

    public function getMonthlySummary($month, $year, $gradeId)
    {
        if(valid_token()) {
            return $this->response->setJSON($this->_getMonthlySummary($month, $year, $gradeId));
        }
    }
    
    private function _getMonthlySummary($month, $year, $gradeId)
    {
        // Load the class member
        $classMember = $this->absensi->kelas->getClassMember($gradeId);
        $studentPresence = [];
        
        foreach($classMember as $res) {
            $result = $this->countPresence($res->student_id, $gradeId, $month, $year);      
            $present = $this->getPresenceStatusNumber($result, '1');
            $permit = $this->getPresenceStatusNumber($result, '2');
            $sick = $this->getPresenceStatusNumber($result, 3);
            $absent = $this->getPresenceStatusNumber($result, 0);
            $studentPresence[] = [
                'name'      => $res->student_name,
                'nis'       => $res->student_nis,
                'data'      => $result,
                'summary'   => [
                    'present'   => $present,
                    'permit'    => $permit,
                    'sick'      => $sick,
                    'absent'    => $absent,
                ]
            ];
        }

        return [
            'days'      => range(1, os_date()->daysInMonth($month, $year)),
            'students'  => $studentPresence
        ];
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
                $presenceData[] = '-';
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
                        $presenceData[] = 0;
                    } else {
                        if(array_search(3, $todayPresence) !== false) {
                            $presenceData[] = 3;
                        } else {
                            if($todayPresence[0] === 1 && end($todayPresence) === 1) {    
                                $presenceData[] = 1;
                            } else {
                                $presenceData[] = end($todayPresence);
                            }
                        }
                        // If presence_status is 1 (present) in the first and last lesson hour...
                    }
                } else {
                    $presenceData[] = '-';
                }
            }
        }

        return $presenceData;
    }

    public function exportPresence($gradeID, $day, $date, $token)
    {
        if(valid_token($token)) {
            $data = [];
            
            foreach($this->resources->getReportData($token) as $key => $val) {
                $data[$key] = $val;
            }

            $data['title']  = get_lang('AdminAbsensi.absensi_judul_laporan_absen');
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
    
            foreach($journals as $res) {
                $lessonHours[] = $res->lesson_code;    
            }
    
            $studentPresence = [];
            foreach($gradeMember as $res) {
                $formatted = [];
                foreach($journals as $key) {
                    $presence = $this->absensi->getPresence($key->journal_id, $res->student_id, $date);
                    $status = ['Alfa', 'Hadir', 'Izin', 'Sakit'];
                    if($presence === null) {
                        $formatted[] = [
                            'journal_id'    => '-',
                            'status'        => '-',
                        ];
                    } else {
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
    
            $data['column']         = $lessonHours;
            $data['presence']       = $studentPresence;
            $data['colspan']        = count($lessonHours);
            $data['signSetting']    = $this->reportSetting->getSignSetting('daily_presence_sign');
    
            $html       = view('Actudent\Admin\Views\absensi\ekspor-absen', $data);
            $filename   = 'Laporan Absen '. $data['grade']->grade_name . ' ' . $date .'_'. time();
    
            PDFCreator::create($html, $filename);
        }
    }

    public function exportJournal($gradeID, $day, $date, $token)
    {
        if(valid_token($token)) {
            $data = [];
            
            foreach($this->resources->getReportData($token) as $key => $val) {
                $data[$key] = $val;
            }
    
            $data['title']          = get_lang('AdminAbsensi.absensi_judul_laporan_jurnal');
            $data['grade']          = $this->absensi->kelas->getClassDetail($gradeID);
            $gradeMember            = $this->absensi->kelas->getClassMember($gradeID);
            $data['gradeMember']    = count($gradeMember);
            $data['day']            = $this->days[$day];
            $data['date']           = os_date()->format('d-MM-Y', reverse($date, '-', '-'));
            $journals               = $this->absensi->getJournalByDate($date, $gradeID);
            $data['journals']       = $journals;
            $data['signSetting']    = $this->reportSetting->getSignSetting('daily_journal_sign');
    
            // get number of presence
            $presenceWrapper = [];
            $absentStudents = [];
            foreach($journals as $j) {
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
            PDFCreator::create($html, $filename);            
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
            get_lang('AdminAbsensi.absensi_alfa'),
            get_lang('AdminAbsensi.absensi_hadir'),
            get_lang('AdminAbsensi.absensi_izin'),
            get_lang('AdminAbsensi.absensi_sakit')
        ];

        foreach($student as $key) {          
            // Get presence of a student
            $presence = $this->absensi->getPresence($journal, $key->student_id, $date);

            if($presence !== null && $journal !== 'null') {
                $presenceWrapper[] = [
                    'id'        => $key->student_id,
                    'name'      => $key->student_name,
                    'status'    => $presenceCategory[$presence->presence_status],
                    'note'      => $presence->presence_mark,
                    'statusID'  => $presence->presence_status,
                ];
            } else {
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

    public function getAnggotaRombel($grade)
    {
        $student = $this->absensi->kelas->getClassMember($grade);
        return $this->createResponse($student);
    }

    public function getJadwal($day, $grade)
    {
        $schedule = $this->absensi->getJadwal($this->days[$day], $grade);
        $formatter = [];
        foreach($schedule as $res) {
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
        foreach($data as $res) {
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

        if($jurnal['homework'] !== null) {
            $date = explode(' ', $jurnal['homework']->due_date);
            $jurnal['homework']->due_date = $date[0];
        }

        return $this->createResponse($jurnal);
    }

    public function copyJournal($scheduleID, $date)
    {
        if(valid_token()) {
            $hasCreated = $this->absensi->journalHasCreatedBefore($scheduleID, $date);
            if($hasCreated !== false) {
                return $this->response->setJSON([
                    'status'    => 'OK',
                    'msg'       => get_lang('AdminAbsensi.absensi_salin_jurnal_sukses'),
                    'id'        => $hasCreated,
                ]);
            } else {
                return $this->response->setJSON([
                    'status'    => 'ERROR',
                    'msg'       => get_lang('AdminAbsensi.absensi_salin_jurnal_gagal'),
                    'id'        => null
                ]);
            }
        }
    }

    public function savePresence($journalID, $date)
    {
        if(valid_token()) {
            $data = $this->request->getPost('absen');
            $request = json_decode($data, true);
    
            foreach($request as $key) {
                $this->absensi->savePresence($key, $journalID, $date);
            }
    
            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function validateMark()
    {
        if(valid_token()) {
            $mark = ['presence_mark' => $this->request->getPost('presence_mark')];
    
            $rules = [
                'presence_mark' => 'required',
            ];
    
            $messages = [
                'presence_mark' => [
                    'required' => get_lang('AdminAbsensi.absensi_izin_error')
                ],
            ];
    
            $validation = [$rules, $messages];
    
            if(! $this->validate($validation[0], $validation[1])) {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            } else {
                return $this->response->setJSON([
                    'code' => '200',
                    'msg' => 'OK',
                ]);
            }
        }
    }

    public function save($scheduleID, $date, $includeHomework)
    {
        if(valid_token()) {
            if($includeHomework === 'true') {
                $includeHomework = true;
            } else {
                $includeHomework = false;
            }
    
            $validation = $this->validation($includeHomework); // [0 => $rules, 1 => $messages]
    
            if(! $this->validate($validation[0], $validation[1])) {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            } else {
                $data = $this->formData();
                $saved = null;
                if($includeHomework) {
                    // save journal with homework
                    $saved = $this->absensi->saveJournal($data, $scheduleID, $date, true);
                } else {
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
                'required' => get_lang('AdminAbsensi.absensi_err_jurnal_required')
            ],
        ];

        if($includeHomework) {
            $homeworkRules = [
                'homework_title'        => 'required',
                'homework_description'  => 'required',
                'due_date'              => 'required|valid_date[Y-m-d]'
            ];

            $homeworkMessages = [
                'homework_title' => [
                    'required' => get_lang('AdminAbsensi.absensi_err_title_required')
                ],
                'homework_description' => [
                    'required' => get_lang('AdminAbsensi.absensi_err_desc_required')
                ],
                'due_date' => [
                    'required'      => get_lang('AdminAbsensi.absensi_err_duedate_required'),
                    'valid_date'    => get_lang('AdminAbsensi.absensi_err_duedate_format')
                ],
            ];

            foreach($homeworkRules as $rule => $val) {
                $rules[$rule] = $val;
            }

            foreach($homeworkMessages as $msg => $val) {
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
        if(! $jurnal) {
            return $this->createResponse([
                'status'    => 'false',
                'id'        => null,
            ]);
        } else {
            return $this->createResponse([
                'status'    => 'true',
                'id'        => $jurnal[0]->journal_id,
            ]);
        }
    }
}