<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgendaModel extends CI_Model
{
    /**
     * Tabel tb_agenda
     * 
     * @var string
     */
    private $agenda = 'tb_agenda';

     /**
     * Tabel tb_agenda_user
     * 
     * @var string
     */
    private $agendaUser = 'tb_agenda_user';

    /**
     * Menarik data dari tb_agenda untuk dimasukkkan
     * ke dalam plugin FullCalendar
     * 
     * @return object
     */
    public function getEvents()
    {
        $query = $this->db->select('agenda_id, agenda_name, agenda_start, agenda_end')
                 ->from($this->agenda)->get()->result();
        
        return $query;
    }
}