<?php namespace Actudent\Admin\Models;

class AgendaModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * The Query Builders
     */
    private $QBAgenda;

    private $QBParent;

    private $QBAgendaUser;

    /**
     * Table definition
     * 
     * @var string
     */
    private $agenda = 'tb_agenda';

    private $agendaUser = 'tb_agenda_user';

    private $parent = 'tb_parent';

    private $user = 'tb_user';

    private $userStudent = 'tb_user_student';

    private $student = 'tb_student';

    private $studentGrade = 'tb_student_grade';

    private $grade = 'tb_grade';

    private $teacher = 'tb_teacher';

    public function __construct()
    {
        parent:: __construct();
        $this->QBAgenda = $this->db->table($this->agenda);
        $this->QBParent = $this->db->table($this->parent);
        $this->QBAgendaUser = $this->db->table($this->agendaUser);
    }

    /**
     * Grab data from tb_agenda and put them in FullCalendar plugin
     * 
     * @return object
     */
    public function getEvents()
    {
        $query = $this->QBAgenda->select('agenda_id, agenda_name, agenda_start, agenda_end')
                 ->get()->getResult();
        
        return $query;
    }

    /**
     * Insert data from user input to tb_agenda and its relations
     * 
     * @param array $data
     * @return int
     */
    public function insert($data)
    {
        $this->QBAgenda->insert([
            'agenda_name'           => $data['agenda_name'],
            'agenda_start'          => date('Y-m-d H:i:s', $data['agenda_start']),
            'agenda_end'            => date('Y-m-d H:i:s', $data['agenda_end']),
            'agenda_description'    => $data['agenda_description'],
            'agenda_priority'       => $data['agenda_priority'],
            'agenda_location'       => $data['agenda_location'],
            'user_id'               => session()->get('id'),
            'modified'              => date('Y-m-d H:i:s'),
        ]);
        
        // insert data to tb_agenda
        $insertID = $this->db->insertID();

        if(! empty($data['agenda_guest']))
        {
            // insert guest IDs to tb_agenda_user
            $this->insertAgendaGuests($data['agenda_guest'], $insertID);
        }

        return $insertID;
    }

    /**
     * Set the attachment from user input
     * 
     * @param string $filename
     * @param int $id
     * 
     * @return void
     */
    public function setAttachment($filename, $id)
    {        
        $this->QBAgenda->where('agenda_id', $id)->update(['agenda_attachment' => $filename]);
    }

    /**
     * Insert guest IDs to tb_agenda_user
     * 
     * @param string $data
     * @param int $id
     * 
     * @return void
     */
    private function insertAgendaGuests($data, $id)
    {
        $this->QBAgendaUser->insert([
            'agenda_id' => $id,
            'guests'   => $data,
            'modified'  => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Search the guests!
     * 
     * @param string $search
     * 
     * @return object
     */
    public function searchGuest($search)
    {
        return $this->joinAndSearchQuery($search)->get()->getResult();
    }

    /**
     * Join And Search Query
     * Search for grade, teacher or parent with join table
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