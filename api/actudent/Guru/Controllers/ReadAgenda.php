<?php namespace Actudent\Guru\Controllers;

class ReadAgenda extends \Actudent\Admin\Controllers\Agenda
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminAgenda.agenda_title');
        return parse('Actudent\Admin\Views\agenda\agenda-view', $data);
    }
}