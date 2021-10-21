<?php namespace Actudent\Admin\Models;

class KelasModel extends SharedModel
{
    /**
     * Query Builder for tb_grade
     */
    public $QBKelas;

    /**
     * Query Builder for tb_staff
     */
    private $QBTeacher;

    /**
     * Table tb_grade
     * 
     * @var string
     */
    public $kelas = 'tb_grade';

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
     * 
     * @return array
     */
    public function getKelasQuery($limit, $offset, $orderBy = 'grade_name', $searchBy = 'grade_name', $sort = 'ASC', $search = ''): array
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);        
        $params = [
            "{$this->kelas}.deleted"    => 0, 
            'grade_status'              => '1',
            'period_start'              => '2019',
            'period_end'                => '2020'
        ];

        $query = $joinAndSearch->where($params)->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole grade data
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return int
     */
    public function getKelasRows(string $searchBy = 'grade_name', string $search = ''): int
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);
        $params = [
            "{$this->kelas}.deleted"    => 0, 
            'grade_status'              => '1',
            'period_start'              => '2021',
            'period_end'                => '2022'
        ];

        return $joinAndSearch->where($params)->countAllResults();
    }

    /**
     * Get class group detail data from tb_grade
     * 
     * @param int $id
     * 
     * @return object
     */
    public function getClassDetail(int $id): object
    {
        $field = 'grade_id, grade_name, teacher_id, staff_name, staff_nik';

        $select = $this->QBKelas->select($field)
                  ->join($this->teacher, "{$this->teacher}.staff_id = {$this->kelas}.teacher_id");
        
        return $select->getWhere(["{$this->kelas}.grade_id" => $id])->getResult()[0];
    }

    /**
     * Remove all students from a class group
     * 
     * @param int $grade 
     * 
     * @return void
     */
    public function emptyGroup(int $grade): void
    {
        $this->QBRombel->delete(['grade_id' => $grade]);
    }
    
    /**
     * Add a student to a class group
     * 
     * @param int $id
     * @param int $grade 
     * 
     * @return void
     */
    public function addMember(int $id, int $grade): void
    {
        $value = [
            'student_id'    => $id,
            'grade_id'      => $grade,
            'student_tag'   => 1
        ];

        $this->QBRombel->insert($value);
    }

    /**
     * Remove a student from a class group
     * 
     * @param int $id
     * 
     * @return void
     */
    public function removeMember(int $id): void
    {
        $this->QBRombel->delete(['student_id' => $id]);
    }

    /**
     * Get member of a class group
     * 
     * @param int $id grade_id
     * 
     * @return array
     */
    public function getClassMember(int $id): array
    {
        $query = $this->QBRombel->select("{$this->rombel}.student_id, student_nis, student_name")
                 ->join($this->student, "{$this->student}.student_id = {$this->rombel}.student_id")
                 ->where(['grade_id' => $id, "{$this->rombel}.student_tag !=" => 3])
                 ->orderBy('student_name', 'ASC');
        return $query->get()->getResult();
    }

    /**
     * Get students where not in class group
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * 
     * @return array
     */
    public function getUnregisteredStudents($limit, $offset, $orderBy = 'student_name', $searchBy = 'student_name', $sort = 'ASC', $search = ''): array
    {
        $select = $this->unregisteredStudentsQuery($searchBy, $search)->orderBy($orderBy, $sort)->limit($limit, $offset);

        return $select->get()->getResult();
    }

    /**
     * Count results of unregistered students
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return int
     */
    public function unregisteredStudentsRows(string $searchBy = 'student_name', string $search = ''): int
    {
        $select = $this->unregisteredStudentsQuery($searchBy, $search);

        return $select->countAllResults();
    }

    /**
     * Get unregistered students query
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return QueryBuilder
     */
    private function unregisteredStudentsQuery(string $searchBy, string $search)
    {
        $rombel = $this->QBRombel;
        $query = $this->QBStudent->select('student_id, student_nis, student_name');

        if(! empty($search))
        {
            $query->like($searchBy, $search);
        }

        return $query->whereNotIn('student_id', function($rombel) {
            return $rombel->select('student_id')->from($this->rombel);
        })->where('deleted', '0');
    }

    /**
     * Insert grade data into tb_grade
     * 
     * @param array $value
     * 
     * @return int
     */
    public function insert(array $value): int
    {
        $grade = $this->fillGradeField($value);
        $grade['period_start']  = '2021';
        $grade['period_end']    = '2022';
        $grade['grade_status']  = 1;

        $this->QBKelas->insert($grade);

        return $this->db->insertID();
    }

    /**
     * Update grade data into tb_grade
     * 
     * @param array $value
     * @param int $id
     * 
     * @return void
     */
    public function update(array $value, int $id): void
    {
        $grade = $this->fillGradeField($value);

        $this->QBKelas->update($grade, ['grade_id' => $id]);
    }

    /**
     * Delete a class group
     * 
     * @param int $grade
     * 
     * @return void
     */
    public function delete(int $grade): void
    {
        $this->db->transStart();
        $this->QBRombel->delete(['grade_id' => $grade]);
        $this->QBKelas->update(['deleted' => 1], ['grade_id' => $grade]);
        $this->db->transComplete();
    }

    /**
     * Fill grade data with these values
     * 
     * @param array $data
     * 
     * @return array
     */
    private function fillGradeField(array $data): array
    {
        return [
            'grade_name'        => $data['grade_name'],
            'teacher_id'        => $data['teacher_id'],
            'rombel_dapodik_id' => $data['rombel_dapodik_id']
        ];
    }

    /**
     * Search for teachers to be homeroom teacher
     * 
     * @param string $keyword
     * 
     * @return array
     */
    public function findTeacher(string $keyword = ''): array
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
     * 
     * @return QueryBuilder
     */
    public function joinAndSearchQuery(string $searchBy, string $search)
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
     * @return array
     */
    public function getKelas(): array
    {
        return $this->QBKelas->getWhere(['deleted' => 0, 'grade_status' => '1'])->getResult();
    }
}