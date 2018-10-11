<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ACController extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model(['admin/SekolahModel' => 'sekolah']);
    }

    protected function shared()
    {
        $data = [
            'base_url'  => base_url(),
            'assets'    => base_url() . 'public/assets/',
            'appAssets' => base_url() . 'public/app-assets/',
            'css'       => base_url() . 'public/css/',
            'fonts'     => base_url() . 'public/fonts/',
            'admin'     => base_url() . 'admin/',
            'namaSekolah' => $this->getDataSekolah(1)->schoolName,
        ];

        return $data;
    }
    
    public function getDataSekolah($schoolID)
    {
        return $this->sekolah->getDataSekolah($schoolID)[0];
    }
}