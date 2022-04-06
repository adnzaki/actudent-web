<?php namespace Actudent\Installer\Models;

class SchoolModel extends \Actudent\Installer\Models\SetupModel
{
    public function createSchool()
    {
        $table = 'tb_school';
        $fields = [
            'school_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'school_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 300,
                'null'          => true
            ],
            'school_type' => [
                'type'          => 'ENUM',
                'constraint'    => ['Sekolah Dasar','Sekolah Menengah Pertama','Sekolah Manengah Atas'],
            ],
            'school_address' => [
                'type'          => 'VARCHAR',
                'constraint'    => 500,
                'null'          => true,
            ],
            'school_telephone' => [
                'type'          => 'VARCHAR',
                'constraint'    => 30,
                'null'          => true,
            ],
            'school_status' => [
                'type'          => 'TINYINT',
                'constraint'    => 1,
            ],
            'school_domain' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'          => true,
            ],
            'school_letterhead' => [
                'type'          => 'TEXT',
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
        $this->forge->addPrimaryKey('school_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}