<?php namespace Actudent\Admin\Models;

class OrtuModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_parent
     */
    private $QBParent;

    /**
     * Table tb_parent
     * 
     * @var string
     */
    private $parent = 'tb_parent';
    
    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBParent = $this->db->table($this->parent);
    }

    public function getParents()
    {
        return $this->QBParent->get()->getResult();
    }
}