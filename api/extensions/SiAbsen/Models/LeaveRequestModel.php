<?php namespace SiAbsen\Models;

class LeaveRequestModel extends \Actudent\Core\Models\Connector
{
    private $leaveRequest = 'tb_leave_request';
    private $staff = 'tb_staff';

    private $QBLeaveRequest;

    public function __construct()
    {
        parent::__construct();
        $this->QBLeaveRequest = $this->db->table($this->leaveRequest);
    }

    public function getLeaveRequest(
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
            $select->where(["{$this->leaveRequestTable}.staff_id" => $staffId]);
        }

        $query = $select->orderBy($orderBy, $sort)->limit($limit, $offset);

        return $query->get()->getResult();
    }

    private function search(string $searchBy = 'staff_name', string $search = '')
    {
        $field = "leave_id, {$this->leaveRequest}.staff_id, staff_name, leave_type, reason, start_date, end_date, status, {$this->leaveRequest}.created";

        $select = $this->QBLeaveRequest->select($field);
        $join = $select->join($this->staff, "{$this->leaveRequest}.staff_id={$this->staff}.staff_id");

        if(!empty($search)) {
            $join->like($searchBy, $search); // search by one parameter
        }
        
        return $join;
    }   

    public function getLeaveRequestRows($staffId)
    {
        $select = $this->QBLeaveRequest->select('*');
        if($staffId !== 'false') {
            $select->where(['staff_id' => $staffId]);
        }

        return $select->countAllResults();
    }

    public function getLeaveRequestById($leaveId)
    {
        $field = "leave_id, {$this->leaveRequest}.staff_id, staff_name, staff_nik, staff_title, leave_type, reason, start_date, end_date, 
                CONCAT(working_period, ' ', working_period_label) as working_period, status, address, {$this->leaveRequest}.phone_number, {$this->leaveRequest}.created";
        $select = $this->QBLeaveRequest->select($field);
        $select->join($this->staff, "{$this->leaveRequest}.staff_id={$this->staff}.staff_id");
        $select->where(['leave_id' => $leaveId]);

        return $select->get()->getRowArray();  
    }

    public function updateLeaveRequest(array $data, $leaveId): void
    {
        $this->QBLeaveRequest->update($data, ['leave_id' => $leaveId]);
    }

    public function insertLeaveRequest(array $data): int
    {
        $this->QBLeaveRequest->insert($data);
        return $this->db->insertID();
    }

      
}