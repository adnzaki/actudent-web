<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SekolahModel extends CI_Model
{
    /**
     * Tabel yang dibutuhkan untuk class AuthModel
     * 
     * @var array
     */
    private $table = [
        'sekolah' => 'tb_school'
    ];

    /**
     * Mengambil data sekolah berdasarkan ID Sekolah 
     * 
     * @param int|string $schoolID
     * @return object
     */
    public function getDataSekolah($schoolID)
    {
        return $this->db->get_where($this->table['sekolah'], ['schoolID' => $schoolID])->result();        
    }
}