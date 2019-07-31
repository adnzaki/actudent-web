<?php namespace Actudent\Core\Controllers;

/**
 * ACTUDENT - Attitude Control for Student
 * This is the core of Actudent web app version. Everything is set to make this source
 * code maintainable for long-time use.
 * This class must be initialized in the constructor of other classes
 * that would call any static method or property in this class.
 * 
 * @copyright   Wolestech (c) 2019
 * @author      WolesDev Team
 * @version     1.0.0-dev
 */

use Config\Services;
use Actudent\Admin\Models\SekolahModel;
use Actudent\Admin\Models\SettingModel;
use Actudent\Admin\Models\AuthModel;

class Actudent
{
    /**
     * SekolahModel
     * 
     * @var object
     */
    static private $sekolah;

    /**
     * SettingModel
     * 
     * @var object
     */
    static private $setting;

    /**
     * AuthModel
     * 
     * @var object
     */
    static private $auth;

    /**
     * @var \CodeIgniter\View\Parser
     */
    static public $parser;

    /**
     * @var \CodeIgniter\Session\Session
     */
    static public $session;

    /**
     * @var \CodeIgniter\Language\Language
     */
    static public $lang;

    /**
     * @var \CodeIgniter\Validation\Validation
     */
    static public $validation;

    /**
     * Initialize any classes needed and core helper for this class
     */
    function __construct()
    {
        static::$sekolah  = new SekolahModel;
        static::$setting  = new SettingModel;
        static::$auth     = new AuthModel;
        static::$parser   = Services::parser();
        static::$session  = Services::session();
        static::$lang     = Services::language(static::getUserLanguage());
        static::$validation = Services::validation();
        helper('Actudent\Core\Helpers\ostium');
    }
    
    /**
     * Function that supplies global variables for the whole app
     * 
     * @return array
     */
    public static function common()
    {
        $pengguna = static::getDataPengguna();        
        $sekolah = static::getDataSekolah();
        $theme = static::getUserThemes()['data'];
        $userTheme = static::getUserThemes()['selectedTheme'];
        $bahasa = static::getUserLanguage();
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
     * Get school data from SekolahModel
     * 
     * @param int $schoolID
     * @return object
     */
    public static function getDataSekolah()
    {
        if(isset($_SESSION['email']))
        {
            return static::$sekolah->getDataSekolah()[0];
        }        
    }

    /**
     * Get user's data who has been logged in
     * 
     * @return void
     */
    public static function getDataPengguna()
    {
        if(isset($_SESSION['email']))
        {
            return static::$auth->getDataPengguna($_SESSION['email']);
        }
    }

    /**
     * Get theme based on user who is logging into the app
     * 
     * @return void
     */
    public static function getUserThemes()
    {
        if(isset($_SESSION['email']))
        {
            $userTheme = static::$auth->getUserThemes($_SESSION['email']);
            $theme = static::$setting->themeComponents($userTheme[0]->theme);
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
     * Set app language
     * 
     * @param string $lang
     * @return void
     */
    public static function setLanguage(string $lang): void
    {
        // Set bahasa yang dipilih pengguna
        Services::language($lang);

        // simpan ke dalam session
        static::$session->set('actudent_lang', $lang);
    }

    /**
     * Get the user's language preference
     * 
     * @return string
     */
    public static function getUserLanguage()
    {
        if(isset($_SESSION['email']))
        {
            $lang = static::$auth->getUserLanguage($_SESSION['email']);
            return $lang[0]->user_language;
        }
    }
}