<?php namespace Actudent\Guru\Models;

class NilaiModel extends SchedulePresenceModel
{
    /**
     * Get lessons list for teacher
     * 
     * @return array
     */
    public function getTeacherLessons(): array
    {
        $teacher    = $this->getTeacherByUserID($_SESSION['id']);
        $tbKelas    = $this->jadwalModel->kelas->kelas;
        $field      = "lessons_grade_id, {$this->mapelKelas}.grade_id, grade_name, 
                       {$this->mapelKelas}.lesson_id, lesson_name, {$this->mapelKelas}.teacher_id";

        $select = $this->jadwalModel->QBMapelKelas->select($field);
        $join1  = $select->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $join2  = $join1->join($tbKelas, "{$tbKelas}.grade_id = {$this->mapelKelas}.grade_id");

        return $join2->getWhere([
            "{$this->mapelKelas}.teacher_id" => $teacher->staff_id,
            "{$this->mapelKelas}.deleted" => 0,
        ])->getResult();
    }
}