<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\OrtuModel;

class SiswaModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_student
     */
    private $QBSiswa;

    /**
     * Query Builder for table tb_student_parent
     */
    private $QBStudentParent;

    /**
     * Table tb_student 
     * 
     * @var string
     */
    private $siswa = 'tb_student';

    /**
     * Table tb_student_parent
     * 
     * @var string
     */
    private $studentParent = 'tb_student_parent';

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
     * @var Actudent\Admin\Models\OrtuModel
     */
    private $ortu;

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBSiswa = $this->db->table($this->siswa);
        $this->QBStudentParent = $this->db->table($this->studentParent);
        $this->ortu = new OrtuModel;
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
        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->siswa}.deleted" => '0',
                "{$this->kelas}.grade_id" => $whereClause,
            ];
            $where = true;
        }
        else 
        {
            $where = false;
            $selector = ["{$this->siswa}.deleted" => '0'];
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
     * @param string $search
     * @return int
     */
    public function getSiswaRows($searchBy = 'student_name', $whereClause = 'null', $search = '')
    {
        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->siswa}.deleted" => '0',
                "{$this->kelas}.grade_id" => $whereClause,
            ];
            $where = true;
        }
        else 
        {
            $where = false;
            $selector = ["{$this->siswa}.deleted" => '0'];
        }

        $joinAndSearch = $this->joinAndSearchQuery($where, $searchBy, $search)->where($selector);

        return $joinAndSearch->countAllResults();
    }

    /**
     * Get student detail data from tb_student and tb_student_parent
     * 
     * @param int $id
     * @return object
     */
    public function getStudentDetail($id)
    {
        $field = "{$this->siswa}.student_id, student_nis, student_name, 
                  {$this->ortu->parent}.parent_id, parent_father_name, parent_mother_name";

        $select = $this->QBSiswa->select($field)
                  ->join($this->studentParent, "{$this->studentParent}.student_id = {$this->siswa}.student_id")
                  ->join($this->ortu->parent, "{$this->ortu->parent}.parent_id = {$this->studentParent}.parent_id");
        
        return $select->getWhere(["{$this->siswa}.student_id" => $id])->getResult();
    }

    /**
     * Insert student data into tb_student, tb_student_parent
     * 
     * @param array $value
     * @return
     */
    public function insert($value)
    {
        $student = $this->fillStudentField($value);
        $student['student_tag'] = 1;
        $this->QBSiswa->insert($student);

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
     * @return
     */
    public function update($value, $id)
    {
        $student = $this->fillStudentField($value);
        $student['student_tag'] = 2;
        $this->QBSiswa->update($student, ['student_id' => $id]);

        $studentParent = $this->fillStudentParentField($value);
        $this->QBStudentParent->update($studentParent, ['student_id' => $id]);
    }

    /**
     * Delete student from tb_student and tb_student_parent
     * by updating 'deleted' field to 1 (true) for both tables
     * and set student_tag to 3 (means deleted) in tb_student
     * 
     * @param int student_id
     * @return void
     */
    public function delete($id)
    {
        $where = ['student_id' => $id];
        $this->QBSiswa->update(['deleted' => '1', 'student_tag' => 3], $where);
        $this->QBStudentParent->update(['deleted' => '1'], $where);
    }

    /**
     * Fill student data with these values
     * 
     * @param array $data
     * @return array
     */
    public function fillStudentField($data)
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
     * @return array
     */
    public function fillStudentParentField($data)
    {
        return [
            'parent_id' => $data['parent_id'],
        ];
    }

    /**
     * Get parent data
     * 
     * @param string $keyword
     * @return object
     */
    public function getParents($keyword = '')
    {
        if(! empty($keyword))
        {            
            $field = 'parent_id, parent_family_card, parent_father_name, parent_mother_name';
            $like1 = "(parent_family_card LIKE '%$keyword%' ESCAPE '!' OR parent_father_name";
            $like2 = "'%$keyword%' ESCAPE '!' OR parent_mother_name LIKE '%$keyword%' ESCAPE '!')";
            $this->ortu->QBParent->select($field)->like($like1, $like2, 'none', false);

            return $this->ortu->QBParent->getWhere(['deleted' => '0'])->getResult();
        }
    }

    /**
     * Join table for tb_student, tb_student_grade dan tb_grade
     * and query to search data with "LIKE" keyword
     * 
     * @param string $searchBy
     * @param string $search
     * @return object
     */
    public function joinAndSearchQuery($where, $searchBy, $search)
    {
        // If $where is true, then include grade_name in $field
        $field = "{$this->siswa}.student_id, student_nis, student_name, parent_father_name, parent_mother_name";
        if($where)
        {
            $field = $field . ', grade_name';
        }

        $select = $this->QBSiswa->select($field)
                  ->join($this->studentParent, "{$this->studentParent}.student_id = {$this->siswa}.student_id")
                  ->join($this->ortu->parent, "{$this->ortu->parent}.parent_id = {$this->studentParent}.parent_id");
        // Create join table if $where is true
        if($where)
        {
            $select->join($this->kelasSiswa, "{$this->kelasSiswa}.student_id = {$this->siswa}.student_id")
                   ->join($this->kelas, "{$this->kelas}.grade_id = {$this->kelasSiswa}.grade_id");
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