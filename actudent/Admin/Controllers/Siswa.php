<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\SiswaModel;
use Actudent\Admin\Models\KelasModel;

class Siswa extends Actudent
{
    /**
     * @var Actudent\Admin\Models\SiswaModel
     */
    private $siswa;

    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    private $kelas;

    public function __construct()
    {
        $this->siswa = new SiswaModel;
        $this->kelas = new KelasModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminSiswa.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\siswa\siswa-view');
    }

    public function getDataSiswa($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search = '')
    {
        $data = $this->siswa->getSiswaQuery($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search);
        $rows = $this->siswa->getSiswaRows($searchBy, $whereClause, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function save($id = null)
    {
        $validation = $this->validation($id); // [0 => $rules, 1 => $messages]
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
                $this->siswa->insert($data);
            }
            // else
            // {
            //     $this->ortu->update($data, $id);
            // }
            
            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }

    private function validation($id)
    {
        $form = $this->formData();
        $rules = [
            'student_nis'   => "required|is_natural|min_length[9]|max_length[10]|is_unique[tb_student.student_nis,student_id,$id]",
            'student_name'  => 'required',
            'parent_id'     => 'required|is_natural',
        ];

        $messages = [
            'student_nis' => [
                'required'      => lang('AdminSiswa.siswa_err_nis_required'),
                'is_natural'    => lang('AdminSiswa.siswa_err_nis_natural'),
                'min_length'    => lang('AdminSiswa.siswa_err_nis_minlength'),
                'max_length'    => lang('AdminSiswa.siswa_err_nis_maxlength'),
                'is_unique'     => lang('AdminSiswa.siswa_err_nis_unique'),
            ],
            'student_name' => [
                'required'      => lang('AdminSiswa.siswa_err_name_required'),
            ],
            'parent_id' => [
                'required'      => lang('AdminSiswa.siswa_err_parent_required'),
                'is_natural'    => lang('AdminSiswa.siswa_err_parent_natural'),
            ]
        ];
        
        return [$rules, $messages];
    }

    public function searchParents($keyword = '')
    {
        return $this->response->setJSON($this->siswa->getParents($keyword));
    }

    public function getKelas()
    {
        return $this->response->setJSON($this->kelas->getKelas());
    }

    private function formData()
    {
        return [
            'student_nis'   => $this->request->getPost('student_nis'),
            'student_name'  => $this->request->getPost('student_name'),
            'parent_id'     => $this->request->getPost('parent_id'),
        ];
    }
}