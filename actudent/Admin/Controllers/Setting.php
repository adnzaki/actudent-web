<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\SettingModel;

class Setting extends Actudent
{
    /**
     * @var Actudent\Admin\Models\SiswaModel
     */
    private $setting;

    public function __construct()
    {
        $this->setting = new SettingModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Pengaturan';
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\setting\setting-view');
    }

    public function setWarnaTema($tema)
    {
        $this->setting->setTheme($_SESSION['email'], $tema);
        return redirect()->to(site_url('admin/pengaturan-aplikasi'));
    }

    public function setBahasa($bahasa)
    {
        $this->setting->setUserLanguage($_SESSION['email'], $bahasa);
        return redirect()->to(site_url('admin/pengaturan-aplikasi'));
    }
}