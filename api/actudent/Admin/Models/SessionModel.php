<?php namespace Actudent\Admin\Models;

class SessionModel extends \Actudent\Admin\Models\SharedModel
{
	/**
	 * Query builders
	 */
	private $QBLogins;
	private $QBSessions;

	/**
     * tb_logins table
     *
     * @var string
     */
    private $logins = 'tb_logins';

	/**
     * tb_sessions table
     *
     * @var string
     */
    private $sessions = 'tb_sessions';

	/**
     * The constructor
     * Set query builders
     *
     * @return void
     */
    public function __construct()
    {
        parent:: __construct();
        $this->QBLogins = $this->db->table($this->logins);
        $this->QBSessions = $this->db->table($this->sessions);
    }

    /**
     * Get list of active sessions
	 *
	 * @param int $userId
     *
     * @return array
     */
    public function getActiveSessions(int $userId): array
    {
		// Perform join between QBSessions and QBLogins tables
		$results = $this->QBSessions
		    ->select("{$this->logins}.login_id, is_main_session, platform, browser") // Select the columns you need
		    ->join($this->logins, "{$this->logins}.login_id = {$this->sessions}.login_id")
		    ->where("{$this->sessions}.user_id", $userId)
		    ->where("{$this->sessions}.is_active", 1)
		    ->where("{$this->sessions}.token_expiration >", strtotime('now'))
			->orderBy('is_main_session', 'DESC')
		    ->get()
		    ->getResult();

		return $results;
    }

	/**
	 * Check if the provided login ID is the main session
	 *
	 * @param int $loginId The ID of the login session to check
	 *
	 * @return bool True if it is the main session, false otherwise
	 */
	public function isMainSession(int $loginId): bool
	{
	    $mainSession = $this->QBSessions
	        ->where(['is_main_session' => 1, 'login_id' => $loginId])
	        ->get()
	        ->getFirstRow();

	    return $mainSession !== null;
	}

	/**
     * Get login history
     *
	 * @param int $userId
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
	public function getLogins($userId, $limit, $offset): array
	{
		$query = $this->QBLogins->orderBy('login_time', 'DESC')->limit($limit, $offset);

		return $query->getWhere(['user_id' => $userId])->getResult();
	}

	/**
     * Get login history
     *
	 * @param int $userId
     *
     * @return int
     */
	public function getLoginRows($userId): int
	{
		return $this->QBLogins->where(['user_id' => $userId])->countAllResults();
	}
}
