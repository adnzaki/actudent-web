<?php namespace Actudent\Admin\Models;

class PegawaiModel extends \Actudent\Core\Models\Connector
{
    /**
     * Query Builder for table tb_staff
     */
    public $QBStaff;

     /**
     * Query Builder for table tb_user
     */
    public $QBUser;

    /**
     * Table tb_staff
     *
     * @var string
     */
    public $staff = 'tb_staff';
    /**
     * Table tb_user
     *
     * @var string
     */
    public $user = 'tb_user';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBStaff = $this->db->table($this->staff);
        $this->QBUser = $this->db->table($this->user);
    }

    /**
     * Query to get staff data
     *
     * @param string $staffType
     * @param int $limit
     * @param int $offset
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search
     *
     * @return array
     */
    public function getStaff($staffType, $limit, $offset, $orderBy = 'staff_name', $searchBy = 'staff_name', $sort = 'ASC', $search = ''): array
    {
        if($staffType !== 'null')
        {
            $selector = [
                "{$this->staff}.deleted" => '0',
                "{$this->staff}.staff_type" => $staffType,
            ];
            $where = true;
        }
        else
        {
            $where = false;
            $selector = ["{$this->staff}.deleted" => '0'];
        }

        $joinAndSearch = $this->search($where, $searchBy, $search);

        $query = $joinAndSearch->where($selector)->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole staff data
     *
     * @param string $staffType
     * @param string $searchBy
     * @param string $search
     *
     * @return int
     */
    public function getStaffRows(string $staffType = 'null', string $searchBy = 'staff_name', string $search = ''): int
    {
        // $query = $this->search($searchBy, $search)->where('deleted', '0');
        // return $query->countAllResults();
        ///

        if($staffType !== 'null')
        {
            $selector = [
                "{$this->staff}.deleted" => '0',
                "{$this->staff}.staff_type" => $staffType,
            ];
            $where = true;
        }
        else
        {
            $where = false;
            $selector = ["{$this->staff}.deleted" => '0'];
        }

        $joinAndSearch = $this->search($where, $searchBy, $search)->where($selector);

        return $joinAndSearch->countAllResults();
    }

     /**
     * Get staff detail
     *
     * @param int $id | the user_id not staff_id
     *
     * @return array
     */
    public function getStaffDetail(int $id): array
    {
        $field = 'tb_staff.user_id, staff_id, staff_nik,
                  staff_name, staff_phone, staff_type, staff_title,
                  user_name, user_email, staff_photo';
        $select = $this->QBStaff->select($field)
                  ->join($this->user, "{$this->staff}.user_id = {$this->user}.user_id")
                  ->where("{$this->staff}.user_id", $id)->get();

        return $select->getResult();
    }

    /**
     * Get staff photo
     *
     * @param int $id
     *
     * @return object
     */
    public function getPhoto(int $id): object
    {
        return $this->QBStaff->select('staff_photo')
                ->where(['staff_id' => $id])->get()->getResult()[0];
    }

    /**
     * Insert staff data
     *
     * @param array $value
     *
     * @return int
     */
    public function insert(array $value): int
    {
        // insert user data first
        $user = $this->fillUserField($value);

        // then insert staff data
        $staff = $this->fillStaffField($value);

        //get user level
        $employeeType = [
            'teacher'   => '2',
            'staff'     => '0'
        ];

        $user['user_level'] = $employeeType[$staff['staff_type']];

        // insert user table
        $this->QBUser->insert($user);

        // get the user_id
        $userID = $this->db->insertID();

        // insert staff table
        $staff['user_id'] = $userID;
        $staff['staff_tag'] = 1;
        $this->QBStaff->insert($staff);

        $staffID = $this->db->insertID();

        return $staffID;
    }


    /**
     * Update staff data
     *
     * @param array $value
     * @param int $id
     *
     * @return void
     */
    public function update(array $value, int $id): void
    {
        $data = $this->fillStaffField($value);
        $employeeType = [
            'teacher'   => '2',
            'staff'     => '0'
        ];

        $user = [
            'user_name'     => $data['staff_name'],
            'user_level'    => $employeeType[$data['staff_type']],
        ];

        $this->QBStaff->update($data, ['user_id' => $id]);
        $this->QBUser->update($user, ['user_id' => $id]);
    }

    /**
     * Delete staff and their user account
     *
     * @param int staff_id
     * @param int user_id
     *
     * @return void
     */
    public function delete(int $staffID, int $userID): void
    {
        $deleted = ['deleted' => '1'];
        $this->db->transStart();

        // start transcation
        $this->QBStaff->update($deleted, ['staff_id' => $staffID]);
        $this->QBUser->update($deleted, ['user_id' => $userID]);

        // transaction complete
        $this->db->transComplete();
    }

    /**
     * Fill tb_staff field with these data
     *
     * @param array $data
     *
     * @return array
     */
    private function fillStaffField(array $data): array
    {
        return [
            'staff_nik'     	=> $data['staff_nik'],
            'staff_name'    	=> $data['staff_name'],
            'staff_phone'   	=> $data['staff_phone'],
            'staff_type'    	=> $data['staff_type'],
            'staff_title'   	=> $data['staff_title'],
            'staff_photo'   	=> $data['featured_image'],
			'ptk_dapodik_id'	=> $data['ptk_dapodik_id'],
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
        return [
            'user_name'     => $data['user_name'],
            'user_email'    => $data['user_email'],
            'user_password' => password_hash($data['user_password'], PASSWORD_BCRYPT),
        ];
    }

    /**
     * Set the photo from user input
     *
     * @param string $filename
     * @param int $id
     *
     * @return void
     */
    public function setPhoto(string $filename, int $id): void
    {
        $this->QBStaff->where('user_id', $id)->update(['staff_photo' => $filename]);
    }

    /**
     * Search for staff by staff_nik, staff_name, staff_phone fields
     *
     * @param boolean $where
     * @param string $searchBy
     * @param string $search
     *
     * @return QueryBuilder
     */
    private function search(bool $where, string $searchBy, string $search)
    {

        // If $where is true, then include grade_name in $field
        $field = 'staff_id, user_id, staff_nik, staff_name, staff_phone, staff_type, staff_title';
        if($where)
        {
            $field = $field . ', staff_type';
        }

        $select = $this->QBStaff->select($field);

        // Create join table if $where is true
        if($where)
        {
            $select;
        }

        if(! empty($search))
        {
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $like1 = "($searchBy[0] LIKE '%$search%' ESCAPE '!' OR  $searchBy[1] LIKE '%$search%' ESCAPE '!' OR  $searchBy[2]";
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
