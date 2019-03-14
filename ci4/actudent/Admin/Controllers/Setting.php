<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\SettingModel;

class Setting extends \CodeIgniter\Controller 
{
    /**
     * @var Actudent\Core\Controllers\Actudent
     */
    private $actudent;

    /**
     * @var Actudent\Admin\Models\SiswaModel
     */
    private $setting;

    public function __construct()
    {
        $this->actudent = new Actudent;
        $this->setting = new SettingModel;
    }

    public function index()
	{
        $data = $this->actudent->common();
        $data['title'] = 'Pengaturan';
        return Actudent::$parser->setData($data)
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