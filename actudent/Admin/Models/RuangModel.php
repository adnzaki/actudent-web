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
     * 
     * @return array
     */
    public function getRoom($limit, $offset, $orderBy = 'room_name', $searchBy = 'room_name', $sort = 'ASC', $search = ''): array
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0')->orderBy($orderBy, $sort)->limit($limit, $offset);
        return $query->get()->getResult();
    }

    /**
     * Count all rows of whole room data
     * 
     * @param string $searchBy
     * @param string $search
     * 
     * @return int
     */
    public function getRoomRows(string $searchBy = 'room_name', string $search = ''): int
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0');

        return $query->countAllResults();
    }

    /**
     * Get room detail
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getRoomDetail(int $id): array
    {
        $field = 'room_id, room_code, room_name';
        $select = $this->QBRuang->select($field)
                  ->where('room_id', $id)->get();

        return $select->getResult();                  
    }

    /**
     * Insert room data
     * 
     * @param array $value
     * 
     * @return void
     */
    public function insert(array $value): void
    {
        $room = $this->fillRoomField($value);
        $this->QBRuang->insert($room);
    }

    /**
     * Update room data
     * 
     * @param array $value
     * @param int $id 
     * 
     * @return void
     */
    public function update(array $value, int $id): void
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
    public function delete(int $roomID): void
    {
        $deleted = ['deleted' => '1'];
        $this->QBRuang->update($deleted, ['room_id' => $roomID]);
    }

    /**
     * Fill tb_room field with these data
     * 
     * @param array $data
     * 
     * @return array
     */
    private function fillRoomField(array $data): array
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
     * @return QueryBuilder
     */
    private function search(string $searchBy, string $search)
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