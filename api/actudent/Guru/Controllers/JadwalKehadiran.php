<?php namespace Actudent\Guru\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Controllers\Jadwal;

class JadwalKehadiran extends \Actudent\Admin\Controllers\Absensi
{
    public function isHomeroomTeacher()
    {
        if(is_teacher()) {
            $decodedToken = jwt_decode(bearer_token());

            $check = $this->jadwalHadir->isHomeroomTeacher($decodedToken->id);
            $result = $check ? 1 : 0;

            return $this->response->setJSON(['check' => $result]);
        }
    }
    
    public function getTeacherSchedules($day)
    {
        if(is_teacher()) {
            $decodedToken = jwt_decode(bearer_token());
    
            $schedules = $this->jadwalHadir->getTeacherSchedules($this->days[$day], $decodedToken->id);
    
            // create Jadwal object
            $jadwal = new Jadwal();
    
            // add new key => schedule_decimal
            foreach($schedules as $key)
            {
                $key->schedule_decimal = $jadwal->numberValue($key->schedule_start);
            }
    
            // sort data by schedule_start that has been converted to schedule_decimal
            $time = array_column($schedules, 'schedule_decimal');
            array_multisort($time, SORT_ASC, $schedules);
    
            return $this->response->setJSON($schedules);
        }
    }
}