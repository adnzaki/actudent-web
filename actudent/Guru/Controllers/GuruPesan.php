<?php namespace Actudent\Guru\Controllers;

use Actudent\Admin\Controllers\Pesan;

class GuruPesan extends Pesan
{
    public function page()
	{
        $data = $this->common();
        $data['title'] = lang('AdminPesan.page_title');
        $data['userID'] = $_SESSION['id'];

        return parse('Actudent\Admin\Views\pesan\pesan-view', $data);
    }
}