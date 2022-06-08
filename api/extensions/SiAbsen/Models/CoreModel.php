<?php namespace SiAbsen\Models;

use Actudent\Admin\Models\SharedModel;

class CoreModel extends \Actudent\Admin\Models\PegawaiModel
{
    private $QBPresence;

    private $QBConfig;

    private $QBPermit;

    private $staffPresence = 'tb_staff_presence';

    private $presenceConfig = 'tb_staff_presence_config';

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