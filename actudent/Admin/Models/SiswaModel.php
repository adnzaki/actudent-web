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
    public function getSiswaQuery($limit, $offset, $orderBy = 'student_name', $searchBy = 'student_name', $sort = 'ASC', $whereClause = 'null', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);    
        $selector = ["{$this->siswa}.student_tag !=" => '3'];
        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->siswa}.student_tag !=" => '3',
                "{$this->kelas}.grade_id" => $whereClause,
            ];
        }

        // WHERE studentStatus = 1 ORDER BY studentName ASC LIMIT $offset, $limit         
        $query = $joinAndSearch->where($selector)->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole student data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getSiswaRows($searchBy = 'student_name', $whereClause = 'null', $search = '')
    {
        $selector = ["{$this->siswa}.student_tag !=" => '3'];
        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->siswa}.student_tag !=" => '3',
                "{$this->kelas}.grade_id" => $whereClause,
            ];
        }
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search)->where($selector);

        return $joinAndSearch->countAllResults();
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
        // Query:   SELECT student_nis, student_name, grade_name, tb_student.student_tag FROM tb_student
        //          JOIN tb_student_grade ON tb_student_grade.student_id = tb_student.student_id
        //          JOIN tb_grade ON tb_grade.grade_id = tb_student_grade.grade_id
        $field = 'student_nis, student_name, grade_name, tb_student.student_tag';
        $join = $this->QBSiswa->select($field)
                ->join($this->kelasSiswa, "{$this->kelasSiswa}.student_id = {$this->siswa}.student_id")
                ->join($this->kelas, "{$this->kelas}.grade_id = {$this->kelasSiswa}.grade_id");
        
        if(! empty($search))
        {
            // Store search parameter "studentNis-studentName-gradeName",
            // so parameter could depends on field studentNis, studentName or gradeName.
            // This code is not related to SSPaging plugin that only supports 1 search parameter
            // Query: WHERE (student_nis LIKE '%$search%' OR student_name LIKE '%$search%' OR grade_name LIKE '%$search%')
            //        AND (tb_student.student_tag != '3')
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $like1 = "($searchBy[0] LIKE '%$search%' ESCAPE '!' OR $searchBy[1]";
                $like2 = "'%$search%' ESCAPE '!' OR $searchBy[2] LIKE '%$search%' ESCAPE '!')";
                $join->like($like1, $like2, 'none', false); 
            }
            else 
            {
                $join->like($searchBy, $search); // search by one parameter
            }
        }
        
        return $join;
    }
}