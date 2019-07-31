<?php namespace Actudent\Admin\Models;

class KelasModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder
     */
    private $QBKelas;

     /**
     * Table tb_grade
     * 
     * @var string
     */
    private $kelas = 'tb_grade';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBKelas = $this->db->table($this->kelas);
    }

    /**
     * Query for getting student data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getKelasQuery($limit, $offset, $orderBy = 'grade_name', $searchBy = 'grade_name', $sort = 'ASC', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);        

        // WHERE studentStatus = 1 ORDER BY studentName ASC LIMIT $offset, $limit         
        $query = $joinAndSearch->where('grade_status', '1')->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole grade data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getKelasRows($searchBy = 'grade_name', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);

        return $joinAndSearch->where('grade_status', '1')->countAllResults();
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
        // Query:   SELECT grade_name, period_from, period_until, grade_status FROM tb_grade
        $field = 'grade_name, period_from, period_until, grade_status';
        $join = $this->QBKelas->select($field);
        
        if(! empty($search))
        {
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $this->db->like($searchBy[0], $search); 
                $this->db->or_like($searchBy[1], $search);                 
            }
            else 
            {
                $this->db->like($searchBy, $search);
            }
        }
        
        return $join;
    }

    /**
     * Get the grade list
     * 
     * @return void
     */
    public function getKelas()
    {
        return $this->QBKelas->get()->getResult();
    }
}