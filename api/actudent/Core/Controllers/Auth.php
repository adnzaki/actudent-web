<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');

class Auth extends \Actudent
{
    private $tokenExp = 2 * 60 * 60; // expired every 2 hours

    public function isValidLogin()
    {
        $subscriber = new \Actudent\Core\Models\SubscriptionModel;
        if($subscriber->hasExpired())
        {
            return $this->response->setJSON([
                'msg' => 'expired',
                'note' => get_lang('Error.app_expired'),
            ]);
        }
        else
        {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $remember = $this->request->getPost('remember');
            $isNik = $this->auth->isNik($username);

            if($isNik !== false) {
                $username = $isNik;
            }

            if($this->auth->validasi($username, $password)) {
                $pengguna = $this->auth->getDataPengguna($username);
                $tokenExpiration = $remember === '1' 
                                    ? $this->tokenExp * 12 * 30 // extend expiration to 1 month
                                    : $this->tokenExp; // keep expiration in 2 hours
                $token = [
                    'id'        => $pengguna->user_id,
                    'email'     => $username,
                    'nama'      => $pengguna->user_name,
                    'userLevel' => $pengguna->user_level,
                    'iat'       => strtotime('now'),
                    'exp'       => strtotime('now') + $tokenExpiration
                ];

                $gradeId = null;

                if($pengguna->user_level === '3') {
                    return $this->response->setJSON(['msg' => 'unauthorized']);
                } else {
                    if($pengguna->user_level === '2') {
                        $model = new \Actudent\Guru\Models\JadwalKehadiranModel;
                        $check = $model->isHomeroomTeacher($pengguna->user_id);
                        if($check !== false) {
                            $gradeId = (int)$check->grade_id;
                        }
                    }
    
                    $this->auth->statusJaringan('online', $username);
                    return $this->response->setJSON([
                        'msg'   => 'valid', 
                        'token' => jwt_encode($token),
                        'level' => $pengguna->user_level,
                        'grade' => $gradeId,
                        'lang'  => $this->getAppConfig($pengguna->user_id)->lang
                    ]);
                }
            }
            else 
            {
                return $this->response->setJSON([
                    'msg'   => 'invalid',
                    'user'  => $username
                ]);
            }
        }
    }
}