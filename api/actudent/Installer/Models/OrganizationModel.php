<?php namespace Actudent\Installer\Models;

use Actudent\Core\Models\SubscriptionModel;
use Actudent\Core\Models\SekolahModel;
use Actudent\Admin\Models\SharedModel;
use OstiumDate;

class OrganizationModel extends \Actudent\Installer\Models\SetupModel
{
    private $subs;

    private $QBInstall;

    public function __construct()
    {
        parent:: __construct();
        $this->subs = new SubscriptionModel;
        $this->QBInstall = $this->dbMain->table('tb_installation');
    }

    /**
     * Check if installation exists.
     *
     * @return boolean
     */
    public function hasInstallation()
    {
        $check = $this->QBInstall->getWhere(['db_group_key' => get_subdomain()]);

        return $check->getNumRows() > 0 ? true : false;
    }

	/**
	 * Adds an installation by inserting a new record into the tb_installation table with the provided 'db_group_key'.
	 *
	 * @return void
	 */
	public function addInstallation(): void
	{
		$this->QBInstall->insert(['db_group_key' => (string) get_subdomain()]);
	}

	/**
	 * Adds the given database name to the 'tb_organization_database' table.
	 *
	 * @param string $dbName The name of the database to be added.
	 *
	 * @return void
	 */
	public function addDatabaseName($dbName): void
	{
		$this->dbMain->table('tb_organization_database')->insert([
			'database_name' => $dbName,
			'status'        => 1
		]);
	}

    /**
     * Adds a new admin user with default values.
	 *
	 * @return void
     */
    public function addAdmin(): void
    {
        $values = [
            'user_name'     => 'Administrator',
            'user_email'    => 'admin@'.get_subdomain(),
            'user_password' => password_hash(env('default_admin_password'), PASSWORD_DEFAULT),
            'user_level'    => 1
        ];

        $model = new SharedModel;
        $model->QBUser->insert($values);
    }

    /**
     * Insert school data
     *
     * @param array $data
     *
     * @return void
     */
    public function insertSchool(array $data): void
    {
        $letterhead = file_get_contents(ACTUDENT_PATH . 'Installer/Models/school.json');
        $values = [
            'school_name'       => $data['organization_name'],
            'school_type'       => 'Sekolah Dasar',
            'school_address'    => 'Jl. XXXXXXXXXX',
            'school_telephone'  => '000-0000000000',
            'school_status'     => 1,
            'school_domain'     => $data['organization_origination'],
            'school_letterhead' => $letterhead
        ];

        $school = new SekolahModel;
        $school->sekolah->insert($values);
    }

    /**
     * Adds a subscription for a specific organization.
     *
     * @param string $subsType The type of subscription
     * @param int $orgId The organization ID
     *
     * @return void
     */
    public function addSubscription(string $subsType, int $orgId): void
    {
        $os = new OstiumDate;
        $expiredDate = $os->add('now', 365);

        $values = [
            'organization_id'           => $orgId,
            'subscription_type'         => strtolower($subsType),
            'subscription_expiration'   => reverse($expiredDate, '-', '-') . ' 23:59:59'
        ];

        $this->subs->QBSubscription->insert($values);
    }

    /**
     * Insert organization data into the database.
     *
     * @param array $data The data for the organization to be inserted
     *
     * @return int The ID of the inserted organization
     */
    public function insertOrganization(array $data): int
    {
        $values = [
            'organization_name'         => $data['organization_name'],
            'organization_origination'  => $data['organization_origination'],
            'organization_destination'  => '',
            'db_version'                => DB_VERSION
        ];

        $this->subs->QBOrganization->insert($values);

        return $this->dbMain->insertID();
    }

}
