<?php namespace SiAbsen\Models;

use Actudent\Admin\Models\SharedModel;

class CoreModel extends \Actudent\Admin\Models\PegawaiModel
{
    private $QBPresence;

    private $QBConfig;

    private $QBPermit;

    /**
     * @var string tb_staff_presence
     */
    private $staffPresence = 'tb_staff_presence';

    /**
     * @var string tb_staff_presence_config
     */
    private $presenceConfig = 'tb_staff_presence_config';

    /**
     * @var string tb_staff_presence_permit
     */
    private $presencePermit = 'tb_staff_presence_permit';

    private $shared;

    public function __construct()
    {
        parent::__construct();
        $this->QBPresence = $this->db->table($this->staffPresence);
        $this->QBConfig = $this->db->table($this->presenceConfig);
        $this->QBPermit = $this->db->table($this->presencePermit);
        $this->shared = new SharedModel;
    }

    /**
     * Get staff permissions
     * 
     * @param int $limit
     * @param int $offset
     * @param string $search | The date to be searched
     * @param mixed $staffId
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * 
     * @return array
     */
    public function getPermissions(
        int $limit, 
        int $offset, 
        string $search,
        $staffId,
        string $orderBy, 
        string $searchBy, 
        string $sort = 'ASC',
    ): array
    {
        $select = $this->search($searchBy, $search);
        if($staffId !== 'false') {
            $select->where(["{$this->presencePermit}.staff_id" => $staffId]);
        }

        $query = $select->orderBy($orderBy, $sort)->limit($limit, $offset);

        return $query->get()->getResult();
    }

    public function getPermissionRows($staffId)
    {
        $select = $this->QBPermit->select('*');
        if($staffId !== 'false') {
            $select->where(['staff_id' => $staffId]);
        }

        return $select->countAllResults();
    }

    private function search(string $searchBy = 'staff_name', string $search = '')
    {
        $field = "permit_id, {$this->presencePermit}.staff_id, staff_name, permit_date, permit_starttime, permit_endtime, permit_reason, permit_photo, permit_status";

        $select = $this->QBPermit->select($field);
        $join = $select->join($this->staff, "{$this->presencePermit}.staff_id={$this->staff}.staff_id");

        if(! empty($search)) {
            $join->like($searchBy, $search); // search by one parameter
        }
        
        return $join;
    }      

    public function insertPermit(array $data, int $staffId): void
    {
        $values = [
            'staff_id'          => $staffId,
            'permit_date'       => $data['permit_date'],
            'permit_starttime'  => $data['permit_starttime'],
            'permit_endtime'    => $data['permit_endtime'],
            'permit_reason'     => $data['permit_reason'],
            'permit_photo'      => $data['permit_photo'],
            'permit_status'     => 'submitted',
        ];

        $this->QBPermit->insert($values);
    }

    public function getTeacherSchedules(int $staffId)
    {
        $select = $this->shared->QBJadwal->select('DISTINCT `schedule_day`', false);
        $join = $select->join($this->shared->mapelKelas, "{$this->shared->jadwal}.lessons_grade_id = {$this->shared->mapelKelas}.lessons_grade_id");
        $where = $join->where(['teacher_id' => $staffId]);

        return $where->get()->getResult();
    }

    public function sendPresence(string $tag, array $data, int $id): void
    {
        $values = [
            'staff_id'          => $id,
            'presence_tag'      => $tag,
            'presence_lat'      => $data['lat'],
            'presence_long'     => $data['long'],
            'presence_photo'    => $data['photo']
        ];

        $this->QBPresence->insert($values);
    }

    public function getPresence(string $staffId, string $date, string $tag)
    {
        $params = [
            'presence_tag'  => $tag,
            'staff_id'      => $staffId
        ];

        $query = $this->QBPresence->like('presence_datetime', $date)->where($params)->get();
        $result = $query->getResult();

        return count($result) > 0 ? $result[0] : null;
    }

    public function getConfig(): object
    {
        return $this->QBConfig->get()->getResult()[0];
    }
}