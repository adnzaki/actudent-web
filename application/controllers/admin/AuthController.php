<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends Actudent
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('AuthModel', 'auth');
    }

    public function index()
    {
        $data = $this->shared();
        $data['title'] = 'Autentikasi';
        $this->parser->parse('admin/pages/auth', $data);
    }
}