<?php namespace Actudent\Guru\Controllers;

class TeacherHome extends \Actudent\Admin\Controllers\Home
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminHome.dashboard_title');;
        $todayPresence = $this->getTodayPresence();
        $data['presence'] = $todayPresence['presence'];
        $data['absence'] = $todayPresence['absence'];
        $data['permit'] = $todayPresence['permit'];
        $data['presentPercent'] = $todayPresence['presentPercent'];
        $data['absentPercent'] = $todayPresence['absentPercent'];
        $data['notePercent'] = $todayPresence['notePercent'];
        return parse('Actudent\Admin\Views\dashboard\home', $data);
    }

    public function goToHome()
    {
        return redirect()->to(base_url('guru/home'));
    }

    public function showQuery()
    {
        echo $this->auth->showPenggunaQuery('admin@wolestech.com');
    }
}