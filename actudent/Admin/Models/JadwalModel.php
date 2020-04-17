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
     * Query builder for tb_schedule_settings
     */
    private $QBSettingJadwal;

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
     * Table tb_schedule
     * 
     * @var string
     */
    private $settingJadwal = 'tb_schedule_settings';

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
        $this->QBSettingJadwal = $this->db->table($this->settingJadwal);
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
                "{$this->mapelKelas}.deleted" => '0',
            ];

            $join = $this->lessonsGradeJoin();
            return $join->getWhere($param)->getResult();
        }
        else 
        {
            return false;
        }
    }

    /**
     * Get detail of lesson list
     * 
     * @param int $id #lessons_grade_id
     * 
     * @return object
     */
    public function getLessonDetail($id)
    {
        $join = $this->lessonsGradeJoin();
        return $join->getWhere(['lessons_grade_id' => $id])->getResult();
    }

    /**
     * Join tables: tb_lesson_grade, tb_lessons, tb_staff
     * 
     * @return QueryBuilder
     */
    private function lessonsGradeJoin()
    {
        $field  = "lessons_grade_id, {$this->mapelKelas}.lesson_id, lesson_name, teacher_id, staff_name as teacher";
        $select = $this->QBMapelKelas->select($field);
        $join1  = $select->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $join2  = $join1->join($this->pegawai->staff, "{$this->mapelKelas}.teacher_id = {$this->pegawai->staff}.staff_id");

        return $join2;
    }

    /**
     * Search lessons
     * 
     * Expencted query:
     * SELECT * FROM tb_lessons WHERE lesson_name LIKE '%ba%'
     * AND lesson_id NOT IN 
     * (SELECT lesson_id FROM tb_lessons_grade WHERE grade_id=2)
     * 
     * @param string $search
     * @return object
     */
    public function searchLessons($search, $grade)
    {
        $whereNotIn = " AND lesson_id NOT IN (SELECT lesson_id FROM {$this->mapelKelas} 
                        WHERE grade_id={$grade} AND deleted=0)";
        $param = "'%$search%' ESCAPE '!' $whereNotIn";
        $like = $this->QBMapel->like('lesson_name', $param, 'none', false);

        return $like->get()->getResult();
    }

    /**
     * Insert lessons to tb_lessons_grade
     * 
     * @param array $value
     * 
     * @return void
     */
    public function insert($value)
    {
        $this->QBMapelKelas->insert($value);
    }

    /**
     * Update tb_lessons_grade
     * 
     * @param array $value
     * @param int $id #lessons_grade_id
     * 
     * @return void
     */
    public function update($value, $id)
    {
        $this->QBMapelKelas->update($value, ['lessons_grade_id' => $id]);
    }

    /**
     * Mark lessons in tb_lessons_grade to "deleted"
     * 
     * @param int $id #lessons_grade_id
     * 
     * @return void
     */
    public function delete($id)
    {
        $this->QBMapelKelas->update(['deleted' => 1], ['lessons_grade_id' => $id]);
    }

    /**
     * Get days of schedule on specific grade
     * 
     * @param int $grade
     * @param string $day
     * 
     * @return object
     */
    public function getSchedules($grade, $day)
    {
        $field  = "schedule_id, {$this->mapelKelas}.lessons_grade_id, lesson_code, lesson_name, 
                   duration, schedule_start, schedule_end, staff_name as teacher";
        $join   = $this->QBJadwal->select($field)
                  ->join($this->mapelKelas, "{$this->mapelKelas}.lessons_grade_id = {$this->jadwal}.lessons_grade_id")
                  ->join($this->mapel, "{$this->mapelKelas}.lesson_id={$this->mapel}.lesson_id")
                  ->join($this->pegawai->staff, "{$this->pegawai->staff}.staff_id={$this->mapelKelas}.teacher_id");
        
        $param = [
            'grade_id' => $grade,
            'schedule_semester' => 1,
            'schedule_day' => $day,
        ];

        return $join->getWhere($param)->getResult();
    }

    /**
     * Save schedules
     * It might be insert new schedule or update schedule
     * if the value provided is existing in tb_schedule
     * 
     * @param array $data
     * 
     * @return void
     */
    public function saveSchedules($data)
    {
        foreach($data as $res)
        {
            $id = $res['schedule_id'];
            $value = [
                'lessons_grade_id'  => $res['lessons_grade_id'],
                'schedule_semester' => 1,
                'schedule_day'      => $res['schedule_day'],
                'duration'          => $res['duration'],
                'schedule_start'    => $res['schedule_start'],
                'schedule_end'      => $res['schedule_end'],
            ];

            if(preg_match('/new/', $id) === 0 && preg_match('/break/', $id) === 0)
            {
                $this->QBJadwal->update($value, ['schedule_id' => $id]);
            }
            else 
            {
                if(preg_match('/new/', $id) === 1)
                {
                    $this->QBJadwal->insert($value);
                }
            }
        }
    }

    /**
     * Delete schedules
     * 
     * @param array $data
     * @return void
     */
    public function deleteSchedules($data)
    {
        foreach($data as $val)
        {
            $this->QBJadwal->delete(['schedule_id' => $val]);
        }
    }

    /**
     * Get schedule time
     * 
     * @return object
     */
    public function getScheduleTime()
    {
        return $this->QBSettingJadwal->getWhere(['setting_name' => 'lesson_hour'])->getResult()[0];
    }

    /**
     * Get start time
     * 
     * @return object
     */
    public function getStartTime()
    {
        return $this->QBSettingJadwal->getWhere(['setting_name' => 'start_time'])->getResult()[0];
    }
}