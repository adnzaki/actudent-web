<?php namespace Actudent\Admin\Models;

class SiswaModel extends SharedModel
{
     /**
     * Table tb_grade
     * 
     * @var string
     */
    private $kelas = 'tb_grade';

    /**
     * Query to get student data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $whereClause
     * @param string $search 
     * 
     * @return array
     */
    public function getSiswaQuery($limit, $offset, $orderBy = 'student_name', $searchBy = 'student_name', $sort = 'ASC', $whereClause = 'null', $search = ''): array
    {        
        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->student}.deleted" => '0',
                "{$this->kelas}.grade_id" => $whereClause,
            ];
            $where = true;
        }
        else 
        {
            $where = false;
            $selector = ["{$this->student}.deleted" => '0'];
        }
        
        $joinAndSearch = $this->joinAndSearchQuery($where, $searchBy, $search);

        // WHERE studentStatus = 1 ORDER BY studentName ASC LIMIT $offset, $limit         
        $query = $joinAndSearch->where($selector)->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole student data
     * 
     * @param string $searchBy
     * @param string $whereClause
     * @param string $search
     * 
     * @return int
     */
    public function getSiswaRows(string $searchBy = 'student_name', string $whereClause = 'null', string $search = ''): int
    {
        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->student}.deleted" => '0',
                "{$this->kelas}.grade_id" => $whereClause,
            ];
            $where = true;
        }
        else 
        {
            $where = false;
            $selector = ["{$this->student}.deleted" => '0'];
        }

        $joinAndSearch = $this->joinAndSearchQuery($where, $searchBy, $search)->where($selector);

        return $joinAndSearch->countAllResults();
    }

    /**
     * Get student detail data from tb_student and tb_student_parent
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getStudentDetail(int $id): array
    {
        $field = "{$this->student}.student_id, student_nis, student_name, 
                  {$this->parent}.parent_id, parent_father_name, parent_mother_name";

        $select = $this->QBStudent->select($field)
                  ->join($this->studentParent, "{$this->studentParent}.student_id = {$this->student}.student_id")
                  ->join($this->parent, "{$this->parent}.parent_id = {$this->studentParent}.parent_id");
        
        return $select->getWhere(["{$this->student}.student_id" => $id])->getResult();
    }

    /**
     * Insert student data into tb_student, tb_student_parent
     * 
     * @param array $value
     * 
     * @return void
     */
    public function insert(array $value): void
    {
        $student = $this->fillStudentField($value);
        $student['student_tag'] = 1;
        $this->QBStudent->insert($student);

        $studentID = $this->db->insertID();

        $studentParent = $this->fillStudentParentField($value);
        $studentParent['student_id'] = $studentID;
        $this->QBStudentParent->insert($studentParent);
    }

    /**
     * Update student data on tb_student, tb_student_parent
     * 
     * @param array $value
     * @param int $id
     * 
     * @return void
     */
    public function update(array $value, int $id): void
    {
        $student = $this->fillStudentField($value);
        if($this->nameHasChanged($student['student_name'], $id))
        {
            $student['student_tag'] = 2;
        }

        $this->QBStudent->update($student, ['student_id' => $id]);

        $studentParent = $this->fillStudentParentField($value);
        $this->QBStudentParent->update($studentParent, ['student_id' => $id]);
    }

    /**
     * Has student name changed?
     * 
     * @param string $newName
     * @param int $id
     * 
     * @return boolean
     */
    private function nameHasChanged(string $newName, int $id): bool
    {
        $getName = $this->QBStudent->select('student_name')->getWhere(['student_id' => $id]);
        if($getName->getResult()[0]->student_name === $newName)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Delete student from tb_student and tb_student_parent
     * by updating 'deleted' field to 1 (true) for both tables
     * and set student_tag to 3 (means deleted) in tb_student
     * 
     * @param int student_id
     * 
     * @return void
     */
    public function delete(int $id): void
    {
        $where = ['student_id' => $id];
        $this->QBStudent->update(['deleted' => '1', 'student_tag' => 3], $where);
        $this->QBStudentParent->update(['deleted' => '1'], $where);
        $this->QBRombel->update(['student_tag' => 3, 'deleted' => 1], $where);
    }

    /**
     * Fill student data with these values
     * 
     * @param array $data
     * 
     * @return array
     */
    public function fillStudentField(array $data): array
    {
        return [
            'student_nis'   => $data['student_nis'],
            'student_name'  => $data['student_name'],
        ];
    }
    
    /**
     * Values for tb_student_parent
     * 
     * @param array $data
     * 
     * @return array
     */
    public function fillStudentParentField(array $data): array
    {
        return [
            'parent_id' => $data['parent_id'],
        ];
    }

    /**
     * Get parent data
     * 
     * @param string $keyword
     * 
     * @return array
     */
    public function getParents(string $keyword = ''): array
    {
        if(! empty($keyword))
        {            
            $field = 'parent_id, parent_family_card, parent_father_name, parent_mother_name';
            $like1 = "(parent_family_card LIKE '%$keyword%' ESCAPE '!' OR parent_father_name";
            $like2 = "'%$keyword%' ESCAPE '!' OR parent_mother_name LIKE '%$keyword%' ESCAPE '!')";
            $this->QBParent->select($field)->like($like1, $like2, 'none', false);

            return $this->QBParent->getWhere(['deleted' => '0'])->getResult();
        }
        {
            return [];
        }
    }

    /**
     * Join table for tb_student, tb_student_grade dan tb_grade
     * and query to search data with "LIKE" keyword
     * 
     * @param bool $where
     * @param string $searchBy
     * @param string $search
     * 
     * @return QueryBuilder
     */
    public function joinAndSearchQuery(bool $where, string $searchBy, string $search)
    {
        // If $where is true, then include grade_name in $field
        $field = "{$this->student}.student_id, student_nis, student_name, parent_father_name, parent_mother_name";
        if($where)
        {
            $field = $field . ', grade_name';
        }

        $select = $this->QBStudent->select($field)
                  ->join($this->studentParent, "{$this->studentParent}.student_id = {$this->student}.student_id")
                  ->join($this->parent, "{$this->parent}.parent_id = {$this->studentParent}.parent_id");
        // Create join table if $where is true
        if($where)
        {
            $select->join($this->rombel, "{$this->rombel}.student_id = {$this->student}.student_id")
                   ->join($this->kelas, "{$this->kelas}.grade_id = {$this->rombel}.grade_id");
        }
        
        if(! empty($search))
        {
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $like1 = "($searchBy[0] LIKE '%$search%' ESCAPE '!' OR $searchBy[1]";
                $like2 = "'%$search%' ESCAPE '!')";
                $select->like($like1, $like2, 'none', false); 
            }
            else 
            {
                $select->like($searchBy, $search); // search by one parameter
            }
        }
        
        return $select;
    }
}