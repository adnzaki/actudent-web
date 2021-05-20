<?php namespace Actudent\Installer\Models;

class TimelogModel extends \Actudent\Installer\Models\SetupModel
{
    public function createTimelog()
    {
        $table = 'tb_timelog';
        $fields = [
            'log_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'student_nis' => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'          => true
            ],
            'verifymode' => [
                'type'          => 'TINYINT',
                'constraint'    => 4,
                'null'          => true
            ],
            'timestamp' => [
                'type'          => 'DATETIME',
                'null'          => true,
                'null'          => true
            ],
            'iomode' => [
                'type'          => 'TINYINT',
                'constraint'    => 4,
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
        $this->forge->addPrimaryKey('log_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $sql = "ALTER TABLE `{$table}` 
                CHANGE `timestamp` `timestamp` TIMESTAMP NULL"; 
        $this->db->simpleQuery($sql);
        $this->correctCreatedAndModifiedColumn($table);

        // remove modified column
        $this->forge->dropColumn($table, 'modified');
    }
}