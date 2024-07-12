<?php namespace Actudent\Parent\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Controllers\Absensi;
use Actudent\Admin\Controllers\Jadwal;
use Actudent\Admin\Models\AbsensiModel;
use Actudent\Parent\Models\BaseModel;

class Dashboard extends \Actudent
{
	private $absensi;

	private $model;

	public function __construct()
	{
		$this->absensi = new AbsensiModel;
		$this->model = new BaseModel;
	}

	public function getHomeworkInfo()
	{
		if(is_parent()) {
			$decodedToken = jwt_decode(bearer_token());
			$studentId = $decodedToken->studentId;
			$gradeId = $this->model->getStudentGrade($studentId);
			$data = $this->model->getHomeworks($gradeId);
			foreach($data as $d) {
				$getDate = explode(' ', $d->due_date);
				$d->due_date = os_date()->create($getDate[0]);
				$d->due_date_short = os_date()->create($getDate[0], 'd-m-y', '-');
			}

			return $this->response->setJSON($data);

		}
	}

	public function getTodaySchedule()
	{
		if(is_parent()) {
			$today = getdate();
			$days = [
				'minggu',
				'senin', 'selasa', 'rabu',
				'kamis', 'jumat', 'sabtu'
			];

			$selectedDay = $days[$today['wday']];
			$decodedToken = jwt_decode(bearer_token());
			$studentId = $decodedToken->studentId;
			$gradeId = $this->model->getStudentGrade($studentId);

			$jadwalController = new Jadwal;
			$getSchedule = $jadwalController->_getSchedules($gradeId);
			$todaySchedule = $getSchedule['schedule'][$selectedDay];

			return $this->response->setJSON($todaySchedule);
		}
	}

	public function getPresenceInfo()
	{
		if(is_parent()) {
			$today = date('Y-m-d');
			// $date = '2024-07-11';
			$decodedToken = jwt_decode(bearer_token());
			$studentId = $decodedToken->studentId;
			$gradeId = $this->model->getStudentGrade($studentId);
			$journal = $this->absensi->getJournalByDate($today, $gradeId);

			// set default status and message
			// $status = 4; >>> holiday/no schedule
			$status = 4;

			$presenceCategory = [
				'Status: ' . get_lang('AdminAbsensi.absensi_alfa'),
				'Status: ' . get_lang('AdminAbsensi.absensi_hadir'),
				'Status: ' . get_lang('AdminAbsensi.absensi_izin'),
				'Status: ' . get_lang('AdminAbsensi.absensi_sakit'),
				get_lang('Parent.home_no_lesson'),
				get_lang('Parent.home_no_presence'),
			];


			// get today presence info
			if(count($journal) > 0) {
				$todayPresence = [];
				foreach ($journal as $key) {
					$getPresence = $this->absensi->getPresence($key->journal_id, $studentId, $today);
					$todayPresence[] = $getPresence !== null ? $getPresence->presence_status : '-';
				}

				// Do search only if a student has presence data
				if (array_search('-', $todayPresence) === false) {

					// Search if a student has absent today or not
					$hasAbsent = array_search(0, $todayPresence);

					// If there is an absent, then presenceData should be 0 (absent)
					if ($hasAbsent !== false) {
						$status = 0;
					} else {
						if (array_search(3, $todayPresence) !== false) {
							$status = 3;
						} else {
							if ($todayPresence[0] === 1 && end($todayPresence) === 1) {
								$status = 1;
							} else {
								$status = end($todayPresence);
							}
						}
						// If presence_status is 1 (present) in the first and last lesson hour...
					}
				} else {
					$status = 5; // today has journal but has no presence data
				}
			}

			// get this month's presence percentage
			$absensiController = new Absensi();
			$monthlyPresence = $absensiController->countPresence($studentId, $gradeId, (int)date('m'), date('Y'));

			$monthlyPresent = $absensiController->getPresenceStatusNumber($monthlyPresence, '1');

			$monthDateStart = date('Y-m-01');
			$monthDateEnd = date('Y-m-t');

			$thisMonthJournals = $this->absensi->getTotalJournals($gradeId, $monthDateStart, $monthDateEnd);
			$monthlyPercentage = get_percentage($monthlyPresent, $thisMonthJournals, true);

			// get this semester's presence percentage
			$semester = $this->absensi->semester;
			$periodStart = $semester === 1 ? 7 : 1;
			$periodEnd = $semester === 1 ? 12 : 6;
			$year = $semester === 1 ? $this->absensi->periodStart : $this->absensi->periodEnd;
			$countStart = $year . '-' . $periodStart . '-01';
			$countEnd = $year . '-' . $periodEnd . '-' . os_date()->daysInMonth($periodEnd, $year);

			$periodCountResult = [];
			$thisPeriodJournals = $this->absensi->getTotalJournals($gradeId, $countStart, $countEnd);
			for($i = $periodStart; $i <= $periodEnd; $i++) {
				$periodCountResult[] = $absensiController->countPresence($studentId, $gradeId, $i, $year);
			}

			$periodCountResult = array_merge(
				$periodCountResult[0],
				$periodCountResult[1],
				$periodCountResult[2],
				$periodCountResult[3],
				$periodCountResult[4],
				$periodCountResult[5],
			);

			$periodPercentage = get_percentage($absensiController->getPresenceStatusNumber($periodCountResult, '1'), $thisPeriodJournals, true);


			return $this->response->setJSON([
				'status' => $status,
				'message' => $presenceCategory[$status],
				'thisMonthJournal' => $thisMonthJournals,
				'presence' => [
					'monthlyPercentage' => $monthlyPercentage,
					'periodPercentage' => $periodPercentage,
					'period' => $countStart .' ---- '. $countEnd,
				],
			]);
		}
	}
}
