<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\KelasModel;
use Actudent\Admin\Models\PegawaiModel;

class JadwalModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query builder for tb_schedule
     */
    private $QBJadwal;

    /**
     * Query builder for tb_lessons
     */
    private $QBMapel;

    /**
     * Table tb_schedule
     * 
     * @var string
     */
    private $jadwal = 'tb_schedule';

    /**
     * Table tb_lessons
     * 
     * @var string
     */
    private $mapel = 'tb_lessons';

    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    public $rombel;

    /**
     * @var Actudent\Admin\Models\PegawaiModel
     */
    private $pegawai;

    /**
     * Build the tables and models..
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBJadwal = $this->db->table($this->jadwal);
        $this->QBMapel = $this->db->table($this->mapel);
        $this->rombel = new KelasModel;
        $this->pegawai = new PegawaiModel;
    }

    /**
     * Get lessons of a class group
     * 
     * @var int $grade
     * @return object
     */
    public function getLessons($grade)
    {
        $query = $this->QBMapel->where(['grade_id' => $grade]);
        if($query->countAllResults() > 0)
        {
            $field  = 'lesson_id, lesson_name, staff_name as teacher';
            $select = $this->QBMapel->select($field);
            $join1  = $select->join($this->rombel->kelas, "{$this->rombel->kelas}.grade_id = {$this->mapel}.grade_id");
            $join2  = $join1->join($this->pegawai->staff, "{$this->pegawai->staff}.staff_id = {$this->mapel}.teacher_id");
            return $join2->get()->getResult();
        }
        else 
        {
            return false;
        }
    }
}