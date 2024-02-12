<?php namespace Actudent\Admin\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Models\SessionModel;
use Actudent\Core\Models\AuthModel;

class Sessions extends \Actudent
{
    private $model;

	public function __construct()
	{
		$this->model = new SessionModel;
	}

	public function revokeAccess()
	{
		if(valid_token()) {
			$loginId = $this->request->getPost('id');
			$auth = new AuthModel;
			$auth->logout($loginId);

			return $this->response->setJSON([
				'status'	=> 'OK',
			]);
		}
	}

	public function getActiveSessions()
	{
		if(valid_token()) {
			$decodedToken = jwt_decode(bearer_token());
			if($this->model->isMainSession($decodedToken->loginId))	{
				$activeSessions = $this->model->getActiveSessions($decodedToken->id);
				return $this->response->setJSON([
					'msg'		=> 'OK',
					'result'	=> $activeSessions
				]);
			} else {
				return $this->response->setJSON(['msg' => 'failed']);
			}
		}
	}

	public function getLogins($limit, $offset, $orderBy, $searchBy, $sort)
	{
		if(valid_token()) {
			$decodedToken = jwt_decode(bearer_token());
			$data = $this->model->getLogins($decodedToken->id, $limit, $offset);
			$rows = $this->model->getLoginRows($decodedToken->id);

			foreach($data as $d) {
				$dt = explode(' ', $d->login_time);
				$d->date = os_date()->create($dt[0], 'd-m-y', '-');
				$d->time = $dt[1];
			}

			return $this->response->setJSON([
				'container' => $data,
				'totalRows' => $rows,
			]);
		}
	}
}
