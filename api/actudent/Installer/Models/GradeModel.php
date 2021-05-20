<?php namespace Actudent\Installer\Models;

class GradeModel extends \Actudent\Installer\Models\SetupModel
{
    public function createGrade()
    {
        $table = 'tb_grade';
        $fields = [
            'grade_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'grade_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => true
            ],
            'period_start' => [
                'type'          => 'VARCHAR',
                'constraint'    => 4,
                'null'          => true
            ],
            'period_end' => [
                'type'          => 'VARCHAR',
                'constraint'    => 4,
                'null'          => true
            ],
            'teacher_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'grade_status' => [
                'type'          => 'TINYINT',
                'constraint'    => 1,
                'default'       => 1,
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
        $this->forge->addPrimaryKey('grade_id');
        $this->forge->addForeignKey('teacher_id', 'tb_staff', 'staff_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}