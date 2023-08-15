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

    public function setSignSetting(string $value, string $reportType)
    {
        $this->QBReportSetting->update(
            ['setting_value' => $value], 
            ['setting_name' => $reportType]
        );
    }

    public function getSignSetting(string $reportType)
    {
        $query = $this->QBReportSetting->getWhere(['setting_name' => $reportType]);

        return $query->getResult()[0]->setting_value;
    }

    public function getLetterhead()
    {
        $query = $this->QBReportSetting->getWhere(['setting_name' => 'letterhead']);

        return $query->getResult()[0]->setting_value;
    }

    public function updateLetterhead($value)
    {
        $this->QBReportSetting->update(
            ['setting_value' => $value], 
            ['setting_name' => 'letterhead']
        );
    }
}