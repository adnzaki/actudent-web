<?php namespace Actudent\Installer\Models;

class MessageModel extends \Actudent\Installer\Models\SetupModel
{
    public function createMessage()
    {
        $table = 'tb_chat';
        $fields = [
            'chat_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'chat_user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'sender' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'content' => [
                'type'          => 'TEXT',
                'null'          => true,
            ],
            'read_status' => [
                'type'          => 'INT',
                'constraint'    => 11,
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
        $this->forge->addPrimaryKey('chat_id');
        $this->forge->addForeignKey('chat_user_id', 'tb_chat_users', 'chat_user_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);

        // remove modified column
        $this->forge->dropColumn($table, 'modified');
    }

    public function createMessageParticipant()
    {
        $table = 'tb_chat_users';
        $fields = [
            'chat_user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'participant_1' => [
                'type'          => 'VARCHAR',
                'constraint'    => 5,
                'null'          => true
            ],
            'participant_2' => [
                'type'          => 'VARCHAR',
                'constraint'    => 5,
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
        $this->forge->addPrimaryKey('chat_user_id');
        $this->forge->createTable($table, true, $this->engine);  

        // finish it up
        $this->correctCreatedAndModifiedColumn($table);

        // remove modified column
        $this->forge->dropColumn($table, 'modified');
    }
}