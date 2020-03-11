<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\KelasModel;

class Kelas extends Actudent
{
    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    private $kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Kelas';

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\kelas\kelas-view');
    }

    public function getDataKelas($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getKelasQuery($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->kelas->getKelasRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function getClassDetail($id)
    {
        return $this->response->setJSON($this->kelas->getClassDetail($id));
    }

    public function addMember($id, $grade)
    {
        $this->kelas->addMember($id, $grade);
        
        return $this->response->setJSON([
            'msg' => 'OK'
        ]);
    }

    public function removeMember($id)
    {
        $this->kelas->removeMember($id);
        
        return $this->response->setJSON([
            'msg' => 'OK'
        ]);
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
        return $this->response->setJSON($this->kelas->getClassMember($id));
    }

    public function getUnregisteredStudents($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getUnregisteredStudents($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->kelas->unregisteredStudentsRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function save($id = null)
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

    public function delete($grade)
    {
        $this->kelas->delete($grade);
        return $this->response->setJSON([
            'code' => 'OK',
        ]);
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
                'required'      => lang('AdminKelas.kelas_err_name_required'),
            ],
            'teacher_id' => [
                'required'      => lang('AdminKelas.kelas_err_teacher_required'),
                'is_natural'    => lang('AdminKelas.kelas_err_teacher_natural'),
            ]
        ];
        
        return [$rules, $messages];
    }

    public function findTeacher($keyword = '')
    {
        return $this->response->setJSON($this->kelas->findTeacher($keyword));
    }

    private function formData()
    {
        return [
            'grade_name'    => $this->request->getPost('grade_name'),
            'teacher_id'    => $this->request->getPost('teacher_id'),
        ];
    }
}