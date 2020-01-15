<?php namespace Actudent\Admin\Models;

class GuruModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_guru
     */
    private $QBGuru;

    /**
     * Table tb_teacher
     * 
     * @var string
     */
    private $guru = 'tb_teacher';

    public function __construct()
    {
        parent::__construct();
        $this->QBGuru = $this->db->table($this->guru);
    }

    /**
     * Query to get teacher data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getGuruQuery($limit, $offset, $orderBy = 'teacher_name', $searchBy = 'teacher_name', $sort = 'ASC', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);        

        // WHERE studentStatus = 1 ORDER BY studentName ASC LIMIT $offset, $limit         
        $query = $joinAndSearch->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole student data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getGuruRows($searchBy = 'teacher_name', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);

        return $joinAndSearch->countAllResults();
    }

    /**
     * Join table for tb_teacher, tb_student_grade dan tb_grade
     * and query to search data with "LIKE" keyword
     * 
     * @param string $searchBy
     * @param string $search
     * @return object
     */
    public function joinAndSearchQuery($searchBy, $search)
    {
        // Query:   SELECT studentNis, studentName, gradeName, studentStatus FROM tb_student
        //          JOIN tb_student_grade ON tb_student_grade.studentID = tb_student.studentID
        //          JOIN tb_grade ON tb_grade.gradeID = tb_student_grade.gradeID 
        $field = 'teacher_name, teacher_phone';
        $join = $this->QBGuru->select($field);
                // ->join($this->kelasSiswa, "{$this->kelasSiswa}.student_id = {$this->siswa}.student_id")
                // ->join($this->kelas, "{$this->kelas}.grade_id = {$this->kelasSiswa}.grade_id");
        
        if(! empty($search))
        {
            // Store search parameter "studentNis-studentName-gradeName",
            // so parameter could depends on field studentNis, studentName or gradeName.
            // This code is not related to SSPaging plugin that only supports 1 search parameter
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $join->like($searchBy[0], $search); 
                $join->orLike($searchBy[1], $search); 
            }
            else 
            {
                $join->like($searchBy, $search); // search by one parameter
            }
        }
        
        return $join;
    }
}