<?php namespace Actudent\Admin\Models;

class SiswaModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_siswa
     */
    private $QBSiswa;

    /**
     * Table tb_student 
     * 
     * @var string
     */
    private $siswa = 'tb_student';

     /**
     * Table tb_grade
     * 
     * @var string
     */
    private $kelas = 'tb_grade';

     /**
     * Table tb_student_grade
     * 
     * @var string
     */
    private $kelasSiswa = 'tb_student_grade';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBSiswa = $this->db->table($this->siswa);
    }

    /**
     * Query to get student data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getSiswaQuery($limit, $offset, $orderBy = 'student_name', $searchBy = 'student_name', $sort = 'ASC', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);        

        // WHERE studentStatus = 1 ORDER BY studentName ASC LIMIT $offset, $limit         
        $query = $joinAndSearch->where('student_status', '1')->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole student data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getSiswaRows($searchBy = 'student_name', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);

        return $joinAndSearch->where('student_status', '1')->countAllResults();
    }

    /**
     * Join table for tb_student, tb_student_grade dan tb_grade
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
        $field = 'student_nis, student_name, grade_name, student_status';
        $join = $this->QBSiswa->select($field)
                ->join($this->kelasSiswa, "{$this->kelasSiswa}.student_id = {$this->siswa}.student_id")
                ->join($this->kelas, "{$this->kelas}.grade_id = {$this->kelasSiswa}.grade_id");
        
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
                $join->orLike($searchBy[2], $search); 
            }
            else 
            {
                $join->like($searchBy, $search); // search by one parameter
            }
        }
        
        return $join;
    }
}