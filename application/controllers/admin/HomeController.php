<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends Actudent
{
    public function __construct()
    {
        parent:: __construct();
        if(! isset($_SESSION['email']))
        {
            redirect('admin/auth');
        }
    }
    public function index()
    {
        $data = $this->shared();
        $data['title'] = 'Beranda';
        $this->parser->parse('admin/pages/home', $data);
    }
}