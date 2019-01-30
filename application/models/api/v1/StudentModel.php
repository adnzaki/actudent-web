<?php defined('BASEPATH') OR exit('No direct script access allowed');

class StudentModel extends CI_Model {
    var $tableStudent = "tb_student";
    var $tableUserStudent = "tb_user_student";

    public function getStudentList($userId){
        $this->db->from($this->tableUserStudent);
        $this->db->join('tb_student', 'tb_student.student_id=tb_user_student.student_id');
		$this->db->where('tb_user_student.user_id',$userId);
		$query = $this->db->get();
		return $query->result();
    }
}