<?php namespace Actudent\Admin\Models;

class OrtuModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_parent
     */
    private $QBParent;

    /**
     * Query Builder for table tb_student_parent
     */
    private $QBStudentParent;

    /**
     * Query Builder for table tb_student
     */
    private $QBStudent;

    /**
     * Table tb_parent
     * 
     * @var string
     */
    private $parent = 'tb_parent';
    
    /**
     * Table tb_student_parent
     * 
     * @var string
     */
    private $studentParent = 'tb_student_parent';

    /**
     * Table tb_student
     * 
     * @var string
     */
    private $student = 'tb_student';
    
    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBParent = $this->db->table($this->parent);
        $this->QBStudentParent = $this->db->table($this->studentParent);
        $this->QBStudent = $this->db->table($this->student);
    }

    /**
     * Get parents data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getParents($limit, $offset, $orderBy = 'parent_father_name', $searchBy = 'parent_father_name', $sort = 'ASC', $search = '')
    {
        $query = $this->search($searchBy, $search)->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole parent data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getParentRows($searchBy = 'parent_father_name', $search = '')
    {
        $query = $this->search($searchBy, $search);

        return $query->countAllResults();
    }
    
    /**
     * Search for parents by parent_family_card, parent_father_name, parent_mother_name,
     * parent_phone_number fields
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return object
     */
    private function search($searchBy, $search)
    {
        $field = 'parent_family_card, parent_father_name, parent_mother_name, parent_phone_number';
        $select = $this->QBParent->select($field);
        if(! empty($search))
        {
            // Store search parameter "parent_family_card-parent_father_name-parent_mother_name-parent_phone_number",
            // This code is not related to SSPaging plugin that only supports 1 search parameter
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $select->like($searchBy[0], $search); 
                $select->orLike($searchBy[1], $search); 
                $select->orLike($searchBy[2], $search); 
                $select->orLike($searchBy[3], $search);
            }
            else 
            {
                $select->like($searchBy, $search); // search by one parameter
            }
        }

        return $select;
    }

    /**
     * Get the children of a parent
     * 
     * @param int $id
     * @return object
     */
    public function getParentChildren($id)
    {
        $parentChildren = $this->QBStudentParent->getWhere(['parent_id' => $id])->getResult();

        // process only if data is found
        if(count($parentChildren) > 0)
        {
            $parentChildren = explode(',', $parentChildren[0]->children);
            $children = [];
            foreach($parentChildren as $c)
            {
                $children[] = $this->findStudent($c);
            }
    
            return $children;
        }
    }

    /**
     * Find a student based on student_id
     * 
     * @param int $id
     * @return object
     */
    private function findStudent($id)
    {
        return $this->QBStudent->select('student_nis, student_name')
               ->where('student_id', $id)->get()->getResult()[0];
    }
}