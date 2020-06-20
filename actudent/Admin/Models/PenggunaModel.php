<?php namespace Actudent\Admin\Models;

use Actudent\Core\Models\SekolahModel;
use Actudent\Admin\Models\SharedModel;

class PenggunaModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for table tb_user
     */
    private $QBUser;

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
        $this->QBUser = $this->db->table($this->user);
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
    public function getUser($limit, $offset, $orderBy = 'user_name', $searchBy = 'user_name', $sort = 'ASC', $whereClause = 'null', $search = '')
    {
        // $query = $this->search($searchBy, $search)->where('deleted', '0')->orderBy($orderBy, $sort)->limit($limit, $offset);
        // return $query->get()->getResult();

        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->user}.deleted" => '0',
                "{$this->user}.user_level" => $whereClause,
            ];
            $where = true;
        }
        else 
        {
            $where = false;
            $selector = ["{$this->user}.deleted" => '0'];
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
    public function getUserRows($searchBy = 'user_name', $whereClause = 'null', $search = '')
    {
        // $query = $this->search($searchBy, $search)->where('deleted', '0');
        // return $query->countAllResults();
        ///

        if($whereClause !== 'null')
        {
            $selector = [
                "{$this->user}.deleted" => '0',
                "{$this->user}.user_level" => $whereClause,
            ];
            $where = true;
        }
        else 
        {
            $where = false;
            $selector = ["{$this->user}.deleted" => '0'];
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
    public function getUserDetail($id)
    {
        $field = 'user_id, user_name, user_email, user_password, user_level, deleted, modified';
        $select = $this->QBUser->select($field)
                  ->where('user_id', $id)->get();

        return $select->getResult();                  
    }

    /**
     * Update user data
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function update($value, $id)
    {
        $data = $this->fillUserField($value);
        $this->QBUser->update($data, ['user_id' => $id]);
    }

    /**
     * Fill tb_user field with these data
     * 
     * @param array $data
     */
    private function fillUserField($data)
    {
        return [            
            'user_password' => password_hash($data['user_password'], PASSWORD_BCRYPT),
        ];
    }

    /**
     * Search for user by user_name, user_email fields
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return object
     */
    private function search($where, $searchBy, $search)
    {
        
        // If $where is true, then include user_name in $field
        $field = 'user_id, user_name, user_email, user_password, user_level, deleted, modified';
        if($where)
        {
            $field = $field . ', user_level';
        }

        $select = $this->QBUser->select($field);
                  
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
                $like1 = "($searchBy[0] LIKE '%$search%' ESCAPE '!' OR $searchBy[1]";
                $like2 = "'%$search%' ESCAPE '!')";
                $select->like($like1, $like2, 'none', false); 
                // $searchBy = explode('-', $searchBy);
                // $select->like($searchBy[0], $search); 
                // $select->orLike($searchBy[1], $search); 
                // $select->orLike($searchBy[2], $search); 
                // $select->orLike($searchBy[3], $search);
                // $select->orLike($searchBy[4], $search);
            }
            else 
            {
                $select->like($searchBy, $search); // search by one parameter
            }
        }
        
        return $select;
    }

}