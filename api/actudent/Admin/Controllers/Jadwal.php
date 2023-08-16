<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\JadwalModel;

class Jadwal extends \Actudent
{
    private $jadwal;

    public function __construct()
    {
        $this->jadwal = new JadwalModel;
    }

    public function getLessons($grade)
    {
        $data = $this->jadwal->getLessons($grade);
        $lessons = [];
        if($data !== false)
        {
            $lessons = $data;
        }

        $className = $this->jadwal->kelas->getClassDetail($grade);
        $response = [
            'class_name'    => $className->grade_name,
            'class_id'      => $className->grade_id,
            'lessons'       => $lessons,
        ];

        return $this->createResponse($response, 'is_admin');
    }

    public function lessonOptionsWrapper($grade)
    {
        $data = [
            'normalList'    => $this->getLessonsForSchedule($grade),
            'inactiveList'  => $this->getInactiveSchedules($grade)
        ];

        return $this->createResponse($data, 'is_admin');
    }

    private function getLessonsForSchedule($grade)
    {
        $data = $this->jadwal->getLessons($grade);
        $response = [];
        if($data !== false)
        {
            foreach($data as $res)
            {
                $response[] = [
                    'id' => $res->lessons_grade_id,
                    'text' => $res->lesson_name,
                ];
            }
        }
        
        return $response;
    }

    public function getScheduleSettings()
    {
        $alokasi = $this->jadwal->getScheduleTime();
        $mulai = $this->jadwal->getStartTime();

        // If $mulai is float/decimal value, convert it to minute
        if(gettype($mulai) !== 'integer')
        {
            $minute = $this->convertToMinute($mulai);
        }
        else
        {
            $minute = '0';
        }

        return $this->createResponse([
            'alokasi'   => $alokasi,
            'mulai'     => $this->normalizeTime(floor($mulai)) . ':' . $this->normalizeTime($minute),
        ], 'is_admin');
    }

    private function getInactiveSchedules($grade)
    {
        $data = $this->jadwal->getInactiveSchedules($grade);
        $response = [];
        if(count($data) > 0)
        {
            foreach($data as $res)
            {
                $activeJournal = $this->jadwal->getActiveJournal($res->schedule_id);

                $response[] = [
                    'id'    => "{$res->schedule_id}-{$res->lessons_grade_id}",
                    'text'  => "$res->lesson_name (ID: $res->schedule_id, " .
                                get_lang('AdminJadwal.jadwal_jurnal_aktif') .
                                ": $activeJournal)"
                ];
            }
        }

        return $response;
    }

    public function saveSettings()
    {
        if(is_admin()) {
            $form = [
                'lesson_hour'   => $this->request->getPost('lesson_hour'),
                'start_time'    => $this->request->getPost('start_time')
            ];
    
            $validation = $this->settingValidation($form);
            if(! validate($validation[0], $validation[1]))
            {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            }
            else
            {
                $this->jadwal->updateSettings($form);
                
                return $this->response->setJSON([
                    'code' => '200',
                ]);
            }
        }
    }

    private function settingValidation($data)
    {
        $form = $data;
        $rules = [
            'lesson_hour' => 'required|is_natural',
            'start_time'  => 'required|regex_match[([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}]',
        ];

        $messages = [
            'lesson_hour' => [
                'required'      => get_lang('AdminJadwal.jadwal_alokasi_required'),
                'is_natural'    => get_lang('AdminJadwal.jadwal_alokasi_natural'),
            ],
            'start_time' => [
                'required'      => get_lang('AdminJadwal.jadwal_mulai_required'),
                'regex_match'   => get_lang('AdminJadwal.jadwal_mulai_format'),
            ]
        ];
        
        return [$rules, $messages];
    }

    public function saveSchedules($day)
    {
        if(is_admin())
        {
            $request = $this->request->getPost('jadwal');
            $deleteSchedules = $this->request->getPost('hapus');
            $data = json_decode($request, true);
            $deleteSchedules = json_decode($deleteSchedules, true);
            $alokasi = $this->jadwal->getScheduleTime();
            $mulai = $this->jadwal->getStartTime();
    
            if(count($data) > 0)
            {
                $normalTimeSchedule = $this->exactDuration($data, $alokasi);
                $wrapper = [];
        
                foreach($normalTimeSchedule as $res)
                {
                    $penambah = $res['durasi'] / 60;
                    $lastDecimalDigit = (int)substr($penambah, -1);

                    if($lastDecimalDigit >= 5) {
                        $penambah += 0.00000000000001;
                    }

                    $selesai = $mulai + $penambah;
                    $getMinute = $this->convertToMinute($selesai);
                    $waktuSelesai = $this->normalizeTime(floor($selesai)) . '.' . $this->normalizeTime($getMinute);
        
                    // If $mulai is float/decimal value, convert it to minute
                    if(gettype($mulai) !== 'integer')
                    {
                        $minute = $this->convertToMinute($mulai);
                    }
                    else
                    {
                        $minute = '0';
                    }
        
                    $wrapper[] = [
                        'schedule_id'       => $res['id'],
                        'lessons_grade_id'  => $res['val'],
                        'room_id'           => $res['ruang'],
                        'schedule_semester' => $this->jadwal->semester, // don't forget to change it in every period!!
                        'schedule_day'      => $day,
                        'duration'          => $res['alokasi'],
                        'schedule_start'    => $this->normalizeTime(floor($mulai)) . '.' . $this->normalizeTime($minute),
                        'schedule_end'      => $waktuSelesai,
                        'schedule_order'    => $res['index'],
                        'last_decimal'      => $lastDecimalDigit
                    ];
        
                    $mulai = $selesai;
                }
    
                $this->jadwal->saveSchedules($wrapper);
            }
    
            if(count($deleteSchedules) > 0)
            {
                $this->jadwal->deleteSchedules($deleteSchedules);
            }
    
            return $this->response->setJSON([
                'status' => '200',
                'msg' => 'OK',
                'data'  => $wrapper
            ]);            
        }
    }

    public function getRooms()
    {
        $data = $this->jadwal->getRoomList();
        $response = [];
        if($data !== false)
        {
            foreach($data as $res)
            {
                $response[] = [
                    'id' => $res->room_id,
                    'text' => "$res->room_name",
                ];
            }
        }
        
        return $this->createResponse($response);
    }

    private function convertToMinute($decimalValue)
    {
        $floatToMinute = $decimalValue * 60;
        return $floatToMinute % 60;
    }

    private function normalizeTime($value)
    {
        return ($value < 10) ? '0' . $value : $value;
    }

    private function exactDuration($array, $alokasi)
    {
        $formatted = [];

        foreach($array as $key => $val)
        {
            $duration = 0;
            if(preg_match('/[^0-9]/', $val['duration']) === 1)
            {
                continue;
            }
            else 
            {
                if(preg_match('/break/', $val['id']) === 1)
                {
                    $duration = $val['duration'];
                }
                else 
                {
                    $duration = $val['duration'] * $alokasi;
                }
    
                $formatted[] = [
                    'id' => $val['id'], // schedule_id or new schedule index
                    'val' => $val['val'], // lessons_grade_id
                    'ruang' => $val['room'],
                    'alokasi' => $val['duration'],
                    'durasi' => $duration,
                    'index' => $val['index'],
                ];
            }            
        }

        return $formatted;
    }

    public function getSchedules($grade)
    {
        $days = [
            'senin', 'selasa', 'rabu',
            'kamis', 'jumat', 'sabtu'
        ];

        $response = [];
        $wrapper = [];
        
        foreach($days as $key => $val)
        {
            $response[$val] = $this->jadwal->getSchedules($grade, $val);
        }
        
        foreach($response as $key => $val)
        {
            $formatter = [];
            $finish = '';
            $diff = 0;
            $index = 0;
            foreach($val as $arr)
            {
                if($index === 0)
                {
                    $formatter[] = $arr;
                }
                else 
                {
                    $diff = $this->countDiff($finish, $arr->schedule_start);
                    if($diff > 0)
                    {
                        $breakDuration = round($diff * 60);
                        $break = [
                            'schedule_id'       => null,
                            'lesson_grade_id'   => null,
                            'room_id'           => null,
                            'lesson_code'       => 'REST',
                            'lesson_name'       => get_lang('AdminJadwal.jadwal_istirahat'),
                            'duration'          => (string)$breakDuration,
                            'schedule_start'    => $finish,
                            'schedule_end'      => $arr->schedule_start,
                            'journal_filled'    => null,
                        ];
    
                        $formatter[] = $break;
                    }
                    array_push($formatter, $arr);
                }
                $finish = $arr->schedule_end;
                
                $index++;
            }
            $wrapper[$key] = $formatter;            
        }

        $classGroup = $this->jadwal->kelas->getClassDetail($grade);

        $data = [
            'class_name' => $classGroup->grade_name,
            'schedule' => $wrapper,
        ];

        return $this->createResponse($data, 'is_admin');
    }
    
    private function countDiff($time1, $time2)
    {
        $hour1 = $this->numberValue($time1);
        $hour2 = $this->numberValue($time2);
        $diff = $hour2 - $hour1;
        
        return $diff;
    }

    public function numberValue($string)
    {
        $minute = substr($string, 3, 2);
        $decimal = $minute / 60;
        $hour = substr($string, 0, 2);

        return $hour + $decimal;
    }

    public function getLessonDetail($id)
    {
        $data = $this->jadwal->getLessonDetail($id);
        return $this->createResponse($data[0], 'is_admin');
    }

    public function getLessonOptions($grade)
    {
        $formatter = [];
        $data = $this->jadwal->getLessonOptions($grade);
        foreach($data as $res)
        {
            $formatter[] = [
                'id' => $res->lesson_id,
                'text' => "{$res->lesson_name} ({$res->lesson_code})",
            ];
        }
        
        return $this->createResponse($formatter);
    }

    public function deleteLesson()
    {
        if(is_admin())
        {
            $idString = $this->request->getPost('id');
            $idWrapper = [];
            if(strpos($idString, '-') !== false)
            {
                $idWrapper = explode('-', $idString);
                foreach($idWrapper as $id)
                {
                    $this->jadwal->delete($id);
                }
            }
            else 
            {
                $this->jadwal->delete($idString);
            }
    
            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function saveLesson($grade, $id = null)
    {
        if(is_admin())
        {
            $validation = $this->validation(); // [0 => $rules, 1 => $messages]
            if(! validate($validation[0], $validation[1]))
            {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            }
            else
            {
                $data = $this->formData();
                if($id === null) 
                {
                    $data['grade_id'] = $grade;
                    $this->jadwal->insert($data);
                }
                else
                {
                    $this->jadwal->update($data, $id);
                }
                
                return $this->response->setJSON([
                    'code' => '200',
                ]);
            }
        }
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'lesson_id'      => 'required|is_natural',
            'teacher_id'    => 'required|is_natural',
        ];

        $messages = [
            'lesson_id' => [
                'required'      => get_lang('AdminJadwal.jadwal_err_lesson_required'),
                'is_natural'    => get_lang('AdminJadwal.jadwal_err_lesson_natural'),
            ],
            'teacher_id' => [
                'required'      => get_lang('AdminJadwal.jadwal_err_teacher_required'),
                'is_natural'    => get_lang('AdminKelas.kelas_err_teacher_natural'),
            ]
        ];
        
        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'lesson_id'     => $this->request->getPost('lesson_id'),
            'teacher_id'    => $this->request->getPost('teacher_id'),
        ];
    }
}