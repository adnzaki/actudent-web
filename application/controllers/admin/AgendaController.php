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

    public function getEvents()
    {
        $events = $this->agenda->getEvents();
        $formatted = [];
        foreach($events as $key)
        {
            $data = [];
            
            // menyesuaikan dengan format data yang didukung oleh plugin FullCalendar
            $data['id'] = $key->agenda_id;
            $data['title'] = $key->agenda_name;
            $data['start'] = str_replace(' ', 'T', $key->agenda_start);
            $data['end'] = str_replace(' ', 'T', $key->agenda_end);
            array_push($formatted, $data);
        }

        echo json_encode($formatted);
    }
}