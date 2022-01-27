<?php namespace Actudent\Guru\Controllers;

class Auth extends \Actudent
{
    public function index()
    {
        $cookie = get_cookie('remember_login');
        $userToken = $this->auth->getUserToken($cookie);
        if(session('email') !== null && session('userLevel') === '2' || $userToken !== false)
        {
            return redirect()->to(base_url('guru/home'));
        }
        else 
        {            
            $data = $this->common();

            // set default language when no there is no language option
            // default language will be set to Bahasa Indonesia if there is no session found
            $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';

            // set app language based on default language
            $this->setLanguage($defaultLang);
            $data['title'] = lang('AdminAuth.login_title');
            return parse('Actudent\Guru\Views\auth', $data);
        }        
    }

    public function isValidLogin()
    {
        $subscriber = new \Actudent\Core\Models\SubscriptionModel;
        if($subscriber->hasExpired())
        {
            return $this->response->setJSON([
                'msg' => 'expired',
                'note' => lang('AdminSiswa.siswa_overlimit'),
            ]);
        }
        else
        {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $remember = $this->request->getPost('remember-me') ?? '';
            if($this->auth->validasi($username, $password, '2'))
            {
                $pengguna = $this->auth->getDataPengguna($username);
                $session = [
                    'id'        => $pengguna->user_id,
                    'email'     => $username,
                    'nama'      => $pengguna->user_name,
                    'userLevel' => $pengguna->user_level,
                    'logged_in' => true
                ];
                
                // if(! empty($remember))
                // {
                //     $cookieValue = "{$username}-{$pengguna->user_level}";
                //     $hash = base64_encode($cookieValue);
                //     $this->auth->createToken($hash);
                //     set_cookie('remember_login', $hash, (3600 * 24 * 30));
                // }
    
                session()->set($session);
                $this->auth->statusJaringan('online', $username);
                return $this->response->setJSON(['msg' => 'valid']);
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
        return redirect()->to(base_url('guru/login'));
    }
}