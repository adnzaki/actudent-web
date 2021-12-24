<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\KelasModel;
use Actudent\Admin\Models\PegawaiModel;
use CodeIgniter\Database\BaseBuilder;

class JadwalModel extends SharedModel
{
    /**
     * Query builder for tb_schedule_settings
     */
    private $QBSettingJadwal;

    /**
     * Query builder for tb_lessons_grade
     */
    public $QBMapelKelas;

     /**
     * Query builder for tb_lessons
     */
    private $QBMapel;

    /**
     * Table tb_schedule
     * 
     * @var string
     */
    private $settingJadwal = 'tb_schedule_settings';    

    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    public $kelas;

    /**
     * @var Actudent\Admin\Models\PegawaiModel
     */
    private $pegawai;

    /**
     * @var Actudent\Admin\Models\RuangModel
     */
    public $ruangan;

    /**
     * Build the tables and models..
     */
    public function __construct()
    {
        parent::__construct();        
        $this->QBSettingJadwal = $this->db->table($this->settingJadwal);
        $this->QBMapelKelas = $this->db->table($this->mapelKelas);
        $this->QBMapel = $this->db->table($this->mapel);
        $this->kelas = new KelasModel;
        $this->pegawai = new PegawaiModel;
        $this->ruangan = new RuangModel;
    }

    /**
     * Get lessons of a class group
     * 
     * @var int $grade
     * 
     * @return array|boolean
     */
    public function getLessons(int $grade)
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
     * @return array
     */
    public function getLessonDetail(int $id): array
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
        $field  = "lessons_grade_id, {$this->mapelKelas}.lesson_id, lesson_code, lesson_name, teacher_id, staff_name as teacher";
        $select = $this->QBMapelKelas->select($field);
        $join1  = $select->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $join2  = $join1->join($this->pegawai->staff, "{$this->mapelKelas}.teacher_id = {$this->pegawai->staff}.staff_id");

        return $join2;
    }

    /**
     * Get lesson options
     * 
     * Expected query:
     * SELECT tb_lessons.lesson_id, lesson_code, lesson_name FROM tb_lessons
     * WHERE deleted=0
     * AND tb_lessons_grade.grade_id=1
     * AND tb_lessons.lesson_id NOT IN 
     * (SELECT tb_lessons_grade.lesson_id FROM tb_lessons_grade WHERE grade_id=1 AND deleted=0)
     * 
     * @param int $grade
     * 
     * @return array
     */
    public function getLessonOptions(int $grade): array
    {
        $field = "{$this->mapel}.lesson_id, lesson_code, lesson_name";
        $searchLessonGrade = $this->QBMapel->select($field)->where('deleted', 0);
        $notIn = $searchLessonGrade->whereNotIn('tb_lessons.lesson_id', function(BaseBuilder $builder) use ($grade) {
            return $builder->select('tb_lessons_grade.lesson_id')
                           ->from('tb_lessons_grade')
                           ->where(['grade_id' => $grade, 'deleted' => 0]);
        });

        return $notIn->get()->getResult();
    }

    /**
     * Insert lessons to tb_lessons_grade
     * 
     * @param array $value
     * 
     * @return void
     */
    public function insert(array $value): void
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
    public function update(array $value, int $id): void
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
    public function delete(int $id): void
    {
        $this->QBMapelKelas->update(['deleted' => 1], ['lessons_grade_id' => $id]);
    }

    /**
     * Get days of schedule on specific grade
     * 
     * @param int $grade
     * @param string $day
     * 
     * @return array
     */
    public function getSchedules(int $grade, string $day): array
    {
        $field  = "schedule_id, {$this->mapelKelas}.lessons_grade_id, lesson_code, lesson_name, 
                   duration, schedule_start, schedule_end, schedule_order, staff_name as teacher, 
                   {$this->ruangan->ruang}.room_id, room_name, room_code";
        $join   = $this->QBJadwal->select($field)
                  ->join($this->ruangan->ruang, "{$this->ruangan->ruang}.room_id = {$this->jadwal}.room_id")
                  ->join($this->mapelKelas, "{$this->mapelKelas}.lessons_grade_id = {$this->jadwal}.lessons_grade_id")
                  ->join($this->mapel, "{$this->mapelKelas}.lesson_id={$this->mapel}.lesson_id")
                  ->join($this->pegawai->staff, "{$this->pegawai->staff}.staff_id={$this->mapelKelas}.teacher_id");
        
        $param = [
            'grade_id'          => $grade,
            'schedule_semester' => $this->semester,
            'schedule_day'      => $day,
            'schedule_status'   => 'active',
        ];

        return $join->where($param)->orderBy('schedule_order', 'ASC')->get()->getResult();
    }

    /**
     * Get inactive schedules 
     * 
     * @param int $grade
     * 
     * @return array
     */
    public function getInactiveSchedules(int $grade): array
    {
        $field  = "schedule_id, {$this->jadwal}.lessons_grade_id, lesson_name";
        $select = $this->QBJadwal->select($field);
        $join1  = $select->join($this->mapelKelas, "{$this->jadwal}.lessons_grade_id = {$this->mapelKelas}.lessons_grade_id");
        $join2  = $join1->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $params = ['grade_id' => $grade, 'schedule_status' => 'inactive'];

        return $join2->where($params)->orderBy('lesson_name', 'ASC')->get()->getResult();
    }

    /**
     * Get active journal based on its schedule ID
     * 
     * @param mixed $scheduleId
     * 
     * @return int
     */
    public function getActiveJournal($scheduleId)
    {
        return $this->QBJurnal->where('schedule_id', $scheduleId)->countAllResults();
    }

    /**
     * Get room list
     * 
     * @return array
     */
    public function getRoomList(): array
    {
        return $this->ruangan->QBRuang
                             ->where('deleted', 0)
                             ->orderBy('room_name', 'ASC')
                             ->get()
                             ->getResult();
    }

    /**
     * Save schedules
     * It might be insert new schedule or update schedule
     * if the value provided is existing in tb_schedule
     * 
     * @param array $data
     * 
     * @return array
     */
    public function saveSchedules(array $data): array
    {
        $insertedValues = [];
        foreach($data as $res)
        {
            $id = $res['schedule_id'];
            $value = [
                'lessons_grade_id'  => $res['lessons_grade_id'],
                'room_id'           => $res['room_id'],
                'schedule_semester' => $this->semester,
                'schedule_day'      => $res['schedule_day'],
                'duration'          => $res['duration'],
                'schedule_start'    => $res['schedule_start'],
                'schedule_end'      => $res['schedule_end'],
                'schedule_order'    => $res['schedule_order'],
            ];

            if(preg_match('/new/', $id) === 0 
                && preg_match('/break/', $id) === 0
                && preg_match('/inactive/', $id) === 0)
            {
                $this->QBJadwal->update($value, ['schedule_id' => $id]);
            }
            else 
            {
                if(preg_match('/new/', $id) === 1)
                {
                    $this->QBJadwal->insert($value);
                }
                else 
                {
                    $split = explode('-', $id);
                    $value['schedule_status'] = 'active';
                    $this->QBJadwal->update($value, ['schedule_id' => $split[1]]);
                    $this->QBJurnal->update(['is_archive' => 0], ['schedule_id' => $split[1]]);
                }
            }

            if(preg_match('/inactive/', $id) === 1)
            {
                $id = explode('-', $id);
                $id = $id[1];
                $value['schedule_status'] = 'active';
            }

            $insertedValues[] = [
                'value' => $value,
                'id' => $id,
            ];
        }

        return $insertedValues;
    }

    /**
     * Set schedules to 'inactive' status
     * 
     * @param array $data
     * 
     * @return void
     */
    public function deleteSchedules(array $data): void
    {
        foreach($data as $val)
        {
            $this->QBJadwal->update(['schedule_status' => 'inactive'], ['schedule_id' => $val]);
            $this->QBJurnal->update(['is_archive' => 1], ['schedule_id' => $val]);
        }
    }

    /**
     * Save schedule settings
     * 
     * @param array $data
     * 
     * @return void
     */
    public function updateSettings(array $data): void
    {
        $start = $data['start_time'];
        $start = explode(':', $start);
        $hour = (int)$start[0];
        $minute = $start[1] / 60;
        $time = $hour + $minute;

        $lessonHour = ['setting_value' => $data['lesson_hour']];
        $startTime = ['setting_value' => $time];

        $this->QBSettingJadwal->update($lessonHour, ['setting_name' => 'lesson_hour']);
        $this->QBSettingJadwal->update($startTime, ['setting_name' => 'start_time']);
    }

    /**
     * Get schedule time
     * 
     * @return string
     */
    public function getScheduleTime(): string
    {
        $result = $this->QBSettingJadwal->getWhere(['setting_name' => 'lesson_hour'])->getResult()[0];
        return $result->setting_value;
    }

    /**
     * Get start time
     * 
     * @return string
     */
    public function getStartTime(): string
    {
        $result = $this->QBSettingJadwal->getWhere(['setting_name' => 'start_time'])->getResult()[0];
        return $result->setting_value;
    }
}