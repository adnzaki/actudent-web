<?php namespace Actudent\Guru\Controllers;

class GuruNilai extends \Actudent\Admin\Controllers\Nilai 
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