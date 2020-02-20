<?php namespace Actudent\Admin\Models;

class SharedModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_parent
     */
    protected $QBParent;

    /**
     * Query Builder for table tb_user
     */
    protected $QBUser;

    /**
     * Query Builder for table tb_student
     */
    protected $QBStudent;

    /**
     * Query Builder for table tb_student_parent
     */
    protected $QBStudentParent;

    /**
     * Table tb_parent
     * 
     * @var string
     */
    protected $parent = 'tb_parent';

    /**
     * Table tb_user
     * 
     * @var string
     */
    protected $user = 'tb_user';

    /**
     * Table tb_student
     * 
     * @var string
     */
    protected $student = 'tb_student';
    
    /**
     * Table tb_student_parent
     * 
     * @var string
     */
    protected $studentParent = 'tb_student_parent';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBParent = $this->db->table($this->parent);
        $this->QBStudent = $this->db->table($this->student);
        $this->QBStudentParent = $this->db->table($this->studentParent);
        $this->QBUser = $this->db->table($this->user);
    }
}