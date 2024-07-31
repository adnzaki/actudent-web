<?php namespace Actudent\Core\Models;

use Actudent\Core\Models\SubscriptionModel;
use Actudent\Installer\Models\TimelineModel;
use Actudent\Installer\Models\SettingModel;
use Actudent\Installer\Models\LoginHistoryModel;

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
        parent::__construct();
        helper('Actudent\Core\Helpers\wolesdev');
        $this->forge = \Config\Database::forge(get_subdomain());
        $this->subs = new SubscriptionModel;
    }

    public function getDbVersion()
    {
        $organization = $this->subs->getOrganization();

        return $organization->db_version;
    }

    public function getDbVersionNumber()
    {
        return (int)str_replace('.', '', $this->getDbVersion());
    }

    public function updateDbVersion()
    {
        $organization = $this->subs->getOrganization();
        $this->subs->QBOrganization->update(
            ['db_version' => DB_VERSION],
            ['organization_id' => $organization->organization_id]
        );
    }

	public function addPtkDapodikId()
	{
		if($this->getDbVersionNumber() < 231) {
			$this->addHolidays();
		}

		$this->forge->addColumn('tb_staff', [
			'ptk_dapodik_id' => [
				'type'          => 'VARCHAR',
				'constraint'    => 50,
				'null'          => true,
				'after'			=> 'staff_tag',
			],
		]);
	}

	public function addHolidays()
	{
		if($this->getDbVersionNumber() < 230) {
            $this->addCustomStartTime();
        }

		$model = new \Actudent\Installer\Models\HolidaysModel;
		$model->createHolidays();
	}

	public function addCustomStartTime()
    {
        if($this->getDbVersionNumber() < 229) {
            $this->addLoginHistory();
        }

		// add second start time
		$jadwal = new \Actudent\Admin\Models\JadwalModel;
		$jadwal->QBSettingJadwal->insert([
			'setting_name' 	=> 'start_time_2',
			'setting_value'	=> 12.5
		]);

		// add custom start time
		$setup = new \Actudent\Installer\Models\ScheduleModel;
		$setup->createCustomStartTime();
    }

	public function addLoginHistory()
    {
        if($this->getDbVersionNumber() < 228) {
            $this->addTimeline();
        }

		$history = new LoginHistoryModel;
		$history->createLogins();
		$history->createSessions();
    }

    public function addTimeline()
    {
        if($this->getDbVersionNumber() < 227) {
            $this->addReportSettingsTable();
        }

        $timeline = new TimelineModel;
        $timeline->createTimeline();
        $timeline->createTimelineImages();
    }

    public function addReportSettingsTable()
    {
        $model = new SettingModel;
        $model->createReportSetting();
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
