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
            
            // match format that supported by FullCalendar
            $data['id'] = $key->agenda_id;
            $data['title'] = $key->agenda_name;
            $data['start'] = str_replace(' ', 'T', $key->agenda_start);
            $data['end'] = str_replace(' ', 'T', $key->agenda_end);
            array_push($formatted, $data);
        }

        return $this->response->setJSON($formatted);
    }

    public function searchGuest($keyword = '')
    {
        $wrapper = [
            'wali_murid' => [],
            'wali_kelas' => [],
        ];

        if(empty($keyword))
        {
            return $this->response->setJSON($wrapper);
        }
        else 
        {
            // search the guests!
            $data = $this->agenda->searchGuest($keyword);
        
            // create a wrapper to store the result

            foreach($data as $res)
            {
                // push the result into the wrapper
                array_push($wrapper['wali_murid'], ['id' => $res->user_parent, 'text' => "{$res->user_name}"]);
                array_push($wrapper['wali_kelas'], ['id' => $res->user_guru, 'text' => "{$res->teacher_name} - {$res->grade_name}"]);
            }

            $output = [
                'wali_kelas' => resort(multidimensional_array_unique($wrapper['wali_kelas'], 'id')),
                'wali_murid' => resort(multidimensional_array_unique($wrapper['wali_murid'], 'id'))
            ];

            return $this->response->setJSON($output);
        }        
    }
}