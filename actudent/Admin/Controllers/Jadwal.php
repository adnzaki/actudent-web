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
        $response = [];
        if($data !== false)
        {
            // decode JSON string into PHP object
            $response = $data[0];
            $response->lessons = json_decode($response->lessons);
    
            // prepare the formatter to get teacher name
            // of each lesson
            $lessonFormatter = [];
    
            foreach($response->lessons as $res)
            {
                $teacher = $this->jadwal->getTeacherName($res->teacher_id)->staff_name;
                $lessonFormatter[] = [
                    'name' => $res->name,
                    'teacher_id' => $res->teacher_id,
                    'teacher_name' => $teacher
                ];
            }
    
            // replace original lessons data with the formatted one
            $response->lessons = $lessonFormatter;
        }

        return $this->response->setJSON($response);
    }
}