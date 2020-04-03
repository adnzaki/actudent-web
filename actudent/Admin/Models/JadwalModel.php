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
     * @param int $lesson
     * @param int $grade
     * 
     * @return object
     */
    public function getLessonDetail($lesson, $grade)
    {
        $param = [
            "{$this->mapelKelas}.lesson_id" => $lesson,
            'grade_id' => $grade,
        ];

        $join = $this->lessonsGradeJoin();
        return $join->getWhere($param)->getResult();
    }

    /**
     * Join tables: tb_lesson_grade, tb_lessons, tb_staff
     * 
     * @return QueryBuilder
     */
    private function lessonsGradeJoin()
    {
        $field  = "{$this->mapelKelas}.lesson_id, lesson_name, teacher_id, staff_name as teacher";
        $select = $this->QBMapelKelas->select($field);
        $join1  = $select->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $join2  = $join1->join($this->pegawai->staff, "{$this->mapelKelas}.teacher_id = {$this->pegawai->staff}.staff_id");

        return $join2;
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

    /**
     * Update tb_lessons_grade
     * 
     * @param int $grade
     * @param array $value
     * @param int $prevLesson #the previous lesson
     * 
     * @return void
     */
    public function update($grade, $value, $prevLesson)
    {
        $value['grade_id'] = $grade;
        $where = [
            'lesson_id' => $prevLesson,
            'grade_id' => $grade,
        ];

        $this->QBMapelKelas->update($value, $where);
    }

    /**
     * Mark lessons in tb_lessons_grade to "deleted"
     * 
     * @param int $grade
     * @param int $lesson
     * 
     * @return void
     */
    public function delete($grade, $lesson)
    {
        $param = [
            'grade_id' => $grade,
            'lesson_id' => $lesson
        ];

        $this->QBMapelKelas->update(['deleted' => 1], $param);
    }
}