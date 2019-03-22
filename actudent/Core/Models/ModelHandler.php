<?php namespace Actudent\Core\Models;

class ModelHandler 
{
    /**
     * @var object
     */
    protected $input;

    /**
     * @var DatabaseConnection
     */
    protected $db;

    public function __construct()
    {
        // Untuk kompatibilitas dengan CodeIgniter 3
        $this->input = \Config\Services::request();

        // Hubungkan database
        $this->db = \Config\Database::connect();
    }
}