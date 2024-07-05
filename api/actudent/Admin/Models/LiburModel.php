<?php namespace Actudent\Admin\Models;

class LiburModel extends \Actudent\Core\Models\Connector
{
    /**
     * Query Builder for tb_holidays
     */
    public $QBLibur;

    /**
     * Table tb_holidays
     *
     * @var string
     */
    public $libur = 'tb_holidays';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBLibur = $this->db->table($this->libur);
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
    public function getHolidays($limit, $offset, $orderBy = 'start_date', $searchBy = 'holiday_title', $sort = 'DESC', $search = ''): array
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
    public function getHolidaysRows(string $searchBy = 'room_name', string $search = ''): int
    {
        $query = $this->search($searchBy, $search)->where('deleted', '0');

        return $query->countAllResults();
    }

    /**
     * Get room detail
     *
     * @param int $id
     *
     * @return object
     */
    public function getHolidaysDetail(int $id): object
    {
        $field = 'holiday_id, holiday_title, start_date, end_date';
        $select = $this->QBLibur->select($field)
                  ->where('holiday_id', $id)->get();

        return $select->getResult()[0];
    }

    /**
     * Insert room data
     *
     * @param array $values
     *
     * @return void
     */
    public function insert(array $values): void
    {
        $this->QBLibur->insert($this->formatValues($values));
    }

    /**
     * Update room data
     *
     * @param array $values
     * @param int $id
     *
     * @return void
     */
    public function update(array $values, int $id): void
    {
        $this->QBLibur->update($this->formatValues($values), ['holiday_id' => $id]);
    }

	private function formatValues($values)
	{
		return [
			'holiday_title' => $values['holiday_title'],
			'start_date' => date('Y-m-d', $values['start_date']),
			'end_date' => date('Y-m-d', $values['end_date']),
		];
	}

    /**
     * Delete room
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->QBLibur->update(['deleted' => 1], ['holiday_id' => $id]);
    }

    /**
     * Search for holidays by title
     *
     * @param string $searchBy
     * @param string $search
     */
    private function search(string $searchBy, string $search)
    {
        $field = 'holiday_id, holiday_title, start_date, end_date';
        $select = $this->QBLibur->select($field);
        if(! empty($search)) {
			$select->like($searchBy, $search); // search by one parameter
        }

        return $select;
    }


}
