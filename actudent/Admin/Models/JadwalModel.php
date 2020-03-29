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
     * Query builder for tb_lessons_grade
     */
    private $QBMapelKelas;

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
     * Table tb_lessons_grade
     * 
     * @var string
     */
    private $mapelKelas = 'tb_lessons_grade';

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
        $this->QBMapelKelas = $this->db->table($this->mapelKelas);
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
        $query = $this->QBMapelKelas->where(['grade_id' => $grade]);
        if($query->countAllResults() > 0)
        {
            $param = [
                "{$this->mapel}.deleted" => '0',
                "{$this->mapelKelas}.grade_id" => $grade,
            ];

            $field  = "{$this->mapelKelas}.lesson_id, lesson_name, staff_name as teacher";
            $select = $this->QBMapelKelas->select($field);
            $join1  = $select->join($this->mapel, "{$this->mapel}.lesson_id = {$this->mapelKelas}.lesson_id");
            $join2  = $join1->join($this->rombel->kelas, "{$this->rombel->kelas}.grade_id = {$this->mapelKelas}.grade_id");
            $join3  = $join2->join($this->pegawai->staff, "{$this->pegawai->staff}.staff_id = {$this->mapelKelas}.teacher_id");
            return $join3->getWhere($param)->getResult();
        }
        else 
        {
            return false;
        }
    }

    /**
     * Search lessons
     * 
     * @param string $search
     * @return object
     */
    public function searchLessons($search)
    {
        return $this->QBMapel->like('lesson_name', $search)->get()->getResult();
    }

    /**
     * Insert lessons to tb_lessons_grade
     * 
     * @param int $grade
     * @param array $value
     * 
     * @return void
     */
    public function insert($grade, $value)
    {
        $value['grade_id'] = $grade;
        $this->QBMapelKelas->insert($value);
    }

    public function update($grade, $value, $id)
    {

    }
}