<?php namespace Actudent\Admin\Models;

class KelasModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for tb_grade
     */
    private $QBKelas;

    /**
     * Query Builder for tb_staff
     */
    private $QBTeacher;

    /**
     * Table tb_grade
     * 
     * @var string
     */
    private $kelas = 'tb_grade';

    /**
     * Table tb_grade
     * 
     * @var string
     */
    private $teacher = 'tb_staff';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBKelas = $this->db->table($this->kelas);
        $this->QBTeacher = $this->db->table($this->teacher);
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
     * Get class group detail data from tb_grade
     * 
     * @param int $id
     * @return object
     */
    public function getClassDetail($id)
    {
        $field = 'grade_id, grade_name, teacher_id, staff_name';

        $select = $this->QBKelas->select($field)
                  ->join($this->teacher, "{$this->teacher}.staff_id = {$this->kelas}.teacher_id");
        
        return $select->getWhere(["{$this->kelas}.grade_id" => $id])->getResult()[0];
    }

    /**
     * Insert grade data into tb_grade
     * 
     * @param array $value
     * 
     * @return void
     */
    public function insert($value)
    {
        $grade = $this->fillGradeField($value);
        $grade['period_start']  = '2019';
        $grade['period_end']    = '2020';
        $grade['grade_status']  = 1;

        $this->QBKelas->insert($grade);
    }

    /**
     * Update grade data into tb_grade
     * 
     * @param array $value
     * 
     * @return void
     */
    public function update($value, $id)
    {
        $grade = $this->fillGradeField($value);

        $this->QBKelas->update($grade, ['grade_id' => $id]);
    }

    /**
     * Fill grade data with these values
     * 
     * @param array $data
     * @return array
     */
    private function fillGradeField($data)
    {
        return [
            'grade_name'    => $data['grade_name'],
            'teacher_id'    => $data['teacher_id'],
        ];
    }

    /**
     * Search for teachers to be homeroom teacher
     * 
     * @param string $keyword
     * @return object
     */
    public function findTeacher($keyword = '')
    {
        if(! empty($keyword))
        {            
            $field = 'staff_id, staff_nik, staff_name';
            // $like1 = "(staff_nik LIKE '%$keyword%' ESCAPE '!' OR staff_name";
            // $like2 = "'%$keyword%' ESCAPE '!' OR parent_mother_name LIKE '%$keyword%' ESCAPE '!')";
            $this->QBTeacher->select($field)->like('staff_nik', $keyword)->orLike('staff_name', $keyword);

            return $this->QBTeacher->getWhere(['deleted' => '0'])->getResult();
        }
    }

    /**
     * Join table for tb_grade and tb_staff (as teacher)
     * and query to search data with "LIKE" keyword
     * 
     * @param string $searchBy
     * @param string $search
     * @return object
     */
    public function joinAndSearchQuery($searchBy, $search)
    {
        // Query:   SELECT grade_name, period_from, period_until, grade_status FROM tb_grade
        $field = 'grade_id, grade_name, period_start, period_end, staff_name';
        $join = $this->QBKelas->select($field)
                ->join($this->teacher, "{$this->teacher}.staff_id = {$this->kelas}.teacher_id");
        
        if(! empty($search))
        {
            $join->like($searchBy, $search);
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