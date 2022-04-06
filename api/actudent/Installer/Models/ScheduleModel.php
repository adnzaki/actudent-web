<?php namespace Actudent\Installer\Models;

class ScheduleModel extends \Actudent\Installer\Models\SetupModel
{
    public function createSchedule()
    {
        $table = 'tb_schedule';
        $fields = [
            'schedule_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'lessons_grade_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'room_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'schedule_semester' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'schedule_day' => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
                'null'          => true
            ],
            'duration' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'null'          => true
            ],
            'schedule_start' => [
                'type'          => 'VARCHAR',
                'constraint'    => 10,
                'null'          => true
            ],
            'schedule_end' => [
                'type'          => 'VARCHAR',
                'constraint'    => 10,
                'null'          => true
            ],
            'schedule_order' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'null'          => true
            ],
            'schedule_status' => [
                'type'          => 'ENUM',
                'constraint'    => ['active', 'inactive'],
                'default'       => 'active',
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('schedule_id');
        $this->forge->addForeignKey('lessons_grade_id', 'tb_lessons_grade', 'lessons_grade_id');
        $this->forge->addForeignKey('room_id', 'tb_room', 'room_id');
        $this->forge->createTable($table, true, $this->engine);  
    }

    public function createScheduleSettings()
    {
        $table = 'tb_schedule_settings';
        $fields = [
            'schedule_setting_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
            ],
            'setting_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'null'          => true
            ],
            'setting_value' => [
                'type'          => 'VARCHAR',
                'constraint'    => 50,
                'null'          => true
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('schedule_setting_id');
        $this->forge->createTable($table, true, $this->engine);  
    }

    public function insertScheduleSettings()
    {
        $builder = $this->db->table('tb_schedule_settings');
        $data = [
            [
                'setting_name'  => 'lesson_hour',
                'setting_value' => 45
            ],
            [
                'setting_name'  => 'start_time',
                'setting_value' => 7
            ],
        ];
        $builder->insertBatch($data);
    }
}