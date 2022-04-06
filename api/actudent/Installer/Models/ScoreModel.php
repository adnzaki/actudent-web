<?php namespace Actudent\Installer\Models;

class ScoreModel extends \Actudent\Installer\Models\SetupModel
{
    public function createScore()
    {
        $table = 'tb_score';
        $fields = [
            'score_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'lessons_grade_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'score_type' => [
                'type'          => 'ENUM',
                'constraint'    => ['Teori', 'Praktik'],
            ],
            'score_category' => [
                'type'          => 'ENUM',
                'constraint'    => ['Tugas','UH','PTS','PAS','Kinerja','Proyek'],
            ],
            'score_description' => [
                'type'          => 'VARCHAR',
                'constraint'    => 250,
                'null'          => true,
            ],
            'deleted' => [
                'type'          => 'INT',
                'constraint'    => 11,
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
        $this->forge->addPrimaryKey('score_id');
        $this->forge->addForeignKey('lessons_grade_id', 'tb_lessons_grade', 'lessons_grade_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createScoreStudent()
    {
        $table = 'tb_score_student';
        $fields = [
            'score_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'student_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'score' => [
                'type'          => 'DECIMAL',
                'constraint'    => [10, 2],
            ],
            'score_note' => [
                'type'          => 'TEXT',
                'null'          => true
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
        $this->forge->addPrimaryKey(['score_id', 'student_id']);
        $this->forge->addForeignKey('student_id', 'tb_student', 'student_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}