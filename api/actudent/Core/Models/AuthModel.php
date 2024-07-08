<?php namespace Actudent\Core\Models;

class AuthModel extends \Actudent\Core\Models\Connector
{
    /**
     * tb_user table builder
     *
     */
    private $user;

	/**
	 * tb_sessions
	 */
	private $session;

	/**
	 * tb_logins
	 */
	private $logins;

    public function __construct()
    {
        parent::__construct();

        // Initialize Query Builder for each tables
        $this->user = $this->db->table('tb_user');
		$this->session = $this->db->table('tb_sessions');
		$this->logins = $this->db->table('tb_logins');
    }

	/**
	 * Deactivate session. It is also used by revoking access feature
	 *
	 * @param int $loginId
	 *
	 * @return void
	 */
	public function logout(int $loginId): void
	{
		$this->session->update([
			'is_main_session' => 0,
			'is_active' => 0,
			'token_expiration' => 0
		], ['login_id' => $loginId]);
	}

	/**
	 * Insert data into tb_sessions
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	public function insertSession(array $data): void
	{
		$values = [
			'user_id'			=> $data['user_id'],
			'login_id'			=> $data['login_id'],
			'is_main_session'	=> $data['is_main_session'],
			'token_expiration'	=> $data['token_expiration']
		];

		$this->session->insert($values);
	}

	/**
	 * Insert data into tb_logins
	 *
	 * @param array $data
	 *
	 * @return int
	 */
	public function insertLoginHistory(array $data): int
	{
		$values = [
			'user_id'		=> $data['user_id'],
			'ip_address'	=> $data['ip_address'],
			'platform'		=> $data['platform'],
			'browser'		=> $data['browser'],
			'location'		=> $data['location']
		];

		$this->logins->insert($values);

		return $this->db->insertID();
	}

	/**
	 * Check if a user has active session or not
	 *
	 * @param int $loginId
	 *
	 * @return boolean
	 */
	public function hasActiveSession(int $loginId): bool
	{
		$search = $this->session->getWhere([
			'login_id'	=> $loginId,
			'is_active'	=> 1
		]);

		return $search->getNumRows() > 0 ? true : false;
	}

	/**
	 * Get number of active sessions
	 *
	 * @param int $userId
	 * @param bool $checkMainSession
	 *
	 * @return int
	 */
	public function getActiveSessions(int $userId, bool $checkMainSession = false): int
	{
		$search = $this->session->where([
			'user_id' 				=> $userId,
			'is_active'				=> 1,
			'token_expiration >'	=> strtotime('now'),
		]);

		if($checkMainSession) {
			$search->where('is_main_session', 1);
		}

		return $search->get()->getNumRows();
	}

	public function isNomorIndukSiswa(string $username)
	{
		$siswa = new \Actudent\Admin\Models\SiswaModel;
		$query = $siswa->QBStudent->getWhere(['student_nis' => $username]);
		if($query->getNumRows() > 0) {
			$studentId = $query->getResult()[0]->student_id;
			$parentId = $siswa->getStudentDetail($studentId)[0]->parent_id;

			$parent = new \Actudent\Admin\Models\OrtuModel;
			$parentDetail = $parent->getParentDetail($parentId);

			return $parentDetail[0]->user_email;
		} else {
			return false;
		}
	}

    /**
     * Check whether the username is staff_nik or user_email
     * If it is staff_nik, then return their user_email,
     * if not, then return false
     *
     * @param string $username
     *
     * @return mixed
     */
    public function isNik(string $username)
    {
        $pegawai = new \Actudent\Admin\Models\PegawaiModel;
        $query = $pegawai->QBStaff->getWhere(['staff_nik' => $username]);

        if($query->getNumRows() > 0) {
            $staffData = $query->getResult()[0];
            $userId = $staffData->user_id;

            return $userId;
        } else {
            return false;
        }
    }

    /**
     * Get user data who has been logged in
     *
     * @param string $username
     *
     * @return object
     */
    public function getDataPengguna(string $username): object
    {
        $field = 'user_id, user_name, user_email, user_level';
        $query = $this->user->select($field)
            ->where('user_email', $username)
            ->orWhere('user_id', (int)$username)
            ->get()->getResult();
        return $query[0];
    }

    /**
     * Set network status to "online" or "offline"
     *
     * @param string $status
     * @param string $username
     *
     * @return void
     */
    public function statusJaringan(string $status, string $username): void
    {
        $this->user->update([
            'network' => $status
        ], ['user_email' => $username]);
    }

    /**
     * Validate username and possword
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function validasi(string $username, string $password): bool
    {
        $find = $this->user
                     ->where(['user_email' => $username])
                     ->orWhere(['user_id' => (int)$username]);
        $userAktif = $find->get()->getResult();
        if($find->countAllResults() > 0 && $this->isActiveUser($username))
        {
            if(password_verify($password, $userAktif[0]->user_password))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Check if user is active or not
     *
     * @param string $username
     *
     * @return boolean
     */
    public function isActiveUser(string $username): bool
    {
        $query = $this->user
                      ->where('user_email', $username)
                      ->orWhere(['user_id' => (int)$username])
                      ->get()->getResult();
        if(count($query) > 0)
        {
            if($query[0]->deleted === '0')
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
