<?php namespace Actudent\Installer\Models;

class SetupModel extends \Actudent\Core\Models\Connector
{
    /**
     * Database Forge class
     */
    protected $forge;

    /**
     * MySQL Engine
     */
    protected $engine;

    public function __construct()
    {
        parent:: __construct();
        $this->forge = \Config\Database::forge();
        $this->engine = ['ENGINE' => 'InnoDB'];
    }

    /**
     * Correct the `created` and `modified` column
     * -----------------------------------------------------
     * Since CodeIgniter's Forge class does not support
     * TIMESTAMP data type, CURRENT_TIMESTAMP as default value
     * and on update CURRENT_TIMESTAMP attribute,
     * we have to modify those columns manually
     * 
     * @param string $table
     * 
     * @return void
     */
    protected function correctCreatedAndModifiedColumn(string $table, string $type = 'TIMESTAMP'): void
    {
        // modify created and modified column
        // into correct data type and default value
        $createdSql =  "ALTER TABLE `{$table}` 
                        CHANGE `created` `created` {$type} NULL 
                        DEFAULT CURRENT_TIMESTAMP"; 
        
        $modifiedSql = "ALTER TABLE `{$table}` 
                        CHANGE `modified` `modified` {$type} 
                        on update CURRENT_TIMESTAMP NULL 
                        DEFAULT CURRENT_TIMESTAMP"; 

        $this->db->simpleQuery($createdSql);
        $this->db->simpleQuery($modifiedSql);
    }

    /**
     * Drop tables for development purpose
     * 
     * @param array $tables
     * 
     * @return void
     */
    public function dropTables(array $tables)
    {
        foreach($tables as $val)
        {
            $this->forge->dropTable($val, true);
        }
    }
}