<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Models\KelasModel;

class Kelas extends \Actudent
{
    private $kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel;
    }

    public function getDataKelas($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getKelasQuery($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->kelas->getKelasRows($searchBy, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function getPreviousGrade($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getPreviousGrade($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->kelas->getPreviousGradeRows($searchBy, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function copyClassgroup()
    {
        if(is_admin()) {
            $selectedClasses = json_decode($this->request->getPost('selectedClasses'), true);
            foreach($selectedClasses as $id) {
                $detail = $this->kelas->getClassDetail($id);
                $member = $this->kelas->getClassMember($id);
                $values = [
                    'grade_name'        => $detail->grade_name,
                    'teacher_id'        => $detail->teacher_id,
                    'rombel_dapodik_id' => null
                ];
    
                // insert new classgroup
                $classId = $this->kelas->insert($values);
    
                // copy class member into new classgroup
                foreach($member as $student) {
                    $this->kelas->addMember($student->student_id, $classId);
                }

                $this->kelas->deactivateClassgroup($id);
            }

            return $this->response->setJSON([
                'status' => 'OK',
            ]);
        }
    }

    public function getClassDetail($id)
    {
        return $this->createResponse($this->kelas->getClassDetail($id));
    }

    public function addMember()
    {
        if(is_admin())
        {
            $id = $this->request->getPost('id');
            $grade = $this->request->getPost('grade');

            $this->kelas->addMember($id, $grade);
            
            return $this->response->setJSON([
                'msg' => 'OK'
            ]);
        }
    }

    public function removeMember($id)
    {
        if(is_admin())
        {
            $this->kelas->removeMember($id);
            
            return $this->response->setJSON([
                'msg' => 'OK'
            ]);
        }
    }

    public function emptyGroup($grade)
    {
        $this->kelas->emptyGroup($grade);
        
        return $this->response->setJSON([
            'msg' => 'OK'
        ]);
    }

    public function getClassMember($id)
    {
        return $this->createResponse($this->kelas->getClassMember($id), 'is_admin');
    }

    public function getUnregisteredStudents($gradeId, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getUnregisteredStudents($gradeId, $limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->kelas->unregisteredStudentsRows($gradeId, $searchBy, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function save($id = null)
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
                    $this->kelas->insert($data);
                }
                else
                {
                    $this->kelas->update($data, $id);
                }
                
                return $this->response->setJSON([
                    'code' => '200',
                ]);
            }
        }
    }

    public function delete()
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
                    $this->kelas->delete($id);
                }
            }
            else 
            {
                $this->kelas->delete($idString);
            }

            return $this->response->setJSON([
                'code' => 'OK',
            ]);
        }
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'grade_name'    => 'required',
            'teacher_id'    => 'required|is_natural',
        ];

        $messages = [
            'grade_name' => [
                'required'      => get_lang('AdminKelas.kelas_err_name_required'),
            ],
            'teacher_id' => [
                'required'      => get_lang('AdminKelas.kelas_err_teacher_required'),
                'is_natural'    => get_lang('AdminKelas.kelas_err_teacher_natural'),
            ]
        ];
        
        return [$rules, $messages];
    }

    public function findTeacher()
    {
        return $this->createResponse($this->kelas->findTeacher(), 'is_admin');
    }

    private function formData()
    {
        return [
            'grade_name'        => $this->request->getPost('grade_name'),
            'teacher_id'        => $this->request->getPost('teacher_id'),
            'rombel_dapodik_id' => null
        ];
    }
}