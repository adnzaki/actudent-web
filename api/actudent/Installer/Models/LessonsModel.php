<?php namespace Actudent\Installer\Models;

class LessonsModel extends \Actudent\Installer\Models\SetupModel
{
    public function createLessons()
    {
        $table = 'tb_lessons';
        $fields = [
            'lesson_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true 
            ],
            'lesson_code' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => true,
            ],
            'lesson_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
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
        $this->forge->addPrimaryKey('lesson_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createLessonsGrade()
    {
        $table = 'tb_lessons_grade';
        $fields = [
            'lessons_grade_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true 
            ],
            'lesson_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'grade_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'teacher_id' => [
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
        $this->forge->addPrimaryKey('lessons_grade_id');
        $this->forge->addForeignKey('lesson_id', 'tb_lessons', 'lesson_id');
        $this->forge->addForeignKey('grade_id', 'tb_grade', 'grade_id');
        $this->forge->addForeignKey('teacher_id', 'tb_staff', 'staff_id');
        $this->forge->createTable($table, true, $this->engine);  
        
        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}