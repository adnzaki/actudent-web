<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Test extends Admin
{
    public function testGetSchedules($id)
    {
        $schedules = $this->model->getTeacherSchedules($id);
        $days = [
            'senin' => 1, 'selasa' => 2, 'rabu' => 3, 
            'kamis' => 4, 'jumat' => 5, 'sabtu' => 6
        ];

        foreach($schedules as $s) {
            $dayValues[] = $days[$s->schedule_day]; // example: $days['senin']
        }

        return $this->response->setJSON($this->getPresenceStatus($id, 'teacher', '2022-06-30')[1]);
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