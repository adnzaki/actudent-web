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
        // Initialize wolesdev_helper
        helper('Actudent\Core\Helpers\wolesdev');

        // Connect to database
        $this->db = \Config\Database::connect(get_subdomain());
        $this->dbMain = \Config\Database::connect('actudentMain');
    }
}