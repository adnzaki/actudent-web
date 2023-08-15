<?php namespace Actudent\Installer\Models;

class SettingModel extends \Actudent\Installer\Models\SetupModel
{
    public function createReportSetting()
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
        $this->forge->createTable($table, true, $this->engine);
        $this->correctCreatedAndModifiedColumn($table);

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
                'setting_value' => 'kepsek,walas'
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
}