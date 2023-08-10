<?php namespace Actudent\Installer\Models;

use Actudent\Core\Models\SubscriptionModel;
use Actudent\Core\Models\SekolahModel;
use Actudent\Admin\Models\SharedModel;
use OstiumDate;

class OrganizationModel extends \Actudent\Installer\Models\SetupModel
{
    private $subs;

    public function __construct()
    {
        parent:: __construct();
        $this->subs = new SubscriptionModel;
    }

    public function addDatabaseName($dbName)
    {
        $builder = $this->dbMain->table('tb_organization_database');
        $builder->insert([
            'database_name' => $dbName,
            'status'        => 1
        ]);
    }

    public function addAdmin($domain)
    {
        $values = [
            'user_name'     => 'Administrator',
            'user_email'    => 'admin@'.$domain,
            'user_password' => password_hash(env('default_admin_password'), PASSWORD_BCRYPT),
            'user_level'    => 1
        ];

        $model = new SharedModel;
        $model->QBUser->insert($values);
    }

    public function insertSchool(array $data)
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

    public function addSubscription(string $subsType, int $orgId)
    {
        $os = new OstiumDate;
        $add = $os->add('now', 365);
        $expiredDate = $os->format('d-m-y', $add, '-');

        $values = [
            'organization_id'           => $orgId,
            'subscription_type'         => strtolower($subsType),
            'subscription_expiration'   => reverse($expiredDate, '-', '-') . ' 23:59:59'
        ];

        $this->subs->QBSubscription->insert($values);
    }

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