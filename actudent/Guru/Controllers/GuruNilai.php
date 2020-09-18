<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Nilai;

class GuruNilai extends Nilai 
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminNilai.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\nilai\nilai-view');
    }

    public function getTeacherLessons()
    {
        return $this->response->setJSON($this->nilaiGuru->getTeacherLessons());
    }
}