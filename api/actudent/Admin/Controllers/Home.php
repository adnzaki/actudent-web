<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\AbsensiModel;
use Actudent\Admin\Models\KelasModel;
use Actudent\Parent\Controllers\Dashboard;

class Home extends \Actudent
{
    private $absensi;

    private $kelas;

    public function __construct()
    {
        $this->absensi = new AbsensiModel;
        $this->kelas = new KelasModel;
    }

	public function getStudentWithLowestAndHighestPresence()
	{
		if(is_admin()) {
			$highest = $this->getMonthlyStudentPercentage();
			usort($highest, function ($a, $b) {
				return $b['percentage'] <=> $a['percentage'];
			});

			$lowest = $this->getMonthlyStudentPercentage();
			usort($lowest, function ($a, $b) {
				return $a['percentage'] <=> $b['percentage'];
			});

			return $this->response->setJSON([
				'highest' => array_slice($highest, 0, 5),
				'lowest'  => array_slice($lowest, 0, 5)
			]);

		}
	}

	private function getMonthlyStudentPercentage()
	{
		$classgroup = $this->kelas->getKelas();
		$result = [];

		foreach($classgroup as $key) {
			$classMember = $this->kelas->getClassMember($key->grade_id);
			foreach($classMember as $member) {
				$studentDashboard = new Dashboard;
				$monthlyPercentage = $studentDashboard->getMonthlyPercentage($member->student_id, $key->grade_id);

				$result[] = [
					'student_id' 	=> $member->student_id,
					'student_name' 	=> $member->student_name,
					'percentage' 	=> $monthlyPercentage,
					'grade_id' 		=> $key->grade_id,
					'grade_name' 	=> $key->grade_name
				];
			}
		}

		return $result;
	}

    public function getTodayPresence()
    {
        $grade = $this->absensi->getRombel();
        $present = 0;
        $absent = 0;
        $sick = 0;
        $permit = 0;

        foreach($grade as $key) {
            $present += $this->absensi->getTodayPresence($key->grade_id, '1');
            $absent += $this->absensi->getTodayPresence($key->grade_id, '0');
            $sick += $this->absensi->getTodayAbsenceWithPermission($key->grade_id, 3);
            $permit += $this->absensi->getTodayAbsenceWithPermission($key->grade_id, 2);
        }

        return $this->createResponse([
            'present'   => $present,
            'absent'    => $absent,
            'sick'      => $sick,
            'permit'    => $permit,
        ], 'is_admin');
    }

    public function getTodayPresencePercentage()
    {
        return $this->createResponse([
            'highest'   => $this->getHighestPresent()[0],
            'lowest'    => $this->getLowestPresent()[0],
			'userAgent' => $this->testUserLoginData()
        ], 'is_admin');
    }

	public function testUserLoginData()
	{
		$agent = $this->request->getUserAgent();
		$device = $agent->isMobile() ? $agent->getMobile() : 'Desktop';
		$browser = $agent->isBrowser() ? $agent->getBrowser() : '';
		$ip = $this->request->getIPAddress();
		$locator = new \IPLocator;
		$location = $locator->getLocation($ip);
		if($location->status === 'OK') {
			$locationString = "{$location->cityName}, {$location->stateName}, {$location->countryName}";
		} else {
			$locationString = $location->msg;
		}


		return [
			'agentString' 	=> "$device ({$agent->getPlatform()}) / $browser {$agent->getVersion()}",
			'ip'			=> $ip,
			'location'		=> $locationString,
			'agent'			=> $agent->getAgentString()
		];
	}

    private function getHighestPresent()
    {
        $presence = $this->_getTodayPresenceByGrade();
        $presentColumn = array_column($presence, 'present');
        array_multisort($presentColumn, SORT_DESC, $presence);

        return array_chunk($presence, 5);
    }

    private function getLowestPresent()
    {
        $presence = $this->_getTodayPresenceByGrade();
        $presentColumn = array_column($presence, 'present');
        array_multisort($presentColumn, SORT_ASC, $presence);

        return array_chunk($presence, 5);
    }

    private function _getTodayPresenceByGrade()
    {
        $grade = $this->absensi->getRombel();
        $response = [];
        foreach($grade as $key) {
            $present = $this->absensi->getTodayPresence($key->grade_id, '1');
            $absent = $this->absensi->getTodayPresence($key->grade_id, '0');
            $sick = $this->absensi->getTodayAbsenceWithPermission($key->grade_id, 3);
            $permit = $this->absensi->getTodayAbsenceWithPermission($key->grade_id, 2);
            $response[] = [
                'grade_name'    => $key->grade_name,
                'present'       => $this->percentage($present, $key->grade_id),
                'absent'        => $this->percentage($absent, $key->grade_id),
                'sick'          => $this->percentage($sick, $key->grade_id),
                'permit'        => $this->percentage($permit, $key->grade_id)
            ];
        }

        return $response;
    }

    public function getLastSevenDaysPresence()
    {
        $lastSevenDays = [];

        // subtract only 6 days because today will be counted
        $startDate = os_date()->sub('now', 6);
        for($i = 0; $i < 7; $i++) {
            if($i === 0) {
                $lastSevenDays[] = $startDate;
            } else {
                $lastSevenDays[] = os_date()->add($startDate, 1);
            }

            $startDate = $lastSevenDays[$i];
        }

        // store presence data in percent (%)
        $weekPresence = [];
        $weekAbsence = [];
        $weekSick = [];
        $weekPermission = [];
        $days = [];

        foreach($lastSevenDays as $key) {
            $grade = $this->absensi->getRombel();
            $present = 0;
            $absent = 0;
            $sick = 0;
            $permit = 0;

            foreach($grade as $g) {
                $date = reverse($key, '-', '-');
                $present += $this->absensi->getTodayPresence($g->grade_id, '1', $date);
                $absent += $this->absensi->getTodayPresence($g->grade_id, '0', $date);
                $sick += $this->absensi->getTodayAbsenceWithPermission($g->grade_id, 3, $date);
                $permit += $this->absensi->getTodayAbsenceWithPermission($g->grade_id, 2, $date);
            }
            $weekPresence[] = $present;
            $weekAbsence[] = $absent;
            $weekSick[] = $sick;
            $weekPermission[] = $permit;
            $days[] = $key;
        }

        return $this->response->setJSON([
            'date'      => $days,
            'present'   => $weekPresence,
            'absent'    => $weekAbsence,
            'sick'      => $weekSick,
            'permit'    => $weekPermission
        ]);
    }

    private function percentage($input, $gradeId, $depth = 1)
    {
        $countStudents = $this->kelas->getClassMemberRows($gradeId);
        $result = 0;
        if($countStudents > 0)
        {
            $result = round(($input / $countStudents) * 100, $depth);
        }

        return $result;
    }
}
