<?php namespace Actudent\Installer\Models;

class PresenceModel extends \Actudent\Installer\Models\SetupModel
{
    public function createJournal()
    {
        $table = 'tb_journal';
        $fields = [
            'journal_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'schedule_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'description' => [
                'type'          => 'TEXT',
                'null'          => true,
            ],
            'is_archive' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'default'       => 0,
            ],
            'journal_date' => [
                'type'          => 'DATE',
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
        $this->forge->addPrimaryKey('journal_id');
        $this->forge->addForeignKey('schedule_id', 'tb_schedule', 'schedule_id');
        $this->forge->createTable($table, true, $this->engine);  

        $modifyJournalDate =  "ALTER TABLE `{$table}` 
                              CHANGE `journal_date` `journal_date` DATE NULL 
                              DEFAULT CURRENT_TIMESTAMP";

        // correct journal_date default value
        $this->db->simpleQuery($modifyJournalDate);

        // finish it up
        $this->correctCreatedAndModifiedColumn($table, 'DATETIME');
    }

    public function createHomework()
    {
        $table = 'tb_homework';
        $fields = [
            'journal_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'homework_title' => [
                'type'          => 'VARCHAR',
                'constraint'    => 300,
                'null'          => true,
            ],
            'homework_description' => [
                'type'          => 'VARCHAR',
                'constraint'    => 500,
                'null'          => true,
            ],
            'due_date' => [
                'type'          => 'DATETIME',
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
        $this->forge->addForeignKey('journal_id', 'tb_journal', 'journal_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $sql = "ALTER TABLE `{$table}` 
                CHANGE `due_date` `due_date` TIMESTAMP NULL"; 
        $this->db->simpleQuery($sql);
        $this->correctCreatedAndModifiedColumn($table);
    }

    public function createPresence()
    {
        $table = 'tb_presence';
        $fields = [
            'journal_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'student_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'presence_status' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'presence_mark' => [
                'type'          => 'VARCHAR',
                'constraint'    => 300,
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
        $this->forge->addPrimaryKey(['journal_id', 'student_id']);
        $this->forge->addForeignKey('student_id', 'tb_student', 'student_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);
    }
}