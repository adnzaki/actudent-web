<?php namespace Actudent\Installer\Models;

class LoginHistoryModel extends \Actudent\Installer\Models\SetupModel
{
	public function createLoginHistory()
	{
		$table = 'tb_login_history';
		$fields = [
			'login_id' => [
				'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
			],
			'user_id' => [
				'type'          => 'INT',
                'constraint'    => 11,
			],
			'ip_address' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 20,
				'null'          => true,
			],
			'user_agent' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100,
				'null'          => true,
			],
			'location' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 150,
				'null'          => true,
			],
			'login_time' => [
				'type'          => 'DATETIME',
                'null'          => true,
			],
		];

		$this->forge->addField($fields);
        $this->forge->addPrimaryKey('login_id');
		$this->forge->addForeignKey('user_id', 'tb_user', 'user_id');
        $this->forge->createTable($table, true, $this->engine);

		$this->setAsCurrentTimestamp('login_time', $table);
	}

	public function createDeviceSessions()
	{
		$table = 'tb_device_sessions';
		$fields = [
			'session_id' => [
				'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
			],
			'login_id' => [
				'type'          => 'INT',
                'constraint'    => 11,
			],
			'user_device' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 100,
				'null'          => true,
			],
			'is_main_device' => [ // 1 or 0
				'type'			=> 'TINYINT',
				'constraint'	=> 1,
			],
			'user_token' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 200,
				'null'          => true,
			],
			'is_active' => [ // 1 or 0
				'type'			=> 'TINYINT',
				'constraint'	=> 1,
			],
			'created' => [
				'type'          => 'DATETIME',
                'null'          => true,
			],
		];

		$this->forge->addField($fields);
        $this->forge->addPrimaryKey('session_id');
		$this->forge->addForeignKey('login_id', 'tb_login_history', 'login_id');
        $this->forge->createTable($table, true, $this->engine);

		$this->setAsCurrentTimestamp('created', $table);
	}
}
