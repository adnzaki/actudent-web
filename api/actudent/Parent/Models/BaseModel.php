<?php namespace Actudent\Parent\Models;

use Actudent\Admin\Models\SharedModel;
use Actudent\Admin\Models\AbsensiModel;
use Actudent\Admin\Models\KelasModel;
use Actudent\Admin\Models\SiswaModel;
use Actudent\Admin\Models\OrtuModel;

class BaseModel extends SharedModel
{
	public function getSiblings(int $studentId, int $parentId)
	{
		$model = new OrtuModel;

		return $model->getChildren($parentId, $studentId);
	}

	public function getParentId(int $studentId)
	{
		$model = new SiswaModel;

		return $model->getStudentDetail($studentId)[0]->parent_id;
	}

	/**
	 * Retrieves the homework assignments for a specific grade.
	 *
	 * @param int $gradeId The ID of the grade.
	 * @return array The homework assignments for the grade.
	 */
	public function getHomeworks(int $gradeId)
	{
		$model = new AbsensiModel;
		$kelas = new KelasModel;
		$field = 'homework_title, homework_description, due_date, lesson_name';
		$joinQuery = $model->QBHomework->select($field)
				 	 ->join($model->jurnal, "{$model->jurnal}.journal_id = {$model->homework}.journal_id")
				 	 ->join($model->jadwal, "{$model->jadwal}.schedule_id = {$model->jurnal}.schedule_id")
				 	 ->join($model->mapelKelas, "{$model->mapelKelas}.lessons_grade_id = {$model->jadwal}.lessons_grade_id")
				 	 ->join($kelas->kelas, "{$model->mapelKelas}.grade_id = {$kelas->kelas}.grade_id")
					 ->join($model->mapel, "{$model->mapel}.lesson_id = {$model->mapelKelas}.lesson_id");
		$filter = $joinQuery->where([
			"{$kelas->kelas}.grade_id" => $gradeId,
			'due_date >' => date('Y-m-d')
		])->orderBy('due_date', 'DESC')->limit(20, 0);

		return $filter->get()->getResult();
	}

	/**
	 * Retrieves the latest grade ID for a specific student.
	 *
	 * @param int $studentId The ID of the student.
	 * @return int|null The latest grade ID for the student, or null if no grade is found.
	 */
	public function getStudentGrade(int $studentId)
	{
		// here we get the latest Grade ID, so it will get the current lesson period
		$query = $this->QBRombel->orderBy('grade_id', 'DESC')->getWhere(['student_id' => $studentId]);

		return $query->getNumRows() > 0 ? $query->getResult()[0]->grade_id : null;
	}
}
