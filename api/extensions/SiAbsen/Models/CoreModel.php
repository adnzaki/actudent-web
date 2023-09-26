<?php namespace SiAbsen\Models;

use Actudent\Admin\Models\SharedModel;

class CoreModel extends \Actudent\Admin\Models\PegawaiModel
{
    private $QBPresence;

    private $QBConfig;

    private $QBPermit;

    private $QBSchedule;

    private $QBSnapshot;

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

    /**
     * @var string tb_staff_presence_schedule
     */
    private $presenceSchedule = 'tb_staff_presence_schedule';

    /**
     * @var string tb_staff_presence_snapshot
     */
    private $snapshot = 'tb_staff_presence_snapshot';

    private $shared;

    public function __construct()
    {
        parent::__construct();
        $this->QBPresence = $this->db->table($this->staffPresence);
        $this->QBConfig = $this->db->table($this->presenceConfig);
        $this->QBPermit = $this->db->table($this->presencePermit);
        $this->QBSchedule = $this->db->table($this->presenceSchedule);
        $this->QBSnapshot = $this->db->table($this->snapshot);
        $this->shared = new SharedModel;
    }

    public function getRecentPresence()
    {
        return $this->QBPresence
                    ->join($this->staff, "{$this->staffPresence}.staff_id={$this->staff}.staff_id")
                    ->like('presence_datetime', date('Y-m-d'))
                    ->orderBy('presence_datetime', 'DESC')
                    ->limit(5, 0)
                    ->get()->getResult();
    }

    public function getTodayStaffPresence($filter, $day, $limit, $offset, $orderBy = 'staff_name', $searchBy = 'staff_name', $sort = 'ASC', $search = '')
    {
        $baseQuery = $this->baseStaffScheduleQuery($day, $searchBy, $search);
        if($filter !== 'all') {
            $baseQuery->where(['staff_type' => $filter]);
        }

        return $baseQuery->orderBy($orderBy, $sort)
                         ->limit($limit, $offset)
                         ->get()->getResult();
    }

    public function getTodayStaffPresenceRows($filter, $day, string $searchBy, string $search = '')
    {
        $baseQuery = $this->baseStaffScheduleQuery($day, $searchBy, $search);
        if($filter !== 'all') {
            $baseQuery->where(['staff_type' => $filter]);
        }

        return $baseQuery->get()->getNumRows();
    }

    public function baseStaffScheduleRows($day, string $searchBy, string $search = '')
    {
        return $this->baseStaffScheduleQuery($day, $searchBy, $search)->get()->getNumRows();
    }

    public function baseStaffScheduleQuery($day, string $searchBy, string $search = '')
    {
        $field = "{$this->staff}.staff_id, staff_nik, staff_name";
        $select = $this->QBStaff->select($field)->where(['deleted' => 0]);        
        
        if($day !== null) {
            $this->QBStaff->join($this->presenceSchedule, "{$this->staff}.staff_id={$this->presenceSchedule}.staff_id");
            $select->where(['schedule_day' => $day]);
        }

        if(! empty($search)) {
            $select->like($searchBy, $search);
        }

        return $select;
    }

    // TO DO: CHANGE TO DATE PERIOD
    public function getMonthlyPresence(int $staffId, string $startDate, string $endDate)
    {
        $query = $this->db->query("CALL SP_GET_DETAIL_STAFF_PRESENCE_BY_DATE_PERIOD(:staffId:, :start:, :end:)", [
            'staffId'   => $staffId,
            'start'     => $startDate,
            'end'       => $endDate
        ]);

        return $query->getNumRows() > 0 ? $query->getResultArray() : null;
    }

    public function getTodaySchedule(int $staffId, int $day)
    {
        $query = $this->QBSchedule->getWhere([
            'staff_id'      => $staffId,
            'schedule_day'  => $day
        ]);

        return $query->getNumRows() > 0 ? $query->getResult()[0] : null;
    }

    public function updateSchedule(int $staffId, array $values): void
    {
        $this->db->transStart();
        if($this->scheduleExists($staffId)) {
            $this->QBSchedule->delete(['staff_id' => $staffId]);
        }
        
        if(count($values) > 0) {
            $this->QBSchedule->insertBatch($values);
        }

        $this->db->transComplete();
    }

    public function getSnapshot(int $staffId, string $date)
    {
        $query = $this->QBSnapshot->getWhere([
            'staff_id' => $staffId,
            'snapshot_date' => $date
        ]);

        if($query->getNumRows() > 0) {
            return $query->getResult()[0];
        } else {
            return null;
        }
    }

    public function getPresenceSchedule(int $staffId, $day = null)
    {
        if($this->scheduleExists($staffId)) {
            $params = ['staff_id' => $staffId];
            if($day !== null) {
                $params = [
                    'staff_id' => $staffId,
                    'schedule_day' => $day
                ];
            }
            
            $query = $this->QBSchedule->getWhere($params);
            return $query->getNumRows() > 0 
                    ? $query->getResultArray() 
                    : null;
        } else {
            return null;
        }
    }

    public function scheduleExists(int $staffId, $day = null): bool
    {
        $params = ['staff_id' => $staffId];
        if($day !== null) {
            $params['schedule_day'] = $day;
        }

        $check = $this->QBSchedule->where($params);

        return $check->countAllResults() > 0 ? true : false;
    }

    public function deletePermission($id)
    {
        $this->QBPermit->delete(['permit_id' => $id]);
    }

    public function getPermissionNotif()
    {
        return $this->QBPermit->getWhere(['permit_status' => 'submitted'])
                    ->getNumRows();
    }

    public function updateConfig($configId, $values): void
    {
        $this->QBConfig->update([
            'presence_timein'       => $values['intime'],
            'presence_timeout'      => $values['outtime'],
            'timelimit_allowed'     => $values['tolerance'] * 60,
            'latitude'              => $values['lat'],
            'longitude'             => $values['long'],
            'locationlimit_allowed' => $values['range']
        ], ['config_id' => $configId]);
    }

    public function hasPermissionToday(string $date, int $staffId)
    {
        $select = $this->QBPermit->where([
            'staff_id' => $staffId,
            'permit_date' => $date,
            'permit_status' => 'approved'
        ]);

        return $select->countAllResults() > 0 ? true : false;
    }

    public function setPermitStatus(string $status, int $id): void
    {
        $this->QBPermit->update(['permit_status' => $status], ['permit_id' => $id]);
    }

    public function getPermissionDetail(int $id)
    {
        return $this->QBPermit->getWhere(['permit_id' => $id])->getResult()[0];
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
        string $sort = 'ASC'
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
        $field = "permit_id, {$this->presencePermit}.staff_id, staff_name, permit_date, permit_starttime, permit_endtime, permit_presence, permit_reason, permit_photo, permit_status";

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
            'permit_presence'   => $data['permit_presence'],
            'permit_reason'     => $data['permit_reason'],
            'permit_photo'      => $data['permit_photo'],
            'permit_status'     => 'submitted',
        ];

        $this->QBPermit->insert($values);
    }

    public function getFirstAndLastSchedule(int $staffId, string $day, string $pointer)
    {
        if($pointer === 'min') {
            $select = $this->shared->QBJadwal->selectMin('schedule_start');
        } else {
            $select = $this->shared->QBJadwal->selectMax('schedule_end');
        }

        $join = $this->joinScheduleTeacherTable($select);
        $where = $join->where([
            'teacher_id' => $staffId,
            'schedule_status' => 'active',
            'schedule_day' => $day
        ]);

        return $where->get()->getResult()[0];        
    }

    public function getTeacherSchedules(int $staffId)
    {
        $select = $this->shared->QBJadwal->select('DISTINCT `schedule_day`', false);
        //$join = $select->join($this->shared->mapelKelas, "{$this->shared->jadwal}.lessons_grade_id = {$this->shared->mapelKelas}.lessons_grade_id");
        $join = $this->joinScheduleTeacherTable($select);
        $where = $join->where(['teacher_id' => $staffId, 'schedule_status' => 'active']);

        return $where->get()->getResult();
    }

    private function joinScheduleTeacherTable($select)
    {
        return $select->join($this->shared->mapelKelas, 
            "{$this->shared->jadwal}.lessons_grade_id = {$this->shared->mapelKelas}.lessons_grade_id"
        );
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