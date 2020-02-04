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
     * Query Builder for table tb_user
     */
    private $QBUser;

    /**
     * Table tb_parent
     * 
     * @var string
     */
    private $parent = 'tb_parent';

    /**
     * Table tb_student
     * 
     * @var string
     */
    private $student = 'tb_student';

    /**
     * Table tb_user
     * 
     * @var string
     */
    private $user = 'tb_user';
    
    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBParent = $this->db->table($this->parent);
        $this->QBStudent = $this->db->table($this->student);
        $this->QBUser = $this->db->table($this->user);
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
     * Insert parent data
     * 
     * @return
     */
    public function insert($value)
    {
        $data = $this->fillParentField($value);
        $this->QBParent->insert($data);
    }

    /**
     * Fill tb_parent field with these data
     * 
     * @param array $data
     * @return array
     */
    private function fillParentField($data)
    {
        return [
            'user_id'               => $data['user_id'],
            'parent_family_card'    => $data['parent_family_card'],
            'parent_father_name'    => $data['parent_father_name'],
            'parent_mother_name'    => $data['parent_mother_name'],
            'parent_phone_number'   => $data['parent_phone_number'],
            'modified'              => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Select user account for parent user auth
     * 
     * @param int $userID
     * @return bool|object
     */
    public function selectUser($userID)
    {
        $query = $this->QBParent->select('user_id')
                 ->where('user_id', $userID);
        if($query->countAllResults() > 0)
        {
            return false;
        }
        else 
        {
            $findUser = $this->QBUser->select('user_id, user_email, user_name')
                        ->where('user_id', $userID);
            return $findUser->get()->getResult();
        }

    }

    /**
     * Search user account
     * 
     * @param string $param
     * @return object
     */
    public function searchUser($param)
    {
        $field = 'user_id, user_name, user_email';
        $select = $this->QBUser->select($field);
        $select->like('user_name', $param)->where('user_level', 3); 
        return $select->orderBy('user_name', 'ASC')->get()->getResult();
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
}