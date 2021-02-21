<?php namespace Actudent\Core\Models;

class Connector 
{
    /**
     * @var DatabaseConnection
     */
    public $db;

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