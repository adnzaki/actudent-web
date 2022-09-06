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

    public function getPresence($agendaId, $userId)
    {
        $search = $this->QBAgendaPresence->getWhere([
            'agenda_id' => $agendaId,
            'user_id'   => $userId
        ]);

        $user = new \Actudent\Admin\Models\PenggunaModel;
        $userDetail = $user->getUserDetail($userId);
        $userName = $userDetail[0]->user_name;
        $level = [
            0 => 'Staff',
            2 => get_lang('AdminPegawai.staff_guru'),
            3 => get_lang('AdminAgenda.agenda_check_ortu')
        ];

        $userLevel = $level[$userDetail[0]->user_level];

        if($search->getNumRows() > 0) {            
            $result = $search->getResult()[0];
            $time = explode(' ', $result->presence_datetime)[1];
            return [
                'name'  => $userName,
                'type'  => $userLevel,
                'time'  => substr($time, 0, 5),
                'photo' => $result->presence_photo,
                'level' => $userDetail[0]->user_level
            ];
        } else {
            return [
                'name'  => $userName,
                'type'  => $userLevel,
                'time'  => '--:--',
                'photo' => '-',
                'level' => $userDetail[0]->user_level
            ];
        }

        return $search->getResult();
    }

    public function insertPresence(array $data): void
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