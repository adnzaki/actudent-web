<?php

namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');

use IPLocator;

class Auth extends \Actudent
{
	private $tokenExp = 2 * 60 * 60; // expired every 2 hours

	public function logout()
	{
		if (valid_token()) {
			$decodedToken = jwt_decode(bearer_token());
			$this->auth->logout($decodedToken->loginId);

			return $this->response->setJSON([
				'status'	=> 'OK',
				'msg'		=> 'Successfully logged out from Actudent'
			]);
		}
	}

	public function isValidLogin()
	{
		$subscriber = new \Actudent\Core\Models\SubscriptionModel;
		if ($subscriber->hasExpired()) {
			return $this->response->setJSON([
				'msg' => 'expired',
				'note' => get_lang('Error.app_expired'),
			]);
		} else {
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');
			$remember = $this->request->getPost('remember');
			$isNik = $this->auth->isNik($username);

			if ($isNik !== false) {
				$username = $isNik;
			}

			if ($this->auth->validasi($username, $password)) {
				$pengguna = $this->auth->getDataPengguna($username);
				$tokenExpiration = $remember === '1'
					? ($this->tokenExp * 12) * 30 * 12 // extend expiration to 360 days
					: $this->tokenExp; // keep expiration in 2 hours

				$expirationTimestamp = strtotime('now') + $tokenExpiration;

				// store login history and session data
				$loginId = $this->storeSession($pengguna->user_id, $expirationTimestamp);
				$token = [
					'id'        => $pengguna->user_id,
					'loginId'	=> $loginId,
					'email'     => $username,
					'nama'      => $pengguna->user_name,
					'userLevel' => $pengguna->user_level,
					'iat'       => strtotime('now'),
					'exp'       => $expirationTimestamp
				];

				$gradeId = null;

				if ($pengguna->user_level === '3') {
					return $this->response->setJSON(['msg' => 'unauthorized']);
				} else {
					if ($pengguna->user_level === '2') {
						$model = new \Actudent\Guru\Models\JadwalKehadiranModel;
						$check = $model->isHomeroomTeacher($pengguna->user_id);
						if ($check !== false) {
							$gradeId = (int)$check->grade_id;
						}
					}

					$encodedToken = jwt_encode($token);

					$this->auth->statusJaringan('online', $username);
					return $this->response->setJSON([
						'msg'   	=> 'valid',
						'token' 	=> $encodedToken,
						'level' 	=> $pengguna->user_level,
						'grade' 	=> $gradeId,
						'lang'  	=> $this->getAppConfig($pengguna->user_id)->lang
					]);
				}
			} else {
				return $this->response->setJSON([
					'msg'   => 'invalid',
					'user'  => $username
				]);
			}
		}
	}

	public function storeSession($userId, $tokenExpiration)
	{
		$ip = $this->request->getIPAddress();
		$locator = new IPLocator;
		$location = $locator->getLocation($ip);
		if ($location->status === 'OK') {
			$locationString = "{$location->cityName}, {$location->stateName}, {$location->countryName}";
		} else {
			$locationString = $location->msg;
		}

		$agent = $this->request->getUserAgent();
		$device = $agent->isMobile() ? $agent->getMobile() : 'Desktop';
		$getBrowser = $agent->isBrowser() ? $agent->getBrowser() : '';

		$userPlatform = "$device ({$agent->getPlatform()})";
		$userBrowser = "$getBrowser {$agent->getVersion()}";

		$loginValues = [
			'user_id'		=> $userId,
			'ip_address'	=> $ip,
			'platform'		=> $userPlatform,
			'browser'		=> $userBrowser,
			'location'		=> $locationString
		];

		// ------------------------
		// insert $loginValues to tb_logins
		// ------------------------
		$loginId = $this->auth->insertLoginHistory($loginValues); // get from inserted tb_logins.login_id

		// Check if there has been active session for current logged in user or not.
		// If not, this will be the main session and can manage other sessions.
		$isMainSession = !$this->auth->checkActiveSession($userId) ? 1 : 0;

		$sessionValues = [
			'user_id'			=> $userId,
			'login_id'			=> $loginId,
			'is_main_session'	=> $isMainSession,
			'token_expiration'	=> $tokenExpiration
		];
		$this->auth->insertSession($sessionValues);

		// return $loginId to be used by JWT
		return $loginId;
	}
}
