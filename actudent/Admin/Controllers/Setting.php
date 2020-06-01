<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Setting extends Actudent
{
    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminSetting.page_title');
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\setting\setting-view');
    }

    public function setWarnaTema($tema)
    {
        $this->setting->setTheme($_SESSION['email'], $tema);
        return redirect()->to(base_url('admin/pengaturan-aplikasi'));
    }

    public function setBahasa($bahasa)
    {
        $this->setting->setUserLanguage($_SESSION['email'], $bahasa);
        return redirect()->to(base_url('admin/pengaturan-aplikasi'));
    }
}