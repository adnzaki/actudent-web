<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AgendaModel;

class Agenda extends \CodeIgniter\Controller
{
    /**
     * @var Actudent\Admin\Models\AgendaModel
     */
    private $agenda;

    public function __construct()
    {
        new Actudent;
        $this->agenda = new AgendaModel;
    }

    public function index()
	{
        $data = Actudent::common();
        $data['title'] = 'Agenda';

        return Actudent::$parser->setData($data)
                ->render('Actudent\Admin\Views\agenda\agenda-view');
    }

    public function getEvents($viewStart, $viewEnd)
    {
        $events = $this->agenda->getEvents($viewStart, $viewEnd);
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
                array_push($wrapper['wali_kelas'], ['id' => $res->user_guru, 'text' => "{$res->teacher_name}"]);
            }

            $output = [
                'wali_kelas' => resort(multidimensional_array_unique($wrapper['wali_kelas'], 'id')),
                'wali_murid' => resort(multidimensional_array_unique($wrapper['wali_murid'], 'id'))
            ];

            return $this->response->setJSON($output);
        }        
    }

    public function getEventDetail($id)
    {
        $event          = $this->agenda->getEventDetail($id);
        $agendaStart    = explode(' ', $event->agenda_start);
        $agendaEnd      = explode(' ', $event->agenda_end);
        
        $dateTime = [
            'agendaDateStart' => $agendaStart[0],
            'agendaTimeStart' => substr($agendaStart[1], 0, 5),
            'agendaDateEnd' => $agendaEnd[0],
            'agendaTimeEnd' => substr($agendaEnd[1], 0, 5),
        ];

        $data = [
            'data' => $event,
            'dataForPlugin' => $dateTime,
            'guests' => $this->agenda->getEventGuests($id),
        ];

        return $this->response->setJSON($data);
    }
    

    public function save()
    {
        $validation = $this->validation(); // [0 => $rules, 1 => $messages]
        if(! $this->validate($validation[0], $validation[1]))
        {
            return $this->response->setJSON([
                'code' => '500',
                'msg' => Actudent::$validation->getErrors(),
            ]);
        }
        else 
        {
            $data = $this->formData();
            return $this->response->setJSON([
                'code' => '200',
                'insertID' => $this->agenda->insert($data), // return the insert_id
            ]);
        }
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'agenda_name' => 'required',
            'agenda_start' => 'required|less_than['.$form['agenda_end'].']',
            'agenda_end' => 'required|greater_than['.$form['agenda_start'].']',
            'agenda_priority' => 'in_list[high,normal,low]',
        ];

        $messages = [
            'agenda_name' => [
                'required' => lang('AdminAgenda.agenda_err_name_required'),
            ],
            'agenda_start' => [
                'required' => lang('AdminAgenda.agenda_err_eventstart_required'),
                'less_than' => lang('AdminAgenda.agenda_err_eventstart_invalid'),
            ],
            'agenda_end' => [
                'required' => lang('AdminAgenda.agenda_err_eventend_required'),
                'greater_than' => lang('AdminAgenda.agenda_err_eventend_invalid'),
            ],
            'agenda_priority' => [
                'in_list' => lang('AdminAgenda.agenda_err_priority'),
            ],
        ];            

        return [$rules, $messages];
    }

    public function uploadFile($insertID)
    {
        $fileRules = [
            'agenda_attachment' => 'uploaded[agenda_attachment]|mime_in[agenda_attachment,application/pdf]|max_size[agenda_attachment,2048]'
        ];
        $fileMessages = [
            'agenda_attachment' => [
                'uploaded' => 'File has been uploaded',
                'mime_in' => lang('Admin.invalid_filetype'),
                'max_size' => lang('Admin.file_too_large'),
            ]
        ];
        $validated = $this->validate($fileRules, $fileMessages);

        if($validated) 
        {
            $attachment = $this->request->getFile('agenda_attachment');
            $newFilename = $attachment->getRandomName();
            $attachment->move(PUBLICPATH . 'attachments/agenda', $newFilename);

            // Set attachment
            $this->agenda->setAttachment($newFilename, $insertID);
            return $this->response->setJSON(['msg' => 'OK']);
        }
        else 
        {
            return $this->response->setJSON(Actudent::$validation->getErrors());
        }
    }

    private function formData()
    {
        $data = [
            'agenda_name'           => $this->request->getPost('agenda_name'),
            'agenda_start'          => $this->request->getPost('agenda_start'),
            'agenda_end'            => $this->request->getPost('agenda_end'),
            'agenda_description'    => $this->request->getPost('agenda_description'),
            'agenda_priority'       => $this->request->getPost('agenda_priority'),
            'agenda_location'       => $this->request->getPost('agenda_location'),
            'agenda_guest'          => $this->request->getPost('agenda_guest'),
        ];

        return $data;
    }    
}