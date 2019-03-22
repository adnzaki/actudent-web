<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AgendaModel;

class Agenda extends \CodeIgniter\Controller
{
    /**
     * @var Actudent\Core\Controllers\Actudent
     */
    private $actudent;

    /**
     * @var Actudent\Admin\Models\AgendaModel
     */
    private $agenda;

    public function __construct()
    {
        $this->actudent = new Actudent;
        $this->agenda = new AgendaModel;
    }

    public function index()
	{
        $data = $this->actudent->common();
        $data['title'] = 'Agenda';

        return Actudent::$parser->setData($data)
                ->render('Actudent\Admin\Views\agenda\agenda-view');
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