<?php namespace Actudent\Core\Models;

use Actudent\Core\Models\SubscriptionModel;

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

    public function __construct()
    {
        helper('Actudent\Core\Helpers\wolesdev');
        $this->forge = \Config\Database::forge(get_subdomain());
        $this->subs = new SubscriptionModel;
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