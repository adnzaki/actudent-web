<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends Actudent
{
    public function ikon()
    {
        $data = $this->shared();
        $data['title'] = 'Icons';
        $this->parser->parse('admin/pages/template/icons', $data);
    }

    public function button()
    {
        $data = $this->shared();
        $data['title'] = 'Buttons';
        $this->parser->parse('admin/pages/template/button', $data);
    }
}