<?php namespace Actudent\Admin\Models;

class SekolahModel extends \Actudent\Core\Models\ModelHandler
{
    /**
     * Query Builder untuk tabel tb_sekolah
     * 
     * @var object
     */
    private $sekolah;

    public function __construct()
    {
        parent:: __construct();
        $this->sekolah = $this->db->table('tb_school');
    }

    /**
     * Mengambil data sekolah 
     * 
     * @return object
     */
    public function getDataSekolah()
    {
        return $this->sekolah->get()->getResult();        
    }
}