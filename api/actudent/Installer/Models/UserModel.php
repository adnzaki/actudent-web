<?php namespace Actudent\Installer\Models;

class UserModel extends \Actudent\Installer\Models\SetupModel
{
    public function createUser()
    {
        $table = 'tb_user';
        $fields = [
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'user_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
            ],
            'user_email' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true,
            ],
            'user_password' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true,
            ],
            'user_level' => [
                'type'          => 'TINYINT',
                'constraint'    => 4,
            ],
            'deleted' => [
                'type'          => 'TINYINT',
                'constraint'    => 1,
                'default'       => '0',
            ],
            'network' => [
                'type'          => 'VARCHAR',
                'constraint'    => 10,
                'default'       => 'offline'
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
        $this->forge->addPrimaryKey('user_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createUserDevices()
    {
        $table = 'tb_user_devices';
        $fields = [
            'device_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'user_id'           => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'device_type' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true,
            ],
            'device_version' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true,
            ],
            'fcm_registration_id' => [
                'type'          => 'VARCHAR',
                'constraint'    => 500,
                'null'          => true,
            ],
            'status' => [
                'type'          => 'TINYINT',
                'constraint'    => 4,
                'null'          => true,
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
        $this->forge->addPrimaryKey('device_id');
        $this->forge->addForeignKey('user_id', 'tb_user', 'user_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}