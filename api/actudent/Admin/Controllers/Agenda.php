<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Models\AgendaModel;
use Actudent\Admin\Models\PenggunaModel;

class Agenda extends \Actudent
{
    /**
     * @var Actudent\Admin\Models\AgendaModel
     */
    private $agenda;

    /**
     * @var Actudent\Admin\Models\PenggunaModel
     */
    private $user;

    public function __construct()
    {
        $this->agenda = new AgendaModel;
        $this->user = new PenggunaModel;
    }

    public function getEvents($viewStart, $viewEnd, $sort = 'false')
    {
        $events = $this->agenda->getEvents($viewStart, $viewEnd, $sort);
        $formatted = [];
        foreach($events as $key)
        {
            $data = [];
            $eventStart = explode(' ', $key->agenda_start);
            $eventEnd = explode(' ', $key->agenda_end);
            
            // match format that supported by FullCalendar
            $data['id']         = $key->agenda_id;
            $data['title']      = $key->agenda_name;
            $data['start']      = str_replace(' ', 'T', $key->agenda_start);
            $data['end']        = str_replace(' ', 'T', $key->agenda_end);
            $data['startStr']   = os_date()->create($eventStart[0]).' | '.substr($eventStart[1], 0, 5);
            $data['endStr']     = os_date()->create($eventEnd[0]).' | '.substr($eventEnd[1], 0, 5);
            $data['priority']   = $key->agenda_priority;
            array_push($formatted, $data);
        }

        return $this->createResponse($formatted);
    }

    /**
     * Get users based on their type
     * 
     * @param string|int $type guru | staff | wali_kelas | @gradeId
     * @param int $limit
     * @param int $offset
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search
     * 
     * @return array
     */
    public function getUsers($type, $limit, $offset, $orderBy = 'user_name', $searchBy = 'user_name', $sort = 'ASC', $search = '')
    {
        $level = [
            'staff'     => 0,
            'guru'      => 2,
        ];

        if(is_numeric($type)) {
            $data = $this->agenda->getParents($type, $limit, $offset, $orderBy, $searchBy, $sort, $search);
            // $data = $this->agenda->baseGetParentsQuery($type, $searchBy, $search);
            $rows = $this->agenda->getParentRows($type, $searchBy, $search);
        } elseif($type === 'wali_kelas') {
            $data = $this->agenda->getHomeroomTeacher($limit, $offset, $orderBy, $searchBy, $sort, $search);
            $rows = $this->agenda->getHomeroomTeacherRows($searchBy, $search);
        } else {
            $data = $this->user->getUser($limit, $offset, $orderBy, $searchBy, $sort, $level[$type], $search);
            $rows = $this->user->getUserRows($searchBy, $level[$type], $search);
        }        

        return $this->createResponse([
            'totalRows' => $rows,
            'container' => $data
        ]);
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
            'agenda_start' => strtotime($event->agenda_start),
            'agenda_end' => strtotime($event->agenda_end),
        ];

        $guests = $this->agenda->getEventGuests($id);

        $data = [
            'data' => $event,
            'dataForPlugin' => $dateTime,
            'guests' => array_column($guests, 'user_id'),
        ];

        return $this->createResponse($data);
    }

    public function displayAttachment($agendaID, $token)
    {
        if(valid_token($token)) {
            $data = $this->common();
            $agenda = $this->agenda->getAttachment($agendaID);
            $data['file'] = $agenda->agenda_attachment;
            $data['path'] = base_url('attachments/agenda/' . $data['file']);

            return view('Actudent\Admin\Views\agenda\attachment-view', $data);
        }
    }
    
    public function delete($id)
    {
        if(is_admin()) {
            $this->agenda->delete($id);
            return $this->response->setJSON(['status' => 'OK']);
        }
    }

    public function save($id = null)
    {
        if(is_admin()) {
            $validation = $this->validation(); // [0 => $rules, 1 => $messages]
            if(! validate($validation[0], $validation[1])) {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            } else {
                $data = $this->formData();
                if($id === null) {
                    $response = [
                        'code' => '200',
                        'id' => $this->agenda->insert($data), // return the insert_id
                    ];
                } else {
                    if(! empty($data['file_uploaded'])) {
                        $path = PUBLICPATH . 'attachments/agenda/';
                        if(file_exists($path . $data['file_uploaded'])) {
                            unlink($path . $data['file_uploaded']);
                        }
                    }
                    
                    $response = [
                        'code' => '200',
                        'id' => $this->agenda->update($data, $id), // return the agenda_id
                    ];
                }
                
                return $this->response->setJSON($response);
            }
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
                'required' => get_lang('AdminAgenda.agenda_err_name_required'),
            ],
            'agenda_start' => [
                'required' => get_lang('AdminAgenda.agenda_err_eventstart_required'),
                'less_than' => get_lang('AdminAgenda.agenda_err_eventstart_invalid'),
            ],
            'agenda_end' => [
                'required' => get_lang('AdminAgenda.agenda_err_eventend_required'),
                'greater_than' => get_lang('AdminAgenda.agenda_err_eventend_invalid'),
            ],
            'agenda_priority' => [
                'in_list' => get_lang('AdminAgenda.agenda_err_priority'),
            ],
        ];            

        return [$rules, $messages];
    }

    public function uploadFile()
    {        
        if(is_admin()) {
            $validated = $this->validateFile();
    
            if($validated) {
                $attachment = $this->request->getFile('attachment');
                $newFilename = $attachment->getRandomName();
                $attachment->move(PUBLICPATH . 'attachments/agenda', $newFilename);
    
                return $this->response->setJSON([
                    'msg'       => 'OK',
                    'filename'  => $newFilename
                ]);
            } else {
                return $this->response->setJSON($this->validation->getErrors());
            }
        }
    }

    private function validateFile()
    {
        $fileRules = [
            'attachment' => 'mime_in[attachment,application/pdf]|max_size[attachment,2048]'
        ];
        $fileMessages = [
            'attachment' => [
                'mime_in' => get_lang('Admin.invalid_filetype'),
                'max_size' => get_lang('Admin.file_too_large'),
            ]
        ];

        return $this->validate($fileRules, $fileMessages);
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
            'agenda_attachment'     => $this->request->getPost('agenda_attachment'),
            'file_uploaded'         => $this->request->getPost('file_uploaded'),
        ];

        return $data;
    }    
}