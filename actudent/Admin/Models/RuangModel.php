<?php namespace Actudent\Admin\Models;

class RuangModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for tb_lesson
     */
    private $QBRuang;

    /**
     * Table tb_lesson
     * 
     * @var string
     */
    public $ruang = 'tb_room';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBRuang = $this->db->table($this->ruang);    
    }


}