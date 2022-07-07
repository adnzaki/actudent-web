<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');

class Auth extends \Actudent
{
    private $tokenExp = 3 * 30 * 24 * 60 * 60; // expired every 3 months

    public function setLanguage()
    {
        $lang = $this->request->getPost('lang');        
        $path = PUBLICPATH . 'settings.json';
        $settings = json_decode(file_get_contents($path));
        $settings->lang = $lang;

        // write settings file...
        file_put_contents($path, json_encode($settings));

        return $this->response->setJSON(['msg' => 'Language setting updated']);
    }

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
            $isNik = $this->auth->isNik($username);

            if($isNik !== false) {
                $username = $isNik;
            }

            if($this->auth->validasi($username, $password)) {
                $pengguna = $this->auth->getDataPengguna($username);
                $token = [
                    'id'        => $pengguna->user_id,
                    'email'     => $username,
                    'nama'      => $pengguna->user_name,
                    'userLevel' => $pengguna->user_level,
                    'iat'       => strtotime('now'),
                    'exp'       => strtotime('now') + $this->tokenExp
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
                        'grade' => $gradeId
                    ]);
                }
            }
            else 
            {
                return $this->response->setJSON(['msg' => 'invalid']);
            }
        }
    }
}