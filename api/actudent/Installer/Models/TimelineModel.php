<?php namespace Actudent\Installer\Models;

class TimelineModel extends \Actudent\Installer\Models\SetupModel
{
    public function createTimeline()
    {
        $table = 'tb_timeline';
        $fields = [
            'timeline_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'timeline_title' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true
            ],
            'timeline_content' => [
                'type'          => 'TEXT',
                'null'          => true,
            ],
            'timeline_date' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'timeline_status' => [
                'type'          => 'ENUM',
                'constraint'    => ['public', 'draft'],
                'null'          => true,
            ],
            'timeline_image' => [
                'type'          => 'VARCHAR',
                'constraint'    => 500,
                'null'          => true
            ],
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
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
        $this->forge->addPrimaryKey('timeline_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}