<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\SekolahModel;

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
     * SekolahModel
     */
    private $sekolah;
    
    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBParent = $this->db->table($this->parent);
        $this->QBStudent = $this->db->table($this->student);
        $this->QBUser = $this->db->table($this->user);
        $this->sekolah = new SekolahModel;
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
     * Get parent detail
     * 
     * @param int $id
     * @return object
     */
    public function getParentDetail($id)
    {
        $field = 'parent_id, tb_parent.user_id, parent_family_card, 
                  parent_father_name, parent_mother_name, parent_phone_number,
                  user_name, user_email';
        $select = $this->QBParent->select($field)
                  ->join($this->user, "{$this->parent}.user_id = {$this->user}.user_id")
                  ->where('parent_id', $id)->get();

        return $select->getResult();                  
    }

    /**
     * Insert parent data
     * 
     * @return
     */
    public function insert($value)
    {
        // insert user data first
        $user = $this->fillUserField($value);
        $this->QBUser->insert($user);

        // get the user_id
        $userID = $this->db->insertID();

        // then insert parent data
        $parent = $this->fillParentField($value);
        $parent['user_id'] = $userID;

        $this->QBParent->insert($parent);
    }

    /**
     * Fill tb_parent field with these data
     * 
     * @param array $data
     * @param int $userID
     * 
     * @return array
     */
    private function fillParentField($data)
    {
        return [
            'parent_family_card'    => $data['parent_family_card'],
            'parent_father_name'    => $data['parent_father_name'],
            'parent_mother_name'    => $data['parent_mother_name'],
            'parent_phone_number'   => $data['parent_phone_number'],
        ];
    }

    /**
     * Fill tb_user field with these data
     * 
     * @param array $data
     */
    private function fillUserField($data)
    {
        $sekolah = $this->sekolah->getDataSekolah()[0];
        return [
            'user_name'     => $data['user_name'],
            'user_email'    => $data['user_email'] . '@' . $sekolah->school_domain,
            'user_password' => password_hash($data['user_password'], PASSWORD_BCRYPT),
            'user_level'    => 3,
        ];
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
        $field = 'parent_id, parent_family_card, parent_father_name, parent_mother_name, parent_phone_number';
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