<?php namespace Actudent\Installer\Models;

class RoomModel extends \Actudent\Installer\Models\SetupModel
{
    public function createRoom()
    {
        $table = 'tb_room';
        $fields = [
            'room_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'room_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 300,
                'null'          => true,
            ],
            'room_code' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
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
        $this->forge->addPrimaryKey('room_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}