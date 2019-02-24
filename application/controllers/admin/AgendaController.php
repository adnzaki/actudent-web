<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgendaController extends Actudent
{
    public function __construct()
    {
        parent:: __construct();
        if(! isset($_SESSION['email']))
        {
            redirect('admin/auth');
        }
        else 
        {
            $this->load->model('admin/AgendaModel', 'agenda');
        }
    }

    public function index()
    {
        $data = $this->shared();
        $data['title'] = 'Agenda';
        $this->parser->parse('admin/pages/agenda/agenda-view', $data);
    }
}