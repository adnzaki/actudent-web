<?php namespace SiAbsen\Models;

class CoreModels extends \Actudent\Admin\Models\PegawaiModel
{
    private $QBPresence;

    private $QBConfig;

    private $QBPermit;

    private $staffPresence = 'tb_staff_presence';

    private $presenceConfig = 'tb_staff_presence_config';

    private $presencePermit = 'tb_staff_presence_permit';

    public function __construct()
    {
        parent::__construct();
        $this->QBPresence = $this->db->table($this->staffPresence);
        $this->QBConfig = $this->db->table($this->presenceConfig);
        $this->QBPermit = $this->db->table($this->presencePermit);
    }

    public function getConfig(): object
    {
        return $this->QBConfig->get()->getResult()[0];
    }
}