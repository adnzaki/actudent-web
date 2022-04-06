<?php namespace Actudent\Guru\Models;

use Actudent\Guru\Models\MainModel;
use Actudent\Admin\Models\JadwalModel;

class SchedulePresenceModel extends MainModel
{
    /**
     * @var Actudent\Admin\Models\JadwalModel
     */
    protected $jadwalModel;

    public function __construct()
    {
        parent:: __construct();
        $this->jadwalModel = new JadwalModel();
    }

    /**
     * Check if a teacher is homeroom teacher or not
     * 
     * @param int $userID
     * 
     * @return boolean
     */
    public function isHomeroomTeacher(int $userID): bool
    {
        $query = $this->jadwalModel->kelas
                      ->QBKelas
                      ->getWhere(['teacher_id' => $userID])
                      ->getResult();
        
        return (count($query) > 0) ? true : false;
    }

    /**
     * Get teacher schedules
     * 
     * @param string $day
     * 
     * @return array
     */
    public function getTeacherSchedules($day): array
    {
        $teacher = $this->getTeacherByUserID($_SESSION['id']);
        $tbKelas = $this->jadwalModel->kelas->kelas;
        $tbRuang = $this->jadwalModel->ruangan->ruang;

        $field  = "schedule_id, {$this->mapelKelas}.lessons_grade_id, {$this->mapelKelas}.grade_id, grade_name, 
                   {$this->mapelKelas}.lesson_id, lesson_code, lesson_name, {$this->mapelKelas}.teacher_id, 
                   staff_name as teacher, room_name, duration, schedule_start, schedule_end, schedule_order";
        $select = $this->jadwalModel->QBMapelKelas->select($field);
        $join1  = $select->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $join2  = $join1->join($this->staff, "{$this->mapelKelas}.teacher_id = {$this->staff}.staff_id");
        $join3  = $join2->join($this->jadwal, "{$this->mapelKelas}.lessons_grade_id={$this->jadwal}.lessons_grade_id");
        $join4  = $join3->join($tbRuang, "{$tbRuang}.room_id = {$this->jadwal}.room_id");
        $join5  = $join4->join($tbKelas, "{$tbKelas}.grade_id = {$this->mapelKelas}.grade_id");
        $params = [
            'schedule_status' => 'active',
            'schedule_day' => $day,
            "{$this->mapelKelas}.teacher_id" => $teacher->staff_id,
        ];

        return $join5->where($params)->orderBy('schedule_order', 'ASC')->get()->getResult();
    }
}