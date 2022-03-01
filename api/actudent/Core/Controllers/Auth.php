<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');

class Auth extends \Actudent
{
    private $tokenExp = 12 * 30 * 24 * 60 * 60; // 1 year

    public function index()
    {
        $cookie = get_cookie('remember_login');
        $userToken = $this->auth->getUserToken($cookie);
        if(session('email') !== null && session('userLevel') === '1' || $userToken !== false)
        {
            return redirect()->to(base_url('admin/home'));
        }
        else 
        {            
            $data = $this->common();
            $data['title'] = lang('AdminAuth.login_title');
            return parse('Actudent\Admin\Views\new-auth', $data);
        }        
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
            $language = $this->request->getPost('language');
            if($this->auth->validasi($username, $password, '1'))
            {
                $pengguna = $this->auth->getDataPengguna($username);
                $token = [
                    'id'        => $pengguna->user_id,
                    'email'     => $username,
                    'nama'      => $pengguna->user_name,
                    'userLevel' => $pengguna->user_level,
                    'logged_in' => true,
                    'iat'       => strtotime('now'),
                    'exp'       => strtotime('now') + $this->tokenExp
                ];

                // update user language
                $settings = new \Actudent\Core\Models\SettingModel;
                $settings->setUserLanguage($username, $language);
    
                $this->auth->statusJaringan('online', $username);
                $getLang = $this->auth->getUserLanguage($username);
                
                return $this->response->setJSON([
                    'msg'   => 'valid', 
                    'token' => jwt_encode($token),
                    'lang'  => $getLang[0]->user_language,
                    'level' => $pengguna->user_level
                ]);
            }
            else 
            {
                return $this->response->setJSON(['msg' => 'invalid']);
            }
        }
    }

    public function logout()
    {
        // save language option after user has been logged out from the app
        $this->setLanguage($this->getUserLanguage());

        // set network status to offline
        $this->auth->statusJaringan('offline', $_SESSION['email']);

        // delete token from database
        $this->auth->deleteToken(get_cookie('remember_login'));

        // remove session...
        session()->remove(['id', 'email', 'nama', 'userLevel', 'logged_in']);

        // delete cookie
        delete_cookie('remember_login');

        // redirect to login page
        return redirect()->to(base_url('admin/login'));
    }
}