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
        $this->setDefaultGroup();
        $this->dbMain = \Config\Database::connect('actudentMain');
    }

    /**
     * Set default database connection group.
     * This will connect your app with client database.
     * 
     * @return string
     */
    public function setDefaultGroup()
    {
        $groupName = '';
        if(get_host() !== 'localhost')
        {
            $hostArray = explode('.', get_host());
            $groupName = $hostArray[0];
        }
        else 
        {
            $groupName = get_host();
        }

        $this->db = \Config\Database::connect($groupName);
    }
}