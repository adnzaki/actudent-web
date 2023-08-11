<?php namespace Actudent\Installer\Models;

class StaffModel extends \Actudent\Installer\Models\SetupModel
{
    public function createStaff()
    {
        $table = 'tb_staff';
        $fields = [
            'staff_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'staff_nik' => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'          => true
            ],
            'staff_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true
            ],
            'staff_phone' => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'          => true
            ],
            'staff_type' => [
                'type'          => 'ENUM',
                'constraint'    => ['teacher', 'staff'],
                'null'          => true
            ],
            'staff_title' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true
            ],
            'staff_photo' => [
                'type'          => 'TEXT',
                'null'          => true
            ],
            'staff_tag' => [
                'type'          => 'TINYINT',
                'constraint'    => 1,
                'null'          => true
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
        $this->forge->addPrimaryKey('staff_id');
        $this->forge->addForeignKey('user_id', 'tb_user', 'user_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}