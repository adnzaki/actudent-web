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
