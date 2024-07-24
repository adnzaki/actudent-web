<?php namespace Actudent\Admin\Models;

use Actudent\Core\Models\SekolahModel;

class SharedModel extends \Actudent\Core\Models\Connector
{
    /**
     * Query Builder for table tb_parent
     */
    public $QBParent;

    /**
     * Query Builder for table tb_user
     */
    public $QBUser;

    /**
     * Query Builder for table tb_student
     */
    public $QBStudent;

    /**
     * Query Builder for table tb_student_parent
     */
    public $QBStudentParent;

    /**
     * Query Builder for table tb_student_grade
     */
    public $QBRombel;

    /**
     * Query builder for tb_schedule
     */
    protected $QBJadwal;

    /**
     * Query Builder for tb_journal
     */
    protected $QBJurnal;

    /**
     * Query Builder for tb_notification
     */
    protected $QBNotifikasi;

    /**
     * Query builder for tb_user_devices
     */
    protected $QBUserDevices;


    /**
     * Table tb_parent
     *
     * @var string
     */
    public $parent = 'tb_parent';

    /**
     * Table tb_user
     *
     * @var string
     */
    public $user = 'tb_user';

    /**
     * Table tb_student
     *
     * @var string
     */
    public $student = 'tb_student';

    /**
     * Table tb_student_parent
     *
     * @var string
     */
    public $studentParent = 'tb_student_parent';

    /**
     * Table tb_student_grade
     *
     * @var string
     */
    public $rombel = 'tb_student_grade';

    /**
     * Table tb_schedule
     *
     * @var string
     */
    protected $jadwal = 'tb_schedule';

    /**
     * Table tb_journal
     *
     * @var string
     */
    protected $jurnal = 'tb_journal';

    /**
     * Table tb_lessons_grade
     *
     * @var string
     */
    protected $mapelKelas = 'tb_lessons_grade';

    /**
     * Table tb_lessons
     *
     * @var string
     */
    protected $mapel = 'tb_lessons';

    /**
     * Table tb_notification
     *
     * @var string
     */
    protected $notifikasi = 'tb_notification';

    /**
     * Table tb_user_devices
     *
     * @var string
     */
    private $userDevices = 'tb_user_devices';


    /**
     * @var Actudent\Core\Models\SekolahModel
     */
    public $sekolah;

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBParent = $this->db->table($this->parent);
        $this->QBStudent = $this->db->table($this->student);
        $this->QBStudentParent = $this->db->table($this->studentParent);
        $this->QBUser = $this->db->table($this->user);
        $this->QBRombel = $this->db->table($this->rombel);
        $this->QBJadwal = $this->db->table($this->jadwal);
        $this->QBJurnal = $this->db->table($this->jurnal);
        $this->QBNotifikasi = $this->dbMain->table($this->notifikasi);
        $this->QBUserDevices = $this->db->table($this->userDevices);
        $this->sekolah = new SekolahModel;
    }

    /**
     * Get full domain of a school
     *
     * @return string
     */
    public function getSchoolDomain(): string
    {
        $sekolah = $this->sekolah->getDataSekolah()[0];

        return $sekolah->school_domain;
    }

    /**
     * Send notification to parent or staff
     *
     * @param array|int $recipient
     * @param array $content
     * @param string $type => student, mixed (parent and staff)
     *
     * @return void
     */
    public function sendNotification($recipient, array $content = [], string $type = 'student'): void
    {
        $values = [];
        $sekolah = $this->sekolah->getDataSekolah()[0];
        foreach($recipient as $id) {
            $userID = $this->checkUserDevice($id, $type);
            if($userID !== false) {
                $userDevice = $this->getUserDevice($userID)[0];
                $uri    = new \CodeIgniter\HTTP\URI(base_url());
                $values[] = [
                    'user_id'       => $userID,
                    'notif_from'    => $uri->getHost(),
                    'notif_to'      => $userDevice->fcm_registration_id,
                    'notif_title'   => $content['title'],
                    'notif_body'    => $content['body'],
                ];
            }
        }

        if(count($values) > 0) {
            $this->QBNotifikasi->insertBatch($values);
        }

    }

    /**
     * Get user device data
     *
     * @param int $userID
     *
     * @return array
     */
    protected function getUserDevice(int $userID): array
    {
        return $this->QBUserDevices->getWhere(['user_id' => $userID])->getResult();
    }

    /**
     * Check if a user is exist on tb_user_devices or not
     *
     * @param int $recipient => student_id | user_id
     * @param string $type => student, mixed (parent and staff)
     *
     * @return int|boolean
     */
    protected function checkUserDevice(int $recipient, string $type)
    {
        if($type === 'student')
        {
            $field = "student_name, {$this->studentParent}.parent_id, {$this->user}.user_id";
            $select = $this->QBStudent->select($field);
            $join1 = $select->join($this->studentParent, "{$this->student}.student_id={$this->studentParent}.student_id");
            $join2 = $join1->join($this->parent, "{$this->parent}.parent_id={$this->studentParent}.parent_id");
            $join3 = $join2->join($this->user, "{$this->user}.user_id={$this->parent}.user_id");
            $join4 = $join3->join($this->userDevices, "{$this->userDevices}.user_id={$this->user}.user_id");
            $row = $join4->where("{$this->student}.student_id", $recipient)->get()->getResult();
        }
        elseif($type === 'mixed')
        {
            $user = $this->QBUser->select("{$this->user}.user_id");
            $join = $user->join($this->userDevices, "{$this->userDevices}.user_id={$this->user}.user_id");
            $row = $join->where("{$this->userDevices}.user_id", $recipient)->get()->getResult();
        }

        return (count($row) > 0) ? $row[0]->user_id : false;
    }
}
