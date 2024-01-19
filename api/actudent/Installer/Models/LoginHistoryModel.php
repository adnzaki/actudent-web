<?php namespace Actudent\Installer\Models;

class LoginHistoryModel extends \Actudent\Installer\Models\SetupModel
{
	public function createLogins()
	{
		$table = 'tb_logins';
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
			'platform' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 50,
				'null'          => true,
			],
			'browser' => [
				'type'			=> 'VARCHAR',
				'constraint'	=> 50,
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

	public function createSessions()
	{
		$table = 'tb_sessions';
		$fields = [
			'user_id' => [
				'type'          => 'INT',
                'constraint'    => 11,
                'auto_increment'=> true
			],
			'login_id' => [
				'type'          => 'INT',
                'constraint'    => 11,
			],
			'is_main_session' => [ // 1 or 0
				'type'			=> 'TINYINT',
				'constraint'	=> 1,
			],
			'is_active' => [ // 1 or 0
				'type'			=> 'TINYINT',
				'constraint'	=> 1,
				'default'		=> 1
			],
			'token_expiration' => [
				'type'			=> 'INT',
				'constraint'	=> 15,
			],
			'created' => [
				'type'          => 'DATETIME',
                'null'          => true,
			],
		];

		$this->forge->addField($fields);
		$this->forge->addForeignKey('user_id', 'tb_user', 'user_id');
		$this->forge->addForeignKey('login_id', 'tb_logins', 'login_id');
        $this->forge->createTable($table, true, $this->engine);

		$this->setAsCurrentTimestamp('created', $table);
	}
}
