<?php namespace Actudent\Admin\Models;

use Actudent\Core\Models\SekolahModel;

class PegawaiModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_staff
     */
    public $QBStaff;

     /**
     * Query Builder for table tb_user
     */
    private $QBUser;

     /**
     * Tables related to tb_user
     */
    private $QBTimelineComments;
    private $QBTimelineLikes;
    private $QBUserThemes;
    private $QBUserLang;


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
    private $user = 'tb_user';

    private $timelineComments = 'tb_timeline_comments';
    private $timelineLikes = 'tb_timeline_likes';
    private $userthemes = 'tb_user_themes';
    private $userlang = 'tb_user_language';
    
    /**
     * @var Actudent\Core\Models\SekolahModel
     */
    private $sekolah;

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBStaff = $this->db->table($this->staff);
        $this->QBUser = $this->db->table($this->user);
        $this->QBTimelineComments = $this->db->table($this->timelineComments);
        $this->QBTimelineLikes = $this->db->table($this->timelineLikes);
        $this->QBUserThemes = $this->db->table($this->userthemes);
        $this->QBUserLang = $this->db->table($this->userlang);
        $this->sekolah = new SekolahModel;
    }

    /**
     * Query to get staff data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getStaff($limit, $offset, $orderBy = 'staff_name', $searchBy = 'staff_name', $sort = 'ASC', $whereClause = 'null', $search = '')
    {
        // $query = $this->search($searchBy, $search)->where('deleted', '0')->orderBy($orderBy, $sort)->limit($limit, $offset);
        // return $query->get()->getResult();

        // kjkjkjk

        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->staff}.deleted" => '0',
                "{$this->staff}.staff_type" => $whereClause,
            ];
            $where = true;
        }
        else 
        {
            $where = false;
            $selector = ["{$this->staff}.deleted" => '0'];
        }
        
        $joinAndSearch = $this->search($where, $searchBy, $search);

        // WHERE studentStatus = 1 ORDER BY studentName ASC LIMIT $offset, $limit         
        $query = $joinAndSearch->where($selector)->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole staff data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getStaffRows($searchBy = 'staff_name', $whereClause = 'null', $search = '')
    {
        // $query = $this->search($searchBy, $search)->where('deleted', '0');
        // return $query->countAllResults();
        ///

        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->staff}.deleted" => '0',
                "{$this->staff}.staff_type" => $whereClause,
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
     * @param int $id
     * @return object
     */
    public function getStaffDetail($id)
    {
        $field = 'tb_staff.user_id, staff_id, staff_nik, 
                  staff_name, staff_phone, staff_type, staff_title,
                  user_name, user_email';
        $select = $this->QBStaff->select($field)
                  ->join($this->user, "{$this->staff}.user_id = {$this->user}.user_id")
                  ->where('tb_staff.user_id', $id)->get();

        return $select->getResult();                  
    }

    public function getPhoto($id)
    {
        return $this->QBStaff->select('staff_photo')
                ->where(['staff_id' => $id])->get()->getResult()[0];
    }

    /**
     * Insert staff data
     * 
     * @return void
     */
    public function insert($value)
    {
        // insert user data first
        $user = $this->fillUserField($value);
        // then insert staff data
        $staff = $this->fillStaffField($value);
        //get user level
        if($staff['staff_type'] == 'teacher')
        {
            $user['user_level'] = '2';
        }
        else
        {
            $user['user_level'] = '0';
        };
        //insert user table
        $this->QBUser->insert($user);
        // get the user_id
        $userID = $this->db->insertID();
        //isert staff table
        $staff['user_id'] = $userID;
        $staff['staff_tag'] = 1;
        $this->QBStaff->insert($staff);
        //insert user themes table
        $theme['user_id'] = $userID;
        $theme['theme'] = 'light-blue';
        $this->QBUserThemes->insert($theme);
        //insert user language table
        $lang['user_id'] = $userID;
        $lang['user_language'] = 'indonesia';
        $this->QBUserLang->insert($lang);
    }
   

    /**
     * Update staff data
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function update($value, $id)
    {
        $data = $this->fillStaffField($value);
        if($data['staff_type'] == 'teacher')
        {
            $user['user_level'] = '2';
        }
        else
        {
            $user['user_level'] = '0';
        };        
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
    public function delete($staffID, $userID)
    {
        $deleted = ['deleted' => '1'];
        $this->db->transStart();

        // start transcation
        $this->QBTimelineComments->delete(['user_id' => $userID]);
        $this->QBTimelineLikes->delete(['user_id' => $userID]);
        $this->QBStaff->update($deleted, ['staff_id' => $staffID]);
        $this->QBUser->update($deleted, ['user_id' => $userID]);

        // transaction complete
        $this->db->transComplete();
    }

    /**
     * Fill tb_staff field with these data
     * 
     * @param array $data
     * @return array
     */
    private function fillStaffField($data)
    {
        return [
            'staff_nik'     => $data['staff_nik'],
            'staff_name'    => $data['staff_name'],
            'staff_phone'   => $data['staff_phone'],
            'staff_type'    => $data['staff_type'],
            'staff_title'   => $data['staff_title'],
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
            // 'user_level'    => $data['user_level'],
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
    public function setPhoto($filename, $id)
    {        
        $this->QBStaff->where('user_id', $id)->update(['staff_photo' => $filename]);
    }

    /**
     * Search for staff by staff_nik, staff_name, staff_phone fields
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return object
     */
    private function search($where, $searchBy, $search)
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
                $like1 = "($searchBy[0] LIKE '%$search%' ESCAPE '!' OR  $searchBy[1] LIKE '%$search%' ESCAPE '!' 
                    OR  $searchBy[2] LIKE '%$search%' ESCAPE '!' OR  $searchBy[3]";                
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