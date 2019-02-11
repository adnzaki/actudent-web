<?php defined('BASEPATH') OR exit('No direct script access allowed');

class StudentModel extends CI_Model {
    var $tableStudent = "tb_student";
    var $tableUserStudent = "tb_user_student";
    var $tableGradeStudent = "tb_student_grade";
    var $tableGrade = "tb_grade";

    public function getStudentList($userId){
        $strQuery = "tb_user_student.user_id, tb_student.student_id, tb_student.student_nis, tb_student.student_name, tb_grade.grade_id, tb_grade.grade_name, tb_grade.period_from, tb_grade.period_until";
        $arrWhere = array(
            'tb_user_student.user_id' => $userId,
            'tb_user_student.user_student_status' => '1',
            'tb_student_grade.student_grade_status' => '1',
            'tb_grade.grade_status' => '1'
        );
        $this->db->select($strQuery);
        $this->db->from($this->tableUserStudent);
        $this->db->join($this->tableStudent, 'tb_student.student_id = tb_user_student.student_id');
        $this->db->join($this->tableGradeStudent, 'tb_student_grade.student_id = tb_student.student_id');
        $this->db->join($this->tableGrade, 'tb_grade.grade_id = tb_student_grade.grade_id');
        $this->db->where($arrWhere);
        $this->db->order_by('tb_student.student_name', 'ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function getStudentDetail($studentId){
        $this->db->from($this->tableStudent);
        $this->db->where('student_id',$studentId);
		$query = $this->db->get();
		return $query->row();
    }
}