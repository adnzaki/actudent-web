<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AgendaModel extends CI_Model {
    var $tableAgenda = "tb_agenda";

    public function getAgendaList($userId, $agendaMonth, $agendaYear){
        $strWhere = array(
            'tb_agenda_user.user_id' => $userId,
            'MONTH(tb_agenda.agenda_start)' => $agendaMonth,
            'YEAR(tb_agenda.agenda_start)' => $agendaYear
        );
        $this->db->from($this->tableAgenda);
        $this->db->join('tb_agenda_user','tb_agenda.agenda_id=tb_agenda_user.agenda_id');
        $this->db->where($strWhere);
		$query = $this->db->get();
		return $query->result();
    }

    public function getAgendaDetail($agendaId){
        $this->db->from($this->tableAgenda);
        $this->db->where('agenda_id', $agendaId);
		$query = $this->db->get();
		return $query->row();
    }
}