<?php namespace Actudent\Admin\Models;

class OrtuModel extends SharedModel
{
    /**
     * Tables related to tb_user
     */
    private $QBTimelineComments;
    private $QBTimelineLikes;

    /**
     * Table definitions
     */
    private $timelineComments = 'tb_timeline_comments';
    private $timelineLikes = 'tb_timeline_likes';
    
    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBTimelineComments = $this->db->table($this->timelineComments);
        $this->QBTimelineLikes = $this->db->table($this->timelineLikes);
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
     * 
     * @return array
     */
    public function getParents($limit, $offset, $orderBy = 'parent_father_name', $searchBy = 'parent_father_name', $sort = 'ASC', $search = ''): array
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0')->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole parent data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getParentRows(string $searchBy = 'parent_father_name', string $search = ''): int
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0');

        return $query->countAllResults();
    }

    /**
     * Get parent detail
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getParentDetail(int $id): array
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
     * Get children list
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getChildren(int $id): array
    {
        $field = "student_nis, student_name, {$this->student}.deleted";
        $select = $this->QBStudent->select($field);
        $select->join($this->studentParent, "{$this->studentParent}.student_id = {$this->student}.student_id");

        return $select->getWhere(["{$this->studentParent}.parent_id" => $id])->getResult();
    }

    /**
     * Insert parent data
     * 
     * @param array $value
     * 
     * @return int
     */
    public function insert(array $value)
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

        return $this->db->insertID();
    }

    /**
     * Update parent data
     * 
     * @param array $value
     * @param int $id 
     * 
     * @return void
     */
    public function update(array $value, int $id): void
    {
        $data = $this->fillParentField($value);
        $this->QBParent->update($data, ['parent_id' => $id]);
    }

    /**
     * Delete parent and their user account
     * 
     * @param int parent_id
     * @param int user_id
     * 
     * @return void
     */
    public function delete(int $parentID, int $userID): void
    {
        $deleted = ['deleted' => '1'];
        $this->db->transStart();

        // start transcation
        $this->QBTimelineComments->delete(['user_id' => $userID]);
        $this->QBTimelineLikes->delete(['user_id' => $userID]);
        $this->QBParent->update($deleted, ['parent_id' => $parentID]);
        $this->QBUser->update($deleted, ['user_id' => $userID]);

        // transaction complete
        $this->db->transComplete();
    }

    /**
     * Fill tb_parent field with these data
     * 
     * @param array $data
     * 
     * @return array
     */
    private function fillParentField(array $data): array
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
     * 
     * @return array
     */
    private function fillUserField(array $data): array
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
     * @return QueryBuilder
     */
    private function search(string $searchBy, string $search)
    {
        $field = 'parent_id, user_id, parent_family_card, parent_father_name, parent_mother_name, parent_phone_number';
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