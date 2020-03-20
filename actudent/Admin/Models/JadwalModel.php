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
    private $kelas;

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
        $this->kelas = new KelasModel;
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
            return $query->get()->getResult();
        }
        else 
        {
            return false;
        }

    }

    /**
     * Get teacher name
     * 
     * @var int $id
     * @return object
     */
    public function getTeacherName($id)
    {
        $query = $this->pegawai->QBStaff->select('staff_name')->getWhere(['staff_id' => $id]);

        return $query->getResult()[0];
    }
}