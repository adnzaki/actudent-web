<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use CodeIgniter\I18n\Time;

class Test extends Admin
{
    public function testGetSchedules()
    {
        timer('monthly-recap');
        $t1 = strtotime('2022-07-28 07:14:25');
        $t2 = strtotime('2022-07-29 07:14:25');
        $data = $t1 > $t2;
        timer('monthly-recap');
        $elapsed = timer()->getElapsedTime('monthly-recap');

        return $this->response->setJSON([
            'elapsed'   => number_format($elapsed, 5),
            // 'rows'      => $this->model->baseStaffScheduleRows(null, 'staff_name'),
            'res'       => $data,
        ]);
    }

    public function testAws($keyname)
    {
        $aws = new \AwsClient;

        echo $aws->getObjectUrl($keyname);
    }

    public function testCountLate($date, $time, $showSeconds = true)
    {
        $timein = '07:00:00';
        $dateTimeIn = $date .' '. $time;
        $timeConfig = $date . ' ' . $timein;
        $diff = strtotime($dateTimeIn) - strtotime($timeConfig);
        $output = '';

        function getSeconds($minutes, $showSeconds) {
            if($showSeconds) {
                $result = ($minutes - floor($minutes)) * 60;
                return ' '.$result.' '.lang('SiAbsen.siabsen_detik');
            }
        }

        $minsText = lang('SiAbsen.siabsen_menit');

        if($diff <= 60) {
            $output = $diff . ' ' . lang('SiAbsen.siabsen_detik');
        } elseif($diff > 60 && $diff < 3600) {
            $minutes = $diff / 60;
            $output = floor($minutes).' '. 
                      $minsText . getSeconds($minutes, $showSeconds);
        } else {
            $hours = $diff / 60 / 60;
            $minutes = ($hours - floor($hours)) * 60;
            $output = floor($hours) . ' ' .
                      lang('SiAbsen.siabsen_jam') .' '. floor($minutes) . ' ' .
                      $minsText . getSeconds($minutes, $showSeconds);
        }

        echo $output;
    }

    public function testStatus($tag)
    {
        if(valid_token()) {
            $pengguna = $this->getDataPengguna();
            $date = date('Y-m-d');
            $presence = $this->model->getPresence($pengguna->user_id, $date, $tag);
    
            return $this->response->setJSON($presence);
        }
    }
}