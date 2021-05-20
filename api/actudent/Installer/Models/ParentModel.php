<?php namespace Actudent\Installer\Models;

class ParentModel extends \Actudent\Installer\Models\SetupModel
{
    public function createParent()
    {
        $table = 'tb_parent';
        $fields = [
            'parent_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'parent_family_card' => [
                'type'          => 'VARCHAR',
                'constraint'    => 18,
            ],
            'parent_father_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true,
            ],
            'parent_mother_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true,
            ],
            'parent_phone_number' => [
                'type'          => 'VARCHAR',
                'constraint'    => 15,
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
        $this->forge->addPrimaryKey(['parent_id', 'user_id']);
        $this->forge->addForeignKey('user_id', 'tb_user', 'user_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}