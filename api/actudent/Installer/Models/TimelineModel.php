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
            'featured_image' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'          => true
            ],
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'deleted' => [
                'type'          => 'TINYINT',
                'constraint'    => 1,
                'default'       => 0
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
        $this->forge->addForeignKey('user_id', 'tb_user', 'user_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createTimelineImages()
    {
        $table = 'tb_timeline_images';
        $fields = [
            'id'            => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'timeline_id'   => ['type' => 'INT'],
            'filename'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created'       => ['type' => 'DATETIME', 'null' => true],
            'modified'      => ['type' => 'DATETIME', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('timeline_id', 'tb_timeline', 'timeline_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}