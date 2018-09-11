<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends ACController
{
    public function index()
    {
        $data = $this->shared();
        $this->parser->parse('pages/home', $data);
    }
}