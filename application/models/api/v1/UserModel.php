<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    var $tableUser = "tb_user";

    public function checkUser($userEmail) {
        $query = $this->db->get_where($this->tableUser, ['user_email' => $userEmail, 'user_status' => '1']);
        if($query->num_rows() > 0){
            $user = $query->result();
            $response = array(
                'status' => TRUE,
                'user_id' => $user[0]->user_id, 
                'user_name' => $user[0]->user_name, 
                'user_email' => $user[0]->user_email,
                'user_password' => $user[0]->user_password,
                'user_level' => $user[0]->user_level);
            return $response;
        } else {
            $response = array('status' => FALSE);
            return $response;
        }
    }

    public function checkUserbyId($userID) {
        $query = $this->db->get_where($this->tableUser, ['user_id' => $userID, 'user_status' => '1']);
        if($query->num_rows() > 0){
            $user = $query->result();
            $response = array(
                'status' => TRUE,
                'user_id' => $user[0]->user_id, 
                'user_name' => $user[0]->user_name, 
                'user_email' => $user[0]->user_email,
                'user_password' => $user[0]->user_password,
                'user_level' => $user[0]->user_level);
            return $response;
        } else {
            $response = array('status' => FALSE);
            return $response;
        }
    }

    public function isValidUser($whereArray) {
        $query = $this->db->get_where($this->tableUser, $whereArray);
        if($query->num_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getUserID($userID){
        $this->db->from($this->tableUser);
		$this->db->where('user_id',$userID);
		$query = $this->db->get();
		return $query->row();
    }

    public function insertUser($data){
        $this->db->insert($this->tableUser, $data);
		$this->db->insert_id();
    }

    public function updateUser($data, $userID) {
        $this->db->where('user_id', $userID);
        $this->db->update($this->tableUser, $data);
		$this->db->affected_rows();
    }

}