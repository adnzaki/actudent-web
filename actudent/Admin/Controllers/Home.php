<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AbsensiModel;

class Home extends Actudent
{
    /**
     * @var Actudent\Admin\Models\AbsensiModel
     */
    private $absensi;

    public function __construct()
    {
        $this->absensi = new AbsensiModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminHome.dashboard_title');
        $todayPresence = $this->getTodayPresence();
        $data['presence'] = $todayPresence['presence'];
        $data['absence'] = $todayPresence['absence'];
        $data['permit'] = $todayPresence['permit'];
        $data['presentPercent'] = $todayPresence['presentPercent'];
        $data['absentPercent'] = $todayPresence['absentPercent'];
        $data['notePercent'] = $todayPresence['notePercent'];
        
        return parse('Actudent\Admin\Views\dashboard\home', $data);
    }

    protected function getTodayPresence()
    {
        $percentage = $this->absensi->getPresencePercetage();
        return [
            'presence' => $this->absensi->getTodayPresence('1'),
            'absence' => $this->absensi->getTodayPresence('0'),
            'permit' => $this->absensi->getTodayAbsenceWithPermission(),
            'presentPercent' => round($percentage['present'], 1),
            'absentPercent' => round($percentage['absent'], 1),
            'notePercent' => round($percentage['withPermission'], 1),
        ];
    }

    public function getLastSevenDaysPresence()
    {
        $lastSevenDays = [];

        // subtract only 6 days because today will be counted
        $startDate = os_date()->sub('now', 6);
        for($i = 0; $i < 7; $i++)
        {
            if($i === 0)
            {
                $lastSevenDays[] = $startDate;
            }
            else
            {
                $lastSevenDays[] = os_date()->add($startDate, 1);
            }

            $startDate = $lastSevenDays[$i];
        }

        // store presence data in percent (%)
        $weekPresence = [];
        $weekAbsence = [];
        $weekPermission = [];

        foreach($lastSevenDays as $key)
        {
            $present = $this->absensi->getTodayPresence('1', reverse($key, '-', '-'));
            $absent = $this->absensi->getTodayPresence('0', reverse($key, '-', '-'));
            $permit = $this->absensi->getTodayAbsenceWithPermission(reverse($key, '-', '-'));
            $weekPresence[] = $this->percentage($present);
            $weekAbsence[] = $this->percentage($absent);
            $weekPermission[] = $this->percentage($permit);
        }

        return $this->response->setJSON([
            'present' => $weekPresence,
            'absent' => $weekAbsence,
            'permit' => $weekPermission
        ]);
    }

    private function percentage($input, $depth = 1)
    {
        $countStudents = $this->absensi->QBStudent->where('deleted', 0)->countAllResults();
        $result = 0;
        if($countStudents > 0)
        {
            $result = round(($input / $countStudents) * 100, $depth);
        }
        
        return $result;
    }

    public function goToHome()
    {
        return redirect()->to(base_url('admin/home'));
    }

    public function showQuery()
    {
        echo $this->auth->showPenggunaQuery('admin@wolestech.com');
    }
}