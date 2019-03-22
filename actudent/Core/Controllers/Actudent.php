<?php namespace Actudent\Core\Controllers;

use Config\Services;
use Actudent\Admin\Models\SekolahModel;
use Actudent\Admin\Models\SettingModel;
use Actudent\Admin\Models\AuthModel;

class Actudent extends \CodeIgniter\Controller 
{
    /**
     * SekolahModel
     * 
     * @var object
     */
    private $sekolah;

    /**
     * SettingModel
     * 
     * @var object
     */
    private $setting;

    /**
     * AuthModel
     * 
     * @var object
     */
    private $auth;

    /**
     * @var \CodeIgniter\View\Parser
     */
    public static $parser;

    /**
     * @var \CodeIgniter\Session\Session
     */
    public static $session;

    /**
     * @var \CodeIgniter\Language\Language
     */
    public static $lang;

    public function __construct()
    {
        $this->sekolah  = new SekolahModel;
        $this->setting  = new SettingModel;
        $this->auth     = new AuthModel;
        self::$parser   = Services::parser();
        self::$session  = Services::session();
        self::$lang     = Services::language($this->getUserLanguage());
        helper('Actudent\Core\Helpers\ostium');
    }
    /**
     * Fungsi yang menyuplai variabel global untuk aplikasi 
     * 
     * @return array
     */
    public function common()
    {
        $pengguna = $this->getDataPengguna();        
        $sekolah = $this->getDataSekolah();
        $theme = $this->getUserThemes()['data'];
        $userTheme = $this->getUserThemes()['selectedTheme'];
        $bahasa = $this->getUserLanguage();
        $data = [
            'base_url'              => base_url(),
            'assets'                => base_url() . 'assets/',
            'appAssets'             => base_url() . 'app-assets/',
            'css'                   => base_url() . 'css/',
            'fonts'                 => base_url() . 'fonts/',
            'images'                => base_url() . 'images/',
            'admin'                 => site_url() . '/admin/',            
            'namaSekolah'           => $sekolah->school_name ?? '',
            'namaPengguna'          => $pengguna->user_name ?? '',
            'bahasa'                => $bahasa ?? '',
            'theme'                 => $userTheme ?? '',
            'bodyColor'             => $theme['bodyColor'],
            'footerColor'           => $theme['footerColor'],
            'footerTextColor'       => $theme['footerTextColor'],
            'cardColor'             => $theme['cardColor'],
            'cardTitleColor'        => $theme['cardTitleColor'],
            'menuColor'             => $theme['menuColor'],
            'navbarColor'           => $theme['navbarColor'],
            'navbarContainerColor'  => $theme['navbarContainerColor'],
            'modalHeaderColor'      => $theme['modalHeaderColor'],
            'navlinkColor'          => $theme['navlinkColor'],
        ];

        return $data;
    }
    
    /**
     * Mengambil data sekolah dari SekolahModel
     * 
     * @param int $schoolID
     * @return object
     */
    protected function getDataSekolah()
    {
        if(isset($_SESSION['email']))
        {
            return $this->sekolah->getDataSekolah()[0];
        }        
    }

    /**
     * Mengambil data pengguna yang sudah login
     * 
     * @return void
     */
    protected function getDataPengguna()
    {
        if(isset($_SESSION['email']))
        {
            return $this->auth->getDataPengguna($_SESSION['email']);
        }
    }

    /**
     * Mengambil tema berdasarkan user yang sedang login
     * 
     * @return void
     */
    protected function getUserThemes()
    {
        if(isset($_SESSION['email']))
        {
            $userTheme = $this->auth->getUserThemes($_SESSION['email']);
            $theme = $this->setting->themeComponents($userTheme[0]->theme);
            $wrapper = [];
            foreach($theme as $key)
            {
                $wrapper[$key['settingKey']] = $key['settingValue'];
            }
    
            return [
                'selectedTheme' => $userTheme[0]->theme,
                'data' => $wrapper,
            ];
        }
    }

    /**
     * Mengatur bahasa yang dipilih pengguna
     * 
     * @param string $lang
     * @return void
     */
    public static function setLanguage(string $lang): void
    {
        // Set bahasa yang dipilih pengguna
        Services::language($lang);

        // simpan ke dalam session
        self::$session->set('actudent_lang', $lang);
    }

    /**
     * Mengambil preferensi bahasa pengguna 
     * 
     * @return string
     */
    public function getUserLanguage()
    {
        if(isset($_SESSION['email']))
        {
            $lang = $this->auth->getUserLanguage($_SESSION['email']);
            return $lang[0]->user_language;
        }
    }
}