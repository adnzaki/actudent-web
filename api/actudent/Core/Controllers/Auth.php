<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');

class Auth extends \Actudent
{
    private $tokenExp = 3 * 30 * 24 * 60 * 60; // expired every 3 months

    public function isValidLogin()
    {
        $subscriber = new \Actudent\Core\Models\SubscriptionModel;
        if($subscriber->hasExpired())
        {
            return $this->response->setJSON([
                'msg' => 'expired',
                'note' => lang('Error.app_expired'),
            ]);
        }
        else
        {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $remember = $this->request->getPost('remember-me') ?? '';
            if($this->auth->validasi($username, $password, '1'))
            {
                $pengguna = $this->auth->getDataPengguna($username);
                $token = [
                    'id'        => $pengguna->user_id,
                    'email'     => $username,
                    'nama'      => $pengguna->user_name,
                    'userLevel' => $pengguna->user_level,
                    'iat'       => strtotime('now'),
                    'exp'       => strtotime('now') + $this->tokenExp
                ];

                $this->auth->statusJaringan('online', $username);
                return $this->response->setJSON([
                    'msg'   => 'valid', 
                    'token' => jwt_encode($token),
                    'level' => $pengguna->user_level
                ]);
            }
            else 
            {
                return $this->response->setJSON(['msg' => 'invalid']);
            }
        }
    }
}