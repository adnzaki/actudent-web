<?php

namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

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
			$requirePassword = (int)$this->request->getPost('requirePassword') === 1 ? true : false;

			$remember = 1;
			$isNik = $this->auth->isNik($username);
			$nomorIndukSiswa = $this->auth->isNomorIndukSiswa($username);

			if ($isNik !== false) {
				$username = $isNik;
			}

			if ($nomorIndukSiswa !== false) {
				$username = $nomorIndukSiswa['email'];
			}

			if ($this->auth->validasi($username, $password, $requirePassword)) {
				$pengguna = $this->auth->getDataPengguna($username);

				// Allow login if active sessions less than 10
				if($this->auth->getActiveSessions($pengguna->user_id) < 10) {
					$tokenExpiration = $remember === 1
						? ($this->tokenExp * 12) * 30 * 12 // extend expiration to 360 days
						: $this->tokenExp; // keep expiration in 2 hours

					$expirationTimestamp = strtotime('now') + $tokenExpiration;

					$student = null;
					if($pengguna->user_level === '3') {
						$student = $nomorIndukSiswa['student'];
					}

					// store login history and session data
					$loginId = $this->storeSession($pengguna->user_id, $expirationTimestamp);
					$token = [
						'id'        => $pengguna->user_id,
						'loginId'	=> $loginId,
						'email'     => $username,
						'nama'      => $pengguna->user_name,
						'studentId'	=> $student?->student_id,
						'userLevel' => $pengguna->user_level,
						'iat'       => strtotime('now'),
						'exp'       => $expirationTimestamp
					];

					$gradeId = null;


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
						'student'	=> $student,
						'lang'  	=> $this->getAppConfig($pengguna->user_id)->lang
					]);
				} else {
					return $this->response->setJSON([
						'msg' => 'maximum_session',
						'note' => get_lang('AdminAuth.session_exceeded'),
					]);
				}
			} else {
				return $this->response->setJSON([
					'msg'   => 'invalid',
					'user'  => $username,
				]);
			}
		}
	}

	private function generateToken()
	{

	}

	public function storeSession($userId, $tokenExpiration)
	{
		$ip = $this->request->getIPAddress();
		$locator = new IPLocator('ipgeolocation');
		$location = $locator->getLocation($ip);
		if ($location->status === 'OK') {
			$locationString = "{$location->cityName}, {$location->stateName}, {$location->countryName}|{$location->isp}";
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
		$isMainSession = ($this->auth->getActiveSessions($userId, true) > 0) ? 0 : 1;

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
