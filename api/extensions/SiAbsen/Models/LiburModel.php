<?php namespace SiAbsen\Models;

class LiburModel extends \Actudent\Core\Models\Connector
{
    private $holiday = 'tb_holiday';

    private $QBHoliday;

    public function __construct()
    {
        parent::__construct();
        $this->QBHoliday = $this->db->table($this->holiday);
    }
}