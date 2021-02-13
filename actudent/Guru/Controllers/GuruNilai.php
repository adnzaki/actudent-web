<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Nilai;

class GuruNilai extends Nilai 
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminNilai.page_title');

        return parse('Actudent\Admin\Views\nilai\nilai-view', $data);
    }

    public function getTeacherLessons()
    {
        return $this->response->setJSON($this->nilaiGuru->getTeacherLessons());
    }
}