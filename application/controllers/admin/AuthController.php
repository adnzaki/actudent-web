<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends Actudent
{
    public function __construct()
    {
        parent:: __construct();
    }

    public function index()
    {
        if(isset($_SESSION['email']))
        {
            redirect('admin/home');
        }
        else 
        {
            $data = $this->shared();

            // mengatur bahasa awal aplikasi ketika belum ada pilihan bahasa dari pengguna
            // atur bahasa awal ke bahasa Indonesia jika belum ada session 'actudent_lang
            $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';

            // set bahasa aplikasi berdasarkan bahasa awal
            $this->setLanguage($defaultLang);
            $data['title'] = 'Autentikasi';
            $this->parser->parse('admin/pages/auth', $data);
        }
    }

    public function validasi()
    {
        if($this->auth->validasi())
        {
            $username = $this->input->post('username');
            $pengguna = $this->auth->getDataPengguna($username);
            $session = [
                'email'     => $username,
                'nama'      => $pengguna->user_name,
                'userLevel' => $pengguna->user_level,
                'logged_in' => true
            ];
            $this->session->set_userdata($session);
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
        $bahasa = $this->getUserLanguage();

        // simpan pilihan bahasa pengguna setelah dia logout dari aplikasi
        $this->setLanguage($bahasa);
        
        $this->auth->statusJaringan('offline', $_SESSION['email']);
        $this->session->unset_userdata(['email', 'nama', 'userLevel', 'logged_in']);
        redirect('admin/auth');
    }
}