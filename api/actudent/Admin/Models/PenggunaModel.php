<?php namespace Actudent\Admin\Models;

use Actudent\Core\Models\SekolahModel;
use Actudent\Admin\Models\SharedModel;

class PenggunaModel extends \Actudent\Core\Models\Connector
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
     * @param string $whereClause
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * 
     * @return array
     */
    public function getUser($whereClause, $limit, $offset, $orderBy = 'user_name', $searchBy = 'user_name', $sort = 'ASC', $search = ''): array
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
            $selector = [
                "{$this->user}.deleted" => '0',
                "{$this->user}.user_level !=" => '1'
            ];
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
     * @param string $whereClause
     * @param string $search
     * 
     * @return int
     */
    public function getUserRows($whereClause, string $searchBy = 'user_name', string $search = ''): int
    {
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
            $selector = [
                "{$this->user}.deleted" => '0',
                "{$this->user}.user_level !=" => '1'
            ];
        }

        $joinAndSearch = $this->search($where, $searchBy, $search)->where($selector);

        return $joinAndSearch->countAllResults();
    }

    /**
     * Get staff detail
     * 
     * @param int $id
     * 
     * @return object
     */
    public function getUserDetail(int $id): object
    {
        $field = 'user_id as id, user_name as name, user_email as email, user_level as level, modified';
        $select = $this->QBUser->select($field)
                  ->where('user_id', $id)->get();

        return $select->getResult()[0];                  
    }

    /**
     * Deactivate user account
     * 
     * @param int $id
     * 
     * @return void
     */
    public function deactivateUser(int $id): void
    {
        $this->QBUser->update(['deleted' => '1'], ['user_id' => $id]);
    }

    /**
     * Update user data
     * 
     * @param array $value
     * @param int $id 
     * 
     * @return void
     */
    public function update(array $value, int $id): void
    {
        $data = $this->fillUserField($value);
        $this->QBUser->update($data, ['user_id' => $id]);
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
            'user_password' => password_hash($data['user_password'], PASSWORD_BCRYPT),
        ];
    }

    /**
     * Search for user by user_name, user_email fields
     * 
     * @param boolean $where
     * @param string $searchBy
     * @param string $search
     * 
     * @return QueryBuilder
     */
    private function search(bool $where, string $searchBy, string $search)
    {        
        // If $where is true, then include user_name in $field
        $field = 'user_id as id, user_name as name, user_email as email, user_level as level, modified';
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