<?php namespace Actudent\Installer\Models;

class HolidaysModel extends \Actudent\Installer\Models\SetupModel
{
    public function createHolidays()
    {
        $table = 'tb_holidays';
        $fields = [
            'holiday_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'holiday_title' => [
                'type'          => 'VARCHAR',
                'constraint'    => 300,
                'null'          => true,
            ],
			'start_date' => [
				'type'          => 'DATE',
				'null'          => true,
			],
			'end_date' => [
				'type'          => 'DATE',
				'null'          => true,
			],
            'deleted' => [
                'type'          => 'TINYINT',
                'constraint'    => 1,
                'default'       => 0,
            ],
            'created' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'modified' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('holiday_id');
        $this->forge->createTable($table, true, $this->engine);

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}
