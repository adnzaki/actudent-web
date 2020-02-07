<?php namespace Actudent\Core\Controllers;

/**
 * ACTUDENT - Attitude Control for Student
 * This is the core of Actudent web app version. Everything is set to make this source
 * code maintainable for long-time use.
 * Every controller must extend this class in order to make this app runs as expected
 * 
 * @copyright   Wolestech (c) 2019
 * @author      WolesDev Team
 * @version     1.0.0-dev
 */

use Config\Services;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Actudent\Admin\Models\SekolahModel;
use Actudent\Admin\Models\SettingModel;
use Actudent\Admin\Models\AuthModel;

class Actudent extends Controller
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
    protected $parser;

    /**
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * @var \CodeIgniter\Language\Language
     */
    protected $lang;

    /**
     * @var \CodeIgniter\Validation\Validation
     */
    protected $validation;

    /**
     * Initialize any classes needed and core helper for this class
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // preload services
        $this->sekolah  = new SekolahModel;
        $this->setting  = new SettingModel;
        $this->auth     = new AuthModel;
        $this->parser   = Services::parser();
        $this->session  = Services::session();
        $this->lang     = Services::language($this->getUserLanguage());
        $this->validation = Services::validation();
        helper('Actudent\Core\Helpers\ostium');
    }
    
    /**
     * Function that supplies global variables for the whole app
     * 
     * @return array
     */
    protected function common()
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
            'admin'                 => base_url() . 'admin/',            
            'namaSekolah'           => $sekolah->school_name ?? '',
            'domainSekolah'         => $sekolah->school_domain ?? '',
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
    protected function getDataSekolah()
    {
        if(isset($_SESSION['email']))
        {
            return $this->sekolah->getDataSekolah()[0];
        }        
    }

    /**
     * Get user's data who has been logged in
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
     * Get theme based on user who is logging into the app
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
     * Set app language
     * 
     * @param string $lang
     * @return void
     */
    protected function setLanguage(string $lang): void
    {
        // Set bahasa yang dipilih pengguna
        Services::language($lang);

        // simpan ke dalam session
        $this->session->set('actudent_lang', $lang);
    }

    /**
     * Get the user's language preference
     * 
     * @return string
     */
    protected function getUserLanguage()
    {
        if(isset($_SESSION['email']))
        {
            $lang = $this->auth->getUserLanguage($_SESSION['email']);
            return $lang[0]->user_language;
        }
    }
}