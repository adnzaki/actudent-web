<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\JadwalModel;

class Jadwal extends Actudent
{
    private $jadwal;

    public function __construct()
    {
        $this->jadwal = new JadwalModel;
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('AdminJadwal.jadwal_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\jadwal\jadwal-view');
    }

    public function getLessons($grade)
    {
        $data = $this->jadwal->getLessons($grade);
        $lessons = [];
        if($data !== false)
        {
            $lessons = $data;
        }

        $className = $this->jadwal->rombel->getClassDetail($grade);
        $response = [
            'className' => $className->grade_name,
            'lessons' => $lessons,
        ];

        return $this->response->setJSON($response);
    }
}