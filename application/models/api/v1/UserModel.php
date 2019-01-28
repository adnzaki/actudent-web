<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    var $tableUser = "tb_user";

    public function checkUser($userEmail) {
        $query = $this->db->get_where($this->tableUser, ['userEmail' => $userEmail, 'userStatus' => '1']);
        if($query->num_rows() > 0){
            $user = $query->result();
            $response = array(
                'status' => TRUE,
                'userID' => $user[0]->userID, 
                'userName' => $user[0]->userName, 
                'userEmail' => $user[0]->userEmail,
                'userPassword' => $user[0]->userPassword,
                'userLevel' => $user[0]->userLevel);
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
		$this->db->where('userID',$userID);
		$query = $this->db->get();
		return $query->row();
    }

    public function insertUser($data){
        $this->db->insert($this->tableUser, $data);
		$this->db->insert_id();
    }

    public function updateUser($data, $userID) {
        $this->db->where('userID', $userID);
        $this->db->update($this->tableUser, $data);
		$this->db->affected_rows();
    }

    
}