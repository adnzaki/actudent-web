<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\PenggunaModel;

class Pengguna extends \Actudent
{
    /**
     * @var Actudent\Admin\Models\PenggunaModel
     */
    private $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = new PenggunaModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminUser.page_title');

        return parse('Actudent\Admin\Views\pengguna\pengguna-view', $data);
    }

    public function getUser($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search = '')
    {
        $data = $this->user->getUser($limit, $offset, $orderBy, $searchBy, $sort, $whereClause, $search);
        // User data to be wrapped
        $userWrapper = [];

        // User level category
        // Staff|Pegawai, Admin|Admin, Teacher|Guru, Parent|Orang tua
        $userLevel = [
            lang('AdminUser.pengguna_staff'),
            lang('AdminUser.pengguna_admin'),
            lang('AdminUser.pengguna_guru'),
            lang('AdminUser.pengguna_ortu')
        ];
        foreach($data as $key)
        {
            $userWrapper[] = [ 
                'user_id'        => $key->user_id,
                'user_name'      => $key->user_name,
                'user_email'     => $key->user_email,
                'user_password'  => $key->user_password,
                'user_level'     => $key->user_level,
                'level_text'     => $userLevel[$key->user_level],
            ];
        }

        $rows = $this->user->getUserRows($searchBy, $whereClause, $search);
        return $this->response->setJSON([
            'container' => $userWrapper,
            'totalRows' => $rows,
        ]);
    }

    public function getUserDetail($id)
    {
        $user = $this->user->getUserDetail($id);
        // User data to be wrapped
        $userWrapper = [];

        // User level category
        // Staff|Pegawai, Admin|Admin, Teacher|Guru, Parent|Orang tua
        $userLevel = [
            lang('AdminUser.pengguna_staff'),
            lang('AdminUser.pengguna_admin'),
            lang('AdminUser.pengguna_guru'),
            lang('AdminUser.pengguna_ortu')
        ];
        foreach($user as $key)
        {
            $userWrapper[] = [ 
                'user_id'        => $key->user_id,
                'user_name'      => $key->user_name,
                'user_email'     => $key->user_email,
                'user_password'  => $key->user_password,
                'user_level'     => $key->user_level,
                'level_text'     => $userLevel[$key->user_level],
            ];
        }

        $data = [
            'user' => $userWrapper[0],
        ];

        return $this->response->setJSON($data);
    }

    public function save($id)
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
            $this->user->update($data, $id);
            
            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }


    private function validation($id)
    {
        $form = $this->formData();
        $rules = [                
                'user_password'         => 'required|min_length[8]',
                'user_password_confirm' => 'required|matches[user_password]'
        ];

        $messages = [
            'user_password' => [
                'required'      => lang('AdminUser.user_err_pass_required'),
                'min_length'    => lang('AdminUser.user_err_pass_minchars'),
            ],
            'user_password_confirm' => [
                'required'      => lang('AdminUser.user_err_passconf_required'),
                'matches'       => lang('AdminUser.user_err_pass_confirm'),
            ],
        ];              
        
        return [$rules, $messages];
    }

    private function formData()
    {
        return [            
            'user_password'         => $this->request->getPost('user_password'),
        ];
    }
}