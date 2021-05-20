<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Absensi;
use Actudent\Admin\Controllers\Jadwal;

class SchedulePresence extends Absensi
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('GuruAbsensi.page_title');
        $data['isHomeroom'] = $this->jadwalHadir->isHomeroomTeacher($_SESSION['id']);

        return parse('Actudent\Guru\Views\JadwalKehadiran\main-view', $data);
    }

    public function getTeacherSchedules($day)
    {
        $days = [
            'minggu', 'senin', 'selasa',
            'rabu', 'kamis', 'jumat', 'sabtu'
        ];

        $schedules = $this->jadwalHadir->getTeacherSchedules($days[$day]);

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