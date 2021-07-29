<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

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
        $resource = new \Actudent\Core\Controllers\Resources;
        $resource->setUILanguage();
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminPegawai.page_title');

        return parse('Actudent\Admin\Views\pegawai\pegawai-view', $data);
    }

    public function getStaff($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search = '')
    {
        $data = $this->staff->getStaff($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search);
        $rows = $this->staff->getStaffRows($searchBy, $whereClause, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ], 'is_admin');
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

        return redirect()->to(base_url('images/pegawai/' . $data['file']));
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
                $response = [
                    'code' => '200',
                    'id' => $this->staff->insert($data), // return the insert_id
                ];
            }
            else
            {

                // if($data['current_image'] !== $data['image_feature'])
                // {
                //     $path = PUBLICPATH . 'images/pegawai/';
                //     if(file_exists($path . $data['current_image']))
                //     {
                //         unlink($path . $data['current_image']);
                //     }
                // }
                
                $response = [
                    'code' => '200',
                    'id' => $this->staff->update($data, $id), // return the timeline_id
                ];
            }

            return $this->response->setJSON($response);            
            
        }
    }

    private function validation($id)
    {
        $form = $this->formData();
        $rules = [
            'staff_nik'     => "required|is_natural|exact_length[10]|is_unique[tb_staff.staff_nik,tb_staff.user_id,$id]",
            'staff_name'    => 'required',            
            'staff_phone'   => 'required|is_natural|min_length[11]|max_length[13]',
            'staff_type'    => 'required',
            'staff_title'    => 'required',
            'image_feature' => 'required',
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
            'image_feature' => [
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
            $newFilename ="img_" . $attachment->getRandomName();
            $attachment->move(PUBLICPATH . 'images/pegawai', $newFilename);

            $image = \Config\Services::image();
            $image->withFile(PUBLICPATH . 'images/pegawai/' . $newFilename)
                  ->fit(113, 113)
                  ->save(PUBLICPATH . 'images/pegawai/' . $newFilename);
            // Get the image and convert into string
            $img = file_get_contents('images/pegawai/' . $newFilename);
            // Encode the image string data into base64 
            $data = base64_encode($img);            
           
            // Set attachment
            $this->staff->setPhoto($data, $insertID);     
            
            // Delete File
            $path = PUBLICPATH . 'images/pegawai/' . $newFilename;
            if(file_exists($path))
            {
                unlink($path);
            }

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
            $attachment = $this->request->getFile('staff_photo');
            $newFilename ="img_" . $attachment->getRandomName();
            $attachment->move(PUBLICPATH . 'images/pegawai', $newFilename);

            $image = \Config\Services::image();
            $image->withFile(PUBLICPATH . 'images/pegawai/' . $newFilename)
                  ->fit(113, 113)
                  ->save(PUBLICPATH . 'images/pegawai/' . $newFilename);

            // Get the image and convert into string
            $img = file_get_contents('images/pegawai/' . $newFilename);

            // Encode the image string data into base64 
            $data = base64_encode($img);            
                       
            // Remove file after encoding process
            $path = PUBLICPATH . 'images/pegawai/' . $newFilename;
            if(file_exists($path))
            {
                unlink($path);
            }
            $response = [
                'msg' => 'OK',
                'img' => $data, // return base64 image
            ];

            return $this->response->setJSON($response);
        }
        else 
        {
            return $this->response->setJSON($this->validation->getErrors());
        }
    }

    private function validateFile()
    {
        $fileRules = [
            'staff_photo' => 'mime_in[staff_photo,image/jpeg,image/png]|max_size[staff_photo,2048]'
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
            'image_feature'         => $this->request->getPost('image_feature'),
            'current_image'         => $this->request->getPost('current_image'),
        ];
    }

}