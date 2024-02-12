<?php namespace Actudent\Installer\Models;

class SetupModel extends \Actudent\Core\Models\Connector
{
    /**
     * Database Forge class
     */
    public $forge;

    /**
     * MySQL Engine
     */
    public $engine;

    public function __construct()
    {
        parent:: __construct();
        helper('Actudent\Core\Helpers\wolesdev');
        $this->forge = \Config\Database::forge(get_subdomain());
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
    public function correctCreatedAndModifiedColumn(string $table, string $type = 'TIMESTAMP'): void
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

	public function setAsCurrentTimestamp(string $field, string $table): void
	{
		$query = 	"ALTER TABLE `{$table}`
					CHANGE `{$field}` `{$field}` TIMESTAMP NULL
					DEFAULT CURRENT_TIMESTAMP";
		$this->db->simpleQuery($query);
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
        foreach($tables as $val) {
            $this->forge->dropTable($val, true);
        }
    }
}
