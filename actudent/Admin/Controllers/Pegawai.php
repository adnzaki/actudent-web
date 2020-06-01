<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\PegawaiModel;

class Pegawai extends Actudent
{
    /**
     * @var Actudent\Admin\Models\PegawaiModel
     */
    private $staff;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->staff = new PegawaiModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminPegawai.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\pegawai\pegawai-view');
    }

    public function getStaff($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search = '')
    {
        $data = $this->staff->getStaff($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search);
        $rows = $this->staff->getStaffRows($searchBy, $whereClause, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function getStaffDetail($id)
    {
        $staff = $this->staff->getStaffDetail($id);
        $data = [
            'staff' => $staff[0],
        ];

        return $this->response->setJSON($data);
    }

    public function displayPhoto($staffID)
    {
        $data = $this->common();
        $staff = $this->staff->getPhoto($staffID);
        $data['file'] = $staff->satff_photo;

        return redirect()->to(base_url('images/pegawaicxx/' . $data['file']));
    }

    public function delete()
    {
        $idString = $this->request->getPost('id');
        $idWrapper = [];
        if(strpos($idString, '&') !== false)
        {
            $idWrapper = explode('&', $idString);
            foreach($idWrapper as $id)
            {
                $toArray = explode('-', $id);
                $this->staff->delete($toArray[0], $toArray[1]);
            }
        }
        else 
        {
            $toArray = explode('-', $idString);
            $this->staff->delete($toArray[0], $toArray[1]);
        }
        return $this->response->setJSON(['status' => 'OK']);
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
                $this->staff->insert($data);
            }
            else
            {
                if(! empty($data['file_uploaded']))
                {
                    $path = PUBLICPATH . 'images/pegawai/';
                    unlink($path . $data['file_uploaded']);
                }

                $this->staff->update($data, $id);
            }
            
            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }

    private function validation($id)
    {
        $form = $this->formData();
        $rules = [
            'staff_nik'     => "required|is_natural|exact_length[10]|is_unique[tb_staff.staff_nik,staff_id,$id]",
            'staff_name'    => 'required',            
            'staff_phone'   => 'required|is_natural|min_length[11]|max_length[13]',
            'staff_type'    => 'required',
            'staff_title'    => 'required',
        ];

        $messages = [
            'staff_nik' => [
                'required'      => lang('AdminPegawai.staff_err_nik_required'),
                'is_natural'       => lang('AdminPegawai.staff_err_nik_numeric'),
                'exact_length'  => lang('AdminPegawai.staff_err_nik_exact'),
                'is_unique'     => lang('AdminPegawai.staff_err_nik_duplicate'),
            ],
            'staff_name' => [
                'required'  => lang('AdminPegawai.staff_err_name'),
            ],
            'staff_phone' => [
                'required'      => lang('AdminPegawai.staff_err_phone_require'),
                'is_natural'       => lang('AdminPegawai.staff_err_phone_num'),
                'min_length'    => lang('AdminPegawai.staff_err_phone_min'),
                'max_length'    => lang('AdminPegawai.staff_err_phone_max'),
            ],
            'staff_type' => [
                'required'  => lang('AdminPegawai.staff_err_type'),
            ],
            'staff_title' => [
                'required'  => lang('AdminPegawai.staff_err_title'),
            ],
        ];      

        if($id === null) 
        {
            $insertRules = [
                'user_email'            => 'required|is_unique[tb_user.user_email]',
                'user_password'         => 'required|min_length[8]',
                'user_password_confirm' => 'required|matches[user_password]'
            ];

            $insertMessages = [
                'user_email' => [
                    'required'      => lang('AdminUser.user_err_email_required'),
                    'is_unique'     => lang('AdminUser.user_err_email_unique'),
                ],
                'user_password' => [
                    'required'      => lang('AdminUser.user_err_pass_required'),
                    'min_length'    => lang('AdminUser.user_err_pass_minchars'),
                ],
                'user_password_confirm' => [
                    'required'      => lang('AdminUser.user_err_passconf_required'),
                    'matches'       => lang('AdminUser.user_err_pass_confirm'),
                ],
            ];

            foreach($insertRules as $rule => $val)
            {
                $rules[$rule] = $val;
            }

            foreach($insertMessages as $msg => $val)
            {
                $messages[$msg] = $val;
            }
        }
        
        return [$rules, $messages];
    }

    public function uploadFile($insertID)
    {        
        $validated = $this->validateFile();

        if($validated) 
        {
            $attachment = $this->request->getFile('staff_photo');
            $newFilename = $attachment->getRandomName();
            $attachment->move(PUBLICPATH . 'images/pegawai', $newFilename);

            // Set attachment
            $this->staff->setPhoto($newFilename, $insertID);
            return $this->response->setJSON(['msg' => 'OK']);
        }
        else 
        {
            return $this->response->setJSON($this->validation->getErrors());
        }
    }

    public function runFileValidation()
    {
        $validated = $this->validateFile();
        if($validated)
        {
            return $this->response->setJSON(['msg' => 'OK']);
        }
        else 
        {
            return $this->response->setJSON($this->validation->getErrors());
        }
    }

    private function validateFile()
    {
        $fileRules = [
            'staff_photo' => 'mime_in[staff_photo,application/jpg]|max_size[staff_photo,5048]'
        ];
        $fileMessages = [
            'staff_photo' => [
                'mime_in' => lang('Admin.invalid_filetype'),
                'max_size' => lang('Admin.file_too_large'),
            ]
        ];

        return $this->validate($fileRules, $fileMessages);
    }

    private function formData()
    {
        return [
            'staff_nik'             => $this->request->getPost('staff_nik'),
            'staff_name'            => $this->request->getPost('staff_name'),
            'staff_phone'           => $this->request->getPost('staff_phone'),
            'staff_type'            => $this->request->getPost('staff_type'),
            'staff_title'            => $this->request->getPost('staff_title'),
            'user_name'             => $this->request->getPost('staff_name'),
            'user_email'            => $this->request->getPost('user_email'),
            'user_password'         => $this->request->getPost('user_password'),
            'file_uploaded'         => $this->request->getPost('file_uploaded'),
        ];
    }

}