<?php namespace Actudent\Admin\Models;

class SettingModel extends \Actudent\Core\Models\Connector
{
    private $QBReportSetting;

    private $reportSetting = 'tb_report_settings';

    public function __construct()
    {
        parent::__construct();
        $this->QBReportSetting = $this->db->table($this->reportSetting);
    }

    public function updateLetterhead($value)
    {
        $this->QBReportSetting->update(
            ['setting_value' => $value], 
            ['setting_name' => 'letterhead']
        );
    }
}