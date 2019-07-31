<?php namespace Actudent\Core\Models;

class ModelHandler 
{
    /**
     * @var DatabaseConnection
     */
    protected $db;

    public function __construct()
    {
        // Connect to database
        $this->db = \Config\Database::connect();
    }
}