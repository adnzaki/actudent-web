<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Absensi;

class SchedulePresence extends Absensi
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('GuruAbsensi.page_title');
        $data['isHomeroom'] = $this->jadwalHadir->isHomeroomTeacher($_SESSION['id']);

        return $this->parser->setData($data)
                ->render('Actudent\Guru\Views\JadwalKehadiran\main-view');
    }

    public function getTeacherSchedules($day)
    {
        $days = [
            'minggu', 'senin', 'selasa',
            'rabu', 'kamis', 'jumat', 'sabtu'
        ];

        $schedules = $this->jadwalHadir->getTeacherSchedules($days[$day]);
        return $this->response->setJSON($schedules);
    }
}