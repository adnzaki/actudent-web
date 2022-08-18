<?php namespace SiAbsen\Models;

class KegiatanModel extends \Actudent\Admin\Models\AgendaModel
{
    public function getUserEvents(int $id, string $period)
    {
        $query = $this->QBAgenda->select("{$this->agenda}.agenda_id, agenda_name, agenda_start, agenda_end")
                 ->join($this->agendaUser, "{$this->agenda}.agenda_id={$this->agendaUser}.agenda_id")
                 ->like('agenda_start', $period)->where(["{$this->agendaUser}.user_id" => $id]);

        return $query->get()->getResult();
    }
}