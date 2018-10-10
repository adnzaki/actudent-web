<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SekolahModel extends CI_Model
{
    private $table = [
        'sekolah' => 'tb_school'
    ];

    public function getDataSekolah($schoolID)
    {
        return $this->db->get_where($this->table['sekolah'], ['schoolID' => $schoolID])->result();        
    }
}