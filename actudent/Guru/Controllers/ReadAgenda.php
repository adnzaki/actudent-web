<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Agenda;

class ReadAgenda extends Agenda
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminAgenda.agenda_title');
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\agenda\agenda-view');
    }
}