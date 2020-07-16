<?php namespace Actudent\Core\Models;

class ModelHandler 
{
    /**
     * @var DatabaseConnection
     */
    protected $db;

    /**
     * @var DatabaseConnection
     */
    protected $dbMain;

    public function __construct()
    {
        // Connect to database
        $this->db = \Config\Database::connect();
        $this->dbMain = \Config\Database::connect('actudentMain');
    }
}