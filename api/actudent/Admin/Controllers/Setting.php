<?php namespace Actudent\Admin\Controllers;

class Setting extends \Actudent
{
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