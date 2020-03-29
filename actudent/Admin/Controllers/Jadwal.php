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

    public function searchLessons()
    {
        $search = $this->request->getPost('searchTerm');
        
        $formatter = [];
        if(! empty($search))
        {
            $data = $this->jadwal->searchLessons($search);
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

    public function saveLesson($grade, $id = null)
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
                $this->jadwal->insert($grade, $data);
            }
            else
            {
                $this->jadwal->update($grade, $data, $id);
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