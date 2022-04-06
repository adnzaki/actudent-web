<?php namespace Actudent\Installer\Models;

class StudentModel extends \Actudent\Installer\Models\SetupModel
{
    public function createStudent()
    {
        $table = 'tb_student';
        $fields = [
            'student_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'student_nis' => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'          => true
            ],
            'student_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true
            ],
            'student_tag' => [
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
        $this->forge->addPrimaryKey('student_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createStudentGrade()
    {
        $table = 'tb_student_grade';
        $fields = [
            'student_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'grade_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'student_tag' => [
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
        $this->forge->addPrimaryKey(['student_id', 'grade_id']);
        $this->forge->addForeignKey('student_id', 'tb_student', 'student_id');
        $this->forge->addForeignKey('grade_id', 'tb_grade', 'grade_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createStudentParent()
    {
        $table = 'tb_student_parent';
        $fields = [
            'parent_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'student_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
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
        $this->forge->addForeignKey('parent_id', 'tb_parent', 'parent_id');
        $this->forge->addForeignKey('student_id', 'tb_student', 'student_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}