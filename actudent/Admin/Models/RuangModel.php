<?php namespace Actudent\Admin\Models;

class RuangModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder for tb_room
     */
    public $QBRuang;

    /**
     * Table tb_room
     * 
     * @var string
     */
    public $ruang = 'tb_room';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBRuang = $this->db->table($this->ruang);    
    }

     /**
     * Get room data
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getRoom($limit, $offset, $orderBy = 'room_name', $searchBy = 'room_name', $sort = 'ASC', $search = '')
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0')->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole room data
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getRoomRows($searchBy = 'room_name', $search = '')
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0');

        return $query->countAllResults();
    }

    /**
     * Get room detail
     * 
     * @param int $id
     * @return object
     */
    public function getRoomDetail($id)
    {
        $field = 'room_id, room_code, room_name';
        $select = $this->QBRuang->select($field)
                  ->where('room_id', $id)->get();

        return $select->getResult();                  
    }

    /**
     * Insert room data
     * 
     * @return void
     */
    public function insert($value)
    {
        $room = $this->fillRoomField($value);
        $this->QBRuang->insert($room);
    }

    /**
     * Update room data
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function update($value, $id)
    {
        $data = $this->fillRoomField($value);
        $this->QBRuang->update($data, ['room_id' => $id]);
    }

    /**
     * Delete room
     *
     * @param int room_id
     * 
     * @return void
     */
    public function delete($roomID)
    {
        $deleted = ['deleted' => '1'];
        $this->QBRuang->update($deleted, ['room_id' => $roomID]);
    }

    /**
     * Fill tb_room field with these data
     * 
     * @param array $data
     * @return array
     */
    private function fillRoomField($data)
    {
        return [
            'room_code'    => $data['room_code'],
            'room_name'    => $data['room_name'],
        ];
    }

    /**
     * Search for room by room_name, room_code fields
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return object
     */
    private function search($searchBy, $search)
    {
        $field = 'room_id, room_code, room_name';
        $select = $this->QBRuang->select($field);
        if(! empty($search))
        {
            // Store search parameter "room_code-room_name",
            // This code is not related to SSPaging plugin that only supports 1 search parameter
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $select->like($searchBy[0], $search); 
                $select->orLike($searchBy[1], $search); 
            }
            else 
            {
                $select->like($searchBy, $search); // search by one parameter
            }
        }

        return $select;
    }


}