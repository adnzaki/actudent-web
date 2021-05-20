<?php namespace Actudent\Guru\Models;

class MainModel extends \Actudent\Admin\Models\SharedModel
{
    /**
     * Query Builder for table tb_staff
     */
    protected $QBStaff;

    /**
     * Table tb_staff
     * 
     * @var string
     */
    protected $staff = 'tb_staff';

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBStaff = $this->db->table($this->staff);
    }

    /**
     * Get teacher data by its user ID
     * This method should be available for all models and controllers
     * 
     * @param int $userID
     * 
     * @return object|null
     */
    public function getTeacherByUserID(int $userID)
    {
        $teacher = $this->QBStaff->select('staff_id, staff_name')
                        ->where('user_id', $userID)
                        ->get()
                        ->getResult();

        return $teacher[0];
    }
}