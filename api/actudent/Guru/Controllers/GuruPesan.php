<?php namespace Actudent\Guru\Controllers;

class GuruPesan extends \Actudent\Admin\Controllers\Pesan
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminPesan.page_title');
        $data['userID'] = $_SESSION['id'];

        return parse('Actudent\Admin\Views\pesan\pesan-view', $data);
    }
}