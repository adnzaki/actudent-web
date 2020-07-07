<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Home extends Actudent
{
    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Actudent CI4 Home';
        $data['changelog'] = 
        "- [Agenda] Fixed save button disabled after saving agenda
        - [Schedules] Fixed error text on teacher required field
        - [Core] Changed default page to teacher section
        - [Staff] Added default user themes and language
        - [Presence] Added daily journal report";
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\dashboard\home');
    }

    public function goToHome()
    {
        return redirect()->to(base_url('admin/home'));
    }

    public function showQuery()
    {
        echo $this->auth->showPenggunaQuery('admin@wolestech.com');
    }
}