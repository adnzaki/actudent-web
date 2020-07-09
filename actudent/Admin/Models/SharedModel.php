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
    public $QBStudent;

    /**
     * Query Builder for table tb_student_parent
     */
    protected $QBStudentParent;

    /**
     * Query Builder for table tb_student_grade
     */
    protected $QBRombel;

    /**
     * Query builder for tb_schedule
     */
    protected $QBJadwal;
    
    /**
     * Query Builder for tb_journal
     */
    protected $QBJurnal;

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
     * Table tb_student_grade
     * 
     * @var string
     */
    protected $rombel = 'tb_student_grade';

    /**
     * Table tb_schedule
     * 
     * @var string
     */
    protected $jadwal = 'tb_schedule';
    
    /**
     * Table tb_journal
     * 
     * @var string
     */
    protected $jurnal = 'tb_journal';

    /**
     * Table tb_lessons_grade
     * 
     * @var string
     */
    protected $mapelKelas = 'tb_lessons_grade';

    /**
     * Table tb_lessons
     * 
     * @var string
     */
    protected $mapel = 'tb_lessons';

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
        $this->QBRombel = $this->db->table($this->rombel);
        $this->QBJadwal = $this->db->table($this->jadwal);
        $this->QBJurnal = $this->db->table($this->jurnal);
    }
}