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

        echo json_encode($formatted);
    }

    public function searchGuest($search = '')
    {
        if(empty($search) || $search === 'undefined')
        {
            $output = [
                [
                    'text' => 'Semua',
                    'children' => [],
                ],
                [
                    'text' => 'Daftar Wali Kelas',
                    'children' => [],
                ],
                [
                    'text' => 'Daftar Wali Murid',
                    'children' => [],
                ],
            ];
        }
        else 
        {
            // search the guests!
            $data = $this->agenda->searchGuest($search);
    
            // create a wrapper to store the result
            $wrapper = [
                'wali_murid' => [],
                'wali_kelas' => [],
            ];
    
            foreach($data as $res)
            {
                // push the result into the wrapper
                array_push($wrapper['wali_murid'], ['id' => $res->user_id, 'text' => "{$res->user_name} - {$res->grade_name}"]);
                array_push($wrapper['wali_kelas'], ['id' => $res->user_id, 'text' => "{$res->teacher_name} - {$res->grade_name}"]);
            }
    
            // generate output and remove duplicate results with array_unique
            $output = [
                [
                    'text' => 'Semua',
                    'children' => [
                        [
                            'id' => 1,
                            'text' => "Semua Wali Kelas \"{$search}\"",
                        ],
                        [
                            'id' => 2,
                            'text' => "Semua Wali Murid \"{$search}\"",
                        ],
                        [
                            'id' => 3,
                            'text' => 'Staff',
                        ],
                    ]
                ],
                [
                    'text' => "Daftar Wali Kelas \"{$search}\"",
                    'children' => resort(multidimensional_array_unique($wrapper['wali_kelas'], 'text')),
                ],
                [
                    'text' => "Daftar Wali Murid \"{$search}\"",
                    'children' => resort(multidimensional_array_unique($wrapper['wali_murid'], 'text')),
                ],
            ];
        }

        return $this->response->setJSON($output);
    }

}