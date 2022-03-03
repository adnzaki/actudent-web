<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Core\Models\SubscriptionModel;
use Actudent\Admin\Models\SiswaModel;
use Actudent\Admin\Models\KelasModel;

class Siswa extends \Actudent
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
        $data['limit'] = $this->studentLimitation();
        $data['title'] = lang('AdminSiswa.page_title');

        return parse('Actudent\Admin\Views\siswa\siswa-view', $data);
    }

    public function getDataSiswa($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search = '')
    {
        $data = $this->siswa->getSiswaQuery($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search);
        $rows = $this->siswa->getSiswaRows($searchBy, $whereClause, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ], 'is_admin');
    }

    public function getDetailSiswa($id)
    {
        $data = $this->siswa->getStudentDetail($id);
        return $this->createResponse($data[0], 'is_admin');
    }

    public function save($id = null)
    {
        if(is_admin())
        {
            if($this->studentLimitation() === 'blocked')
            {
                return $this->response->setJSON([
                    'code' => '307',
                    'msg' => lang('AdminSiswa.siswa_overlimit'),
                ]);
            }
            else
            {
                $validation = $this->validation($id); // [0 => $rules, 1 => $messages]
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
                        $this->siswa->insert($data);
                    }
                    else
                    {
                        $this->siswa->update($data, $id);
                    }
                    
                    return $this->response->setJSON([
                        'code' => '200',
                    ]);
                }
            }
        }
    }

    public function getStudentLimit()
    {
        return $this->createResponse($this->studentLimitation(), 'is_admin');
    }

    private function studentLimitation()
    {
        $studentRows = $this->siswa->getSiswaRows();
        $subscriber = new SubscriptionModel;
        if($studentRows >= $subscriber->getLimit())
        {
            return 'blocked';
        }
        else
        {
            return 'allowed';
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
                    $this->siswa->delete($id);
                }
            }
            else 
            {
                $this->siswa->delete($idString);
            }
            
            return $this->response->setJSON(['status' => 'OK']);
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
        return $this->createResponse($this->siswa->getParents($keyword), 'is_admin');
    }

    public function getKelas()
    {
        return $this->createResponse($this->kelas->getKelas(), 'is_admin');
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