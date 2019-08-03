<?php namespace Actudent\Showcase\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class Home extends Controller 
{
    public function index()
    {
        $data = $this->siteData();
        return Services::parser()->setData($data)
               ->render('Actudent\Showcase\Views\home');
    }

    public function siteData()
    {
        $resource = base_url('showcase-resources/');
        return [
            'resource'  => $resource,
            'css'       => $resource . 'css/',
            'fonts'     => $resource . 'fonts/',
            'img'       => $resource . 'img/',
            'js'        => $resource . 'js/',
        ];
    }
}