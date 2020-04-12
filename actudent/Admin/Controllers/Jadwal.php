<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\JadwalModel;

class Jadwal extends Actudent
{
    private $jadwal;

    public function __construct()
    {
        $this->jadwal = new JadwalModel;
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('AdminJadwal.jadwal_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\jadwal\jadwal-view');
    }

    public function getLessons($grade)
    {
        $data = $this->jadwal->getLessons($grade);
        $lessons = [];
        if($data !== false)
        {
            $lessons = $data;
        }

        $className = $this->jadwal->rombel->getClassDetail($grade);
        $response = [
            'class_name'    => $className->grade_name,
            'class_id'      => $className->grade_id,
            'lessons'       => $lessons,
        ];

        return $this->response->setJSON($response);
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
                            'lesson_grade_id' => null,
                            'lesson_code' => 'REST',
                            'lesson_name' => lang('AdminJadwal.jadwal_istirahat'),
                            'duration' => (string)$breakDuration,
                            'schedule_start' => $finish,
                            'schedule_end' => $arr->schedule_start,
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

        $classGroup = $this->jadwal->rombel->getClassDetail($grade);

        $data = [
            'class_name' => $classGroup->grade_name,
            'schedule' => $wrapper,
        ];

        return $this->response->setJSON($data);
    }
    
    private function countDiff($time1, $time2)
    {
        $hour1 = $this->numberValue($time1);
        $hour2 = $this->numberValue($time2);
        $diff = $hour2 - $hour1;
        
        return $diff;
    }

    private function numberValue($string)
    {
        $minute = substr($string, 3, 2);
        $decimal = $minute / 60;
        $hour = substr($string, 0, 2);

        return $hour + $decimal;
    }

    public function getLessonDetail($id)
    {
        $data = $this->jadwal->getLessonDetail($id);
        return $this->response->setJSON($data[0]);
    }

    public function searchLessons($grade)
    {
        $search = $this->request->getPost('searchTerm');
        
        $formatter = [];
        if(! empty($search))
        {
            $data = $this->jadwal->searchLessons($search, $grade);
            foreach($data as $res)
            {
                $formatter[] = [
                    'id' => $res->lesson_id,
                    'text' => $res->lesson_name,
                ];
            }
        }
        
        return $this->response->setJSON($formatter);
    }

    public function deleteLesson()
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

    public function saveLesson($id = null)
    {
        $validation = $this->validation(); // [0 => $rules, 1 => $messages]
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
            if($id === null) 
            {
                $data['grade_id'] = $this->request->getPost('grade_id');
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

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'lesson_id'      => 'required|is_natural',
            'teacher_id'    => 'required|is_natural',
        ];

        $messages = [
            'lesson_id' => [
                'required'      => lang('AdminJadwal.jadwal_err_lesson_required'),
                'is_natural'    => lang('AdminJadwal.jadwal_err_lesson_natural'),
            ],
            'teacher_id' => [
                'required'      => lang('AdminKelas.kelas_err_teacher_required'),
                'is_natural'    => lang('AdminKelas.kelas_err_teacher_natural'),
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