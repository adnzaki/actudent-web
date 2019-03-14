<?php namespace Actudent\Admin\Models;

class AgendaModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder untuk tabel tb_agenda
     */
    private $QBAgenda;

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

    public function __construct()
    {
        parent:: __construct();
        $this->QBAgenda = $this->db->table($this->agenda);
    }

    /**
     * Menarik data dari tb_agenda untuk dimasukkkan
     * ke dalam plugin FullCalendar
     * 
     * @return object
     */
    public function getEvents()
    {
        $query = $this->QBAgenda->select('agenda_id, agenda_name, agenda_start, agenda_end')
                 ->get()->getResult();
        
        return $query;
    }
}