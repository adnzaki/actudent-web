<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\PenggunaModel;
use Actudent\Core\Models\AuthModel;

class Pengguna extends \Actudent
{
    /**
     * @var \Actudent\Admin\Models\PenggunaModel
     */
    private $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = new PenggunaModel;
    }

    public function getUser($whereClause, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->user->getUser($whereClause, $limit, $offset, $orderBy, $searchBy, $sort, $search);

        // User level category
        // Staff, Admin|Admin, Teacher|Guru, Parent|Orang tua
        $userLevel = [
            'Staff',
            get_lang('AdminUser.pengguna_admin'),
            get_lang('AdminUser.pengguna_guru'),
            get_lang('AdminUser.pengguna_ortu')
        ];

        foreach($data as $key) {
            $key->level = $userLevel[$key->level];
        }

        $rows = $this->user->getUserRows($whereClause, $searchBy, $search);
        return $this->createResponse([
            'container' => $data,
            'totalRows' => $rows,
        ], 'is_admin');
    }

    public function getUserDetail($id)
    {
        $user = $this->user->getUserDetail($id);
        // User level category
        // Staff, Admin|Admin, Teacher|Guru, Parent|Orang tua
        $userLevel = [
            get_lang('AdminUser.pengguna_staff'),
            get_lang('AdminUser.pengguna_admin'),
            get_lang('AdminUser.pengguna_guru'),
            get_lang('AdminUser.pengguna_ortu')
        ];

        $user->level = $userLevel[$user->level];

        return $this->createResponse($user, 'is_admin');
    }

    public function deactivate($id)
    {
        if(is_admin()) {
            $this->user->deactivateUser($id);

            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }

    public function save($id)
    {
        if(is_admin()) {
            $validation = $this->validation(); // [0 => $rules, 1 => $messages]
            if(! validate($validation[0], $validation[1])) {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            } else {
                $data = $this->formData();
                $this->user->update($data, $id);
                
                return $this->response->setJSON([
                    'code' => '200',
                ]);
            }
        }
    }

    public function saveNewPassword()
    {
        if(valid_token()) {
            $user = $this->getDataPengguna(bearer_token());
            
            $validation = $this->changePasswordValidation(); // [0 => $rules, 1 => $messages]
            if(! validate($validation[0], $validation[1])) {
                return $this->response->setJSON([
                    'code'  => 500,
                    'msg'   => $this->validation->getErrors(),
                ]);
            } else {
                $auth = new AuthModel;
                if($auth->validasi($user->user_email, $this->request->getPost('old_password'))) {
                    $data = ['user_password' => $this->request->getPost('user_password')];
                    $this->user->update($data, $user->user_id);
                    
                    return $this->response->setJSON([
                        'code'  => 200,
                        'msg'   => 'Account password updated'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'code'  => 503,
                        'msg'   => get_lang('user_password_wrong'),
                    ]);
                }
            }
        }
    }

    private function changePasswordValidation()
    {
        $validation = $this->validation();

        $rules = ['old_password' => 'required'];
        $messages = [
            'old_password' => [
                'required' => get_lang('AdminUser.user_old_password_required'),
            ]
        ];

        return [
            array_merge($rules, $validation[0]),
            array_merge($messages, $validation[1])
        ];
    }

    private function validation()
    {
        $rules = [                
                'user_password'         => 'required|min_length[8]',
                'user_password_confirm' => 'required|matches[user_password]'
        ];

        $messages = [
            'user_password' => [
                'required'      => get_lang('AdminUser.user_err_pass_required'),
                'min_length'    => get_lang('AdminUser.user_err_pass_minchars'),
            ],
            'user_password_confirm' => [
                'required'      => get_lang('AdminUser.user_err_passconf_required'),
                'matches'       => get_lang('AdminUser.user_err_pass_confirm'),
            ],
        ];              
        
        return [$rules, $messages];
    }

    private function formData()
    {
        return [            
            'user_password'         => $this->request->getPost('user_password'),
            'user_password_confirm' => $this->request->getPost('user_password_confirm'),
        ];
    }
}