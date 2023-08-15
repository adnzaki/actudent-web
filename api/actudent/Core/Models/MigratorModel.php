<?php namespace Actudent\Core\Models;

use Actudent\Core\Models\SubscriptionModel;
use Actudent\Installer\Models\SetupModel;

/**
 * Migrator class used to update database structure
 * automatically by the application. It consists of 
 * set of methods that can be chosen for updating database.
 * 
 * Method selection should be done manually from controller
 * if there is a new version of database.
 */
class MigratorModel extends \Actudent\Core\Models\Connector
{
    private $forge;

    private $subs;

    private $setup;

    public function __construct()
    {
        parent::__construct();
        helper('Actudent\Core\Helpers\wolesdev');
        $this->forge = \Config\Database::forge(get_subdomain());
        $this->subs = new SubscriptionModel;
        $this->setup = new SetupModel;
    }

    public function getDbVersion()
    {
        $organization = $this->subs->getOrganization();

        return $organization->db_version;
    }

    public function updateDbVersion()
    {
        $organization = $this->subs->getOrganization();
        $this->subs->QBOrganization->update(
            ['db_version' => DB_VERSION], 
            ['organization_id' => $organization->organization_id]
        );
    }

    public function addReportSettingsTable()
    {
        $fields = [
            'id'            => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'setting_name'  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'setting_value' => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'created'       => ['type' => 'DATETIME', 'null' => true],
            'modified'      => ['type' => 'DATETIME', 'null' => true],
        ];

        $table = 'tb_report_settings';

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable($table, true, $this->setup->engine);
        $this->setup->correctCreatedAndModifiedColumn($table);

        // insert some values...
        $builder = $this->db->table($table);
        $values = [
            [
                'setting_name'  => 'letterhead',
                'setting_value' => null
            ],
            [
                'setting_name'  => 'daily_journal_sign',
                'setting_value' => 'walas'
            ],
            [
                'setting_name'  => 'daily_presence_sign',
                'setting_value' => 'walas'
            ],
            [
                'setting_name'  => 'monthly_presence_sign',
                'setting_value' => 'kepsek,waka,walas'
            ],
            [
                'setting_name'  => 'monthly_summary_sign',
                'setting_value' => 'kepsek,waka,walas'
            ],
            [
                'setting_name'  => 'semester_summary_sign',
                'setting_value' => 'kepsek,waka,walas'
            ],
        ];

        $builder->insertBatch($values);
    }

    /**
     * This method is just for example, do not run it.
     */
    public function addImportedFieldForClassGroup()
    {
        $fields = [
            'imported'  => [
                'type'          => 'tinyint',
                'constraint'    => 1,
                'after'         => 'rombel_dapodik_id',
                'default'       => 0
            ]
        ];

        $this->forge->addColumn('tb_grade', $fields);
    }
}