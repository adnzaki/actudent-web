<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Auth extends Actudent
{
    public function index()
    {
        if(session('email') !== null && session('userLevel') === '1')
        {
            return redirect()->to(base_url('admin/home'));
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
            return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\new-auth');
        }        
    }

    public function validasi()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        if($this->auth->validasi($username, $password, '1'))
        {
            $pengguna = $this->auth->getDataPengguna($username);
            $session = [
                'id'        => $pengguna->user_id,
                'email'     => $username,
                'nama'      => $pengguna->user_name,
                'userLevel' => $pengguna->user_level,
                'logged_in' => true
            ];
            $this->session->set($session);
            $this->auth->statusJaringan('online', $username);
            echo 'valid';
        }
        else 
        {
            echo 'invalid';
        }
    }

    public function logout()
    {
        // save language option after user has been logged out from the app
        $this->setLanguage($this->getUserLanguage());
        $this->auth->statusJaringan('offline', $_SESSION['email']);
        $this->session->remove(['id', 'email', 'nama', 'userLevel', 'logged_in']);
        return redirect()->to(base_url('admin/login'));
    }
}