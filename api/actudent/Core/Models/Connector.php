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

    /**
     * The school calendar period start
     * 
     * @var string
     */
    public $periodStart = '2021';

    /**
     * The school calendar period end
     * 
     * @var string
     */
    public $periodEnd = '2022';

    /**
     * Semester in period
     * 
     * @var int
     */
    public $semester = 1;

    public function __construct()
    {
        // Initialize wolesdev_helper
        helper('Actudent\Core\Helpers\wolesdev');

        // Connect to database
        $this->db = \Config\Database::connect(get_subdomain());
        $this->dbMain = \Config\Database::connect('actudentMain');
    }
}