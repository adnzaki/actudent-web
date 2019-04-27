<?php namespace Actudent\Admin\Models;

class AgendaModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder untuk tabel tb_agenda
     */
    private $QBAgenda;

    private $QBParent;

    /**
     * Tabel definition
     * 
     * @var string
     */
    private $agenda = 'tb_agenda';

    private $parent = 'tb_parent';

    private $user = 'tb_user';

    private $userStudent = 'tb_user_student';

    private $student = 'tb_student';

    private $studentGrade = 'tb_student_grade';

    private $grade = 'tb_grade';

    private $teacher = 'tb_teacher';

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
        $this->QBParent = $this->db->table($this->parent);
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

    public function searchGuest($search)
    {
        return $this->joinAndSearchQuery($search)->get()->getResult();
    }

    /**
     * Join And Search Query
     * Pencarian data kelas, guru atau orang tua dengan join tabel
     * 
     * @param string $search
     * @return object
     */
    private function joinAndSearchQuery($search)
    {
        $field = 'tb_parent.user_id as user_parent, tb_teacher.user_id as user_guru,
        parent_father_name, parent_mother_name, user_name,
        tb_user_student.student_id, student_name, tb_student_grade.grade_id, grade_name, teacher_name';
        $query = $this->QBParent->select($field)->join($this->user, "{$this->parent}.user_id = {$this->user}.user_id")
                ->join($this->userStudent, "{$this->user}.user_id = {$this->userStudent}.user_id")
                ->join($this->student, "{$this->userStudent}.student_id = {$this->student}.student_id")
                ->join($this->studentGrade, "{$this->student}.student_id = {$this->studentGrade}.student_id")
                ->join($this->grade, "{$this->studentGrade}.grade_id = {$this->grade}.grade_id and  {$this->grade}.grade_status = 1")
                ->join($this->teacher, "{$this->grade}.teacher_id = {$this->teacher}.teacher_id")
                ->like("{$this->grade}.grade_name", $search)->orLike("{$this->parent}.parent_father_name", $search)
                ->orLike("{$this->parent}.parent_mother_name", $search)->orLike("{$this->teacher}.teacher_name", $search);
        
        return $query;
                
    }
}