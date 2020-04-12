<?php namespace Actudent\Admin\Models;

class AbsensiModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for tb_lesson
     */
    private $QBMapel;

    /**
     * Table tb_lesson
     * 
     * @var string
     */
    public $mapel = 'tb_lessons';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBMapel = $this->db->table($this->mapel);    
    }


}