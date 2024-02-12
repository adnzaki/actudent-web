<?php

namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Config\Services;
use Actudent\Admin\Models\SettingModel;

class Resources extends \Actudent
{
	/**
	 * Notify user if active period has been 7 days left
	 *
	 * @return JSON
	 */
	public function showExpirationNotification()
	{
		$subs = new \Actudent\Core\Models\SubscriptionModel;
		$package = $subs->getPackageDetail();
		$diff = os_date()->diff($package->shortDate, os_date()->shortDate(), 'num-only');

		return $this->createResponse([
			'left'  => $diff,
			'date'  => $package->expiration,
			'text'  => lang('AdminLangganan.subs_active_left', [$diff]),
		]);
	}

	/**
	 * Subscription check
	 *
	 * @return mixed
	 */
	public function checkSubscription()
	{
		$subscriber = new \Actudent\Core\Models\SubscriptionModel;
		if ($subscriber->hasExpired()) {
			$response = $this->setStatus(112);
		} else {
			$response = $this->setStatus(113);
		}

		return $this->response->setJSON($response);
	}
	/**
	 * Validate user token before they navigate to any routes
	 * in Actudent user inteface
	 *
	 * @param string $validator | is_admin, is_teacher, valid_token
	 *
	 * @return mixed
	 */
	public function validateToken($validator)
	{
		if ($validator() !== true) {
			$status = $this->setStatus(503);
		} else {
			if(valid_token()) {
				$decodedToken = jwt_decode(bearer_token());
				if($this->auth->hasActiveSession($decodedToken->loginId)) {
					$status = $this->setStatus(200);
					if ($validator === 'is_teacher') {
						$status['check'] = $this->checkHomeroomTeacher()['check'];
					}

					// let's become a passenger,
					// no need to create a new route to get the lang config :p
					$user = $this->getDataPengguna();
					$status['lang'] = $this->getAppConfig($user->user_id)->lang;
				} else {
					$status = $this->setStatus(504);
				}
			}
		}

		return $this->response->setJSON($status);
	}

	public function checkHomeroomTeacher()
	{
		if (is_teacher()) {
			$model          = new \Actudent\Guru\Models\JadwalKehadiranModel;
			$decodedToken   = jwt_decode(bearer_token());
			$check          = $model->isHomeroomTeacher($decodedToken->id);
			$result         = $check !== false ? 1 : 0;

			return [
				'check' => $result,
				'data'  => $check !== false ? $check : null
			];
		}
	}

	/**
	 * Get school data
	 *
	 * @return object
	 */
	public function getSekolah()
	{
		if (valid_token()) {
			$response = $this->sekolah->getDataSekolah()[0];
			return $this->createResponse($response);
		}
	}

	public function getReportData($token = '')
	{
		$schoolModel = new \Actudent\Core\Models\SekolahModel;
		$reportSetting = new SettingModel;
		$sekolah = $schoolModel->getDataSekolah()[0];
		$letterhead = $reportSetting->getLetterhead();
		$signs = $this->getSigns($token);

		return [
			'namaSekolah'           => $sekolah->school_name ?? '',
			'alamatSekolah'         => $sekolah->school_address ?? '',
			'lokasiSekolah'         => $signs->city ?? '',
			'telpSekolah'           => $sekolah->school_telephone ?? '',
			'domainSekolah'         => $sekolah->school_domain ?? '',
			'kepalaSekolah'         => $signs->headmaster ?? '',
			'wakaKurikulum'         => $signs->co_headmaster ?? '',
			'nipKepsek'             => $signs->headmaster_nip ?? '',
			'nipWakasek'            => $signs->co_headmaster_nip ?? '',
			'kopSurat'              => $letterhead,
		];
	}

	/**
	 * Get school letterhead
	 *
	 * @return object
	 */
	public function getSigns($token = '')
	{
		if (valid_token($token)) {
			$schoolModel = new \Actudent\Core\Models\SekolahModel;
			$sekolah = $schoolModel->getDataSekolah()[0];
			return json_decode($sekolah->school_letterhead);
		}
	}

	/**
	 * Get user data based on token they have
	 *
	 * @return JSON
	 */
	public function getPengguna()
	{
		$response = $this->getDataPengguna();
		return $this->createResponse($response);
	}

	/**
	 * Get locale for login page only that does not require authentication
	 *
	 * @param string $file | file to be loaded
	 * @param string $lang
	 *
	 * @return JSON
	 */
	public function getLocale($file, $lang)
	{
		$response = require APPPATH . "Language/{$lang}/{$file}.php";

		return Services::response()->setJSON($response);
	}
}
