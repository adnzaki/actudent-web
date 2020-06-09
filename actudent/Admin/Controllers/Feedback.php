<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Feedback extends Actudent
{
    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminFeedback.page_title');
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\feedback\feedback-view');
    }

    // public function setWarnaTema($tema)
    // {
    //     $this->setting->setTheme($_SESSION['email'], $tema);
    //     return redirect()->to(base_url('admin/pengaturan-aplikasi'));
    // }

    // public function setBahasa($bahasa)
    // {
    //     $this->setting->setUserLanguage($_SESSION['email'], $bahasa);
    //     return redirect()->to(base_url('admin/pengaturan-aplikasi'));
    // }
}