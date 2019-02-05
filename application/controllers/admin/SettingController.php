<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingController extends Actudent
{
    public function __construct()
    {
        parent:: __construct();
        if(! isset($_SESSION['email']))
        {
            redirect('admin/auth');
        }
    }

    public function settingAplikasi()
    {
        $data = $this->shared();
        $data['title'] = 'Pengaturan';
        $this->parser->parse('admin/pages/settings/setting-view', $data);
    }

    public function setWarnaTema($tema)
    {
        $this->setting->setTheme($_SESSION['email'], $tema);
        redirect('admin/pengaturan-aplikasi');
    }

    public function setBahasa($bahasa)
    {
        $this->setting->setUserLanguage($_SESSION['email'], $bahasa);
        redirect('admin/pengaturan-aplikasi');
    }
}