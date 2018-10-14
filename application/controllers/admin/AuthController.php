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
                'nama'      => $pengguna->userName,
                'sekolah'   => $pengguna->schoolID,
                'userLevel' => $pengguna->userLevel,
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
        $this->auth->statusJaringan('offline', $_SESSION['email']);
        $this->session->unset_userdata(['email', 'nama', 'sekolah', 'userLevel', 'logged_in']);
        redirect('admin/auth');
    }
}