<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\KelasModel;

class AbsensiModel extends \Actudent\Admin\Models\SharedModel
{
    /**
     * Query Builder for tb_presence
     */
    private $QBAbsen;

    /**
     * Query Builder for tb_journal
     */
    private $QBJurnal;

    /**
     * Table tb_presence
     * 
     * @var string
     */
    public $absensi = 'tb_presence';

    /**
     * Table tb_journal
     * 
     * @var string
     */
    public $jurnal = 'tb_journal';

    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    public $kelas;

    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBAbsen = $this->db->table($this->absensi);
        $this->QBJurnal = $this->db->table($this->jurnal);
        $this->kelas = new KelasModel;
    }

    /**
     * Get presence of a student
     * 
     * @param int $journal >>> Journal ID
     * @param int $student >>> Student ID
     * @param string $date >>> Selected date
     * 
     * @return boolen|object
     */
    public function getPresence($journal, $student, $date)
    {
        $params = [
            'journal_id'    => $journal,
            'student_id'    => $student,
        ];

        $result = $this->QBAbsen->like('created', $date)->where($params);
        if($result->countAllResults() > 0)
        {          
            $presence = $result->get()->getResult()[0];

            return $presence->presence_status;
        }
        else
        {
            return null;
        }
    }

    public function getRombel()
    {
        $builder = $this->kelas->QBKelas;
        $params = ["{$this->kelas->kelas}.deleted" => 0, 'grade_status' => '1'];
        return $builder->select('grade_id, grade_name')->getWhere($params)->getResult();
    }

    public function getJadwal($day, $grade)
    {
        $field  = 'schedule_id, lesson_name';
        $select = $this->QBJadwal->select($field);
        $join1  = $select->join($this->mapelKelas, "{$this->jadwal}.lessons_grade_id = {$this->mapelKelas}.lessons_grade_id");
        $join2  = $join1->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $params = ['schedule_day' => $day, 'grade_id' => $grade];

        return $join2->where($params)->orderBy('schedule_id', 'ASC')->get()->getResult();
    }

}