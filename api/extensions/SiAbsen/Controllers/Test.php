<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use CodeIgniter\I18n\Time;

class Test extends Admin
{
    public function testGetSchedules()
    {        
        $user = $this->getDataPengguna();
        $event = new \SiAbsen\Controllers\Kegiatan;
        return $this->response->setJSON([
            'data' => $event->getEvents('08-2022')
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