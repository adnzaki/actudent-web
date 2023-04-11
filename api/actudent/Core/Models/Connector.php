<?php namespace Actudent\Core\Models;

use CodeIgniter\Database\BaseResult;

/**
 * Main database connection class
 * Each model class should extend this class
 * in order to make all database-related task to run
 * 
 * @method BaseResult getNumRows()
 */
class Connector 
{
    /**
     * @var \CodeIgniter\Database\BaseConnection
     */
    public $db;

    /**
     * @var \CodeIgniter\Database\BaseConnection
     */
    protected $dbMain;

    /**
     * The school calendar period start
     * 
     * @var string
     */
    public $periodStart = '2022';

    /**
     * The school calendar period end
     * 
     * @var string
     */
    public $periodEnd = '2023';

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