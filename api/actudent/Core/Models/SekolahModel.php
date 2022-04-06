<?php namespace Actudent\Core\Models;

class SekolahModel extends \Actudent\Core\Models\Connector
{
    /**
     * Query Builder for table tb_sekolah
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
     * Get school data
     * 
     * @return array
     */
    public function getDataSekolah(): array
    {
        return $this->sekolah->get()->getResult();        
    }
}