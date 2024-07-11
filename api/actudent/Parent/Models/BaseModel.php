<?php namespace Actudent\Parent\Models;

use Actudent\Admin\Models\SharedModel;

class BaseModel extends SharedModel
{
	public function getStudentGrade(int $studentId)
	{
		// here we get the latest Grade ID, so it will get the current lesson period
		$query = $this->QBRombel->orderBy('grade_id', 'DESC')->getWhere(['student_id' => $studentId]);

		return $query->getNumRows() > 0 ? $query->getResult()[0]->grade_id : null;
	}
}
