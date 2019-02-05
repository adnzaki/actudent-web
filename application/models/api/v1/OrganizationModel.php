<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OrganizationModel extends CI_Model {
    var $tableOrganization = "tb_school";

    public function getSchoolDetail(){
        $this->db->from($this->tableOrganization);
		$query = $this->db->get();
		return $query->row();
    }
}