<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SekolahModel extends CI_Model
{
    /**
     * Tabel yang dibutuhkan untuk class AuthModel
     * 
     * @var string
     */
    private $sekolah = 'tb_school';

    /**
     * Mengambil data sekolah berdasarkan ID Sekolah 
     * 
     * @param int|string $schoolID
     * @return object
     */
    public function getDataSekolah()
    {
        return $this->db->get($this->sekolah)->result();        
    }
}