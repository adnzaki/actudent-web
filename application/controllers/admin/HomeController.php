<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends Actudent
{
    public function index()
    {
        $data = $this->shared();
        $data['title'] = 'Beranda';
        $this->parser->parse('admin/pages/home', $data);
    }
}