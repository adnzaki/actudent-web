<?php namespace SiAbsen\Models;

class KegiatanModel extends \Actudent\Admin\Models\AgendaModel
{
    private $QBAgendaPresence;

    private $agendaPresence = 'tb_agenda_presence';

    public function __construct()
    {
        parent:: __construct();
        $this->QBAgendaPresence = $this->db->table($this->agendaPresence);
    }

    public function insertPresence($data)
    {
        $values = [
            'agenda_id'         => $data['agenda'],
            'user_id'           => $data['user'],
            'presence_datetime' => $data['datetime'],
            'presence_lat'      => $data['lat'],
            'presence_long'     => $data['long'],
            'presence_photo'    => $data['photo']
        ];

        $this->QBAgendaPresence->insert($values);
    }

    public function getAllEvents(string $period)
    {
        $query = $this->QBAgenda->select("agenda_id, agenda_name, agenda_start, agenda_end, agenda_priority")
                 ->like('agenda_start', $period)
                 ->orderBy('agenda_start', 'DESC');
        
        return $query->get()->getResult();
    }
    
    public function getUserEvents(int $id, string $period)
    {
        $query = $this->QBAgenda->select("{$this->agenda}.agenda_id, agenda_name, agenda_start, agenda_end, agenda_priority")
                 ->join($this->agendaUser, "{$this->agenda}.agenda_id={$this->agendaUser}.agenda_id")
                 ->like('agenda_start', $period)
                 ->where(["{$this->agendaUser}.user_id" => $id])
                 ->orderBy('agenda_start', 'DESC');

        return $query->get()->getResult();
    }

    public function presenceExists(int $agendaId, int $userId): bool
    {
        $check = $this->QBAgendaPresence->getWhere([
            'agenda_id' => $agendaId,
            'user_id'   => $userId
        ]);

        return $check->getNumRows() > 0 ? true : false;
    }
}