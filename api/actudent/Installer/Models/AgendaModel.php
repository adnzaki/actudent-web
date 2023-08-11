<?php namespace Actudent\Installer\Models;

class AgendaModel extends \Actudent\Installer\Models\SetupModel
{
    public function createAgenda()
    {
        $table = 'tb_agenda';
        $fields = [
            'agenda_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'agenda_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 250,
                'null'          => true
            ],
            'agenda_start' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'agenda_end' => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'agenda_description' => [
                'type'          => 'TEXT',
                'null'          => true,
            ],
            'agenda_priority' => [
                'type'          => 'ENUM',
                'constraint'    => ['high', 'normal', 'low'],
                'null'          => true,
            ],
            'agenda_location' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => true,
            ],
            'agenda_attachment' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => true,
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
        $this->forge->addPrimaryKey('agenda_id');
        $this->forge->addForeignKey('user_id', 'tb_user', 'user_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createAgendaUser()
    {
        $table = 'tb_agenda_user';
        $fields = [
            'agenda_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'present' => [
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
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}