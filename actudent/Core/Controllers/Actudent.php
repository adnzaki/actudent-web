<?php namespace Actudent\Core\Controllers;

/**
 * ACTUDENT - Attitude Control for Student
 * This is the core of Actudent web app version. Everything is set to make this source
 * code maintainable for long-time use.
 * Every controller must extend this class in order to make this app runs as expected
 * 
 * @copyright   Wolestech (c) 2020
 * @author      WolesDev Team
 * @version     1.0.0-dev
 */

use Config\Services;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Actudent\Core\Models\SekolahModel;
use Actudent\Core\Models\SettingModel;
use Actudent\Core\Models\AuthModel;
use Actudent\Core\Controllers\Resources;
use Actudent\Admin\Models\PesanModel;

class Actudent extends Controller
{
    /**
     * SekolahModel
     * 
     * @var object
     */
    protected $sekolah;

    /**
     * SettingModel
     * 
     * @var object
     */
    protected $setting;

    /**
     * AuthModel
     * 
     * @var object
     */
    protected $auth;

    
    protected $resources;

    /**
     * PesanModel
     * 
     * @var object
     */
    protected $pesan;

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
        $this->resources= new Resources;
        $this->pesan    = new PesanModel;
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
        $bahasa = $this->getUserLanguage($this->getUserLanguage());
        $letterhead = $this->getLetterHead();
        $changelog = $this->resources->getChangelog($bahasa);
        $data = [
            'ac_version'            => ACTUDENT_VERSION,
            'base_url'              => base_url(),
            'assets'                => base_url() . '/assets/',
            'appAssets'             => base_url() . '/app-assets/',
            'css'                   => base_url() . '/css/',
            'fonts'                 => base_url() . '/fonts/',
            'images'                => base_url() . '/images/',
            'admin'                 => base_url() . '/admin/',  
            'guru'                  => base_url() . '/guru/',
            'newLogin'              => base_url() . '/admin-login/',
            'actudentSection'       => $this->getSection(),
            'namaSekolah'           => $sekolah->school_name ?? '',
            'alamatSekolah'         => $sekolah->school_address ?? '',
            'lokasiSekolah'         => $letterhead->city ?? '',
            'emailSekolah'          => $letterhead->email ?? '',
            'webSekolah'            => $letterhead->website ?? '',
            'telpSekolah'           => $sekolah->school_telephone ?? '',
            'domainSekolah'         => $sekolah->school_domain ?? '',
            'logoSekolah'           => $letterhead->school_logo ?? '',
            'logoOPD'               => $letterhead->opd_logo ?? '',
            'namaOPD'               => $letterhead->opd_name ?? '',
            'subOPD'                => $letterhead->sub_opd_name ?? '',
            'kepalaSekolah'         => $letterhead->headmaster ?? '',
            'wakaKurikulum'         => $letterhead->co_headmaster ?? '',
            'nipKepsek'             => $letterhead->headmaster_nip ?? '',
            'nipWakasek'            => $letterhead->co_headmaster_nip ?? '',
            'namaPengguna'          => $pengguna->user_name ?? '',
            'bahasa'                => $bahasa ?? '',
            'theme'                 => $userTheme ?? '',
            'bodyColor'             => $theme['bodyColor'] ?? '',
            'footerColor'           => $theme['footerColor'] ?? '',
            'footerTextColor'       => $theme['footerTextColor'] ?? '',
            'cardColor'             => $theme['cardColor'] ?? '',
            'cardTitleColor'        => $theme['cardTitleColor'] ?? '',
            'menuColor'             => $theme['menuColor'] ?? '',
            'navbarColor'           => $theme['navbarColor'] ?? '',
            'navbarContainerColor'  => $theme['navbarContainerColor'] ?? '',
            'modalHeaderColor'      => $theme['modalHeaderColor'] ?? '',
            'navlinkColor'          => $theme['navlinkColor'] ?? '',
            'changelog'             => $changelog['changelog'],
            'countChangelog'        => $changelog['countChangelog'],
            'isDashboard'           => $this->isDashboard(),
            'isMessage'             => $this->isMessage(),
            'unreadMessages'        => $this->getUnreadMessages(),
        ];

        return $data;
    }

    /**
     * Get unread messages
     * 
     * @return int
     */
    private function getUnreadMessages()
    {
        if(isset($_SESSION['email']))
        {
            return $this->pesan->getAllUnreadMessages();
        }
    }

    /**
     * Detect message page
     * 
     * @return boolean
     */
    private function isMessage()
    {
        $message = preg_match('/pesan/', current_url());
        return ($message === 1) ? true : false;
    }

    /**
     * Detect dashboard page
     * 
     * @return boolean
     */
    private function isDashboard()
    {
        $dashboard = preg_match('/home/', current_url());
        return ($dashboard === 1) ? true : false;
    }

    /**
     * Get current section whether it's admin or teacher
     * 
     * @return string
     */
    public function getSection()
    {
        $login = preg_match('/login/', current_url());
        if($login === 1) 
        {
            $section = preg_match('/admin/', current_url());
            return ($section === 1) ? 'admin' : 'guru';
        }
    }

    /**
     * The PDF report header
     */
    public function reportHeader()
    {
        return view('Actudent\Core\Views\report\kop-sekolah');
    }

    /**
     * Headmaster sign for PDF Report
     */
    public function masterSign()
    {
        return view('Actudent\Core\Views\report\tanda-tangan-full');
    }

    /**
     * Headmaster sign for PDF Report
     */
    public function homeroomSign()
    {
        return view('Actudent\Core\Views\report\tanda-tangan-walikelas');
    }

    /**
     * Grade leader sign
     */
    public function gradeLeaderSign()
    {
        return view('Actudent\Core\Views\report\tanda-tangan');
    }

    /**
     * Get letter head data
     * 
     * @return object
     */
    protected function getLetterHead()
    {
        if(isset($_SESSION['email']))
        {
            $sekolah = $this->getDataSekolah();
            return json_decode($sekolah->school_letterhead);
        }  
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
        $result = [
            'selectedTheme' => '',
            'data' => '',
        ];

        if(isset($_SESSION['email']))
        {
            $userTheme = $this->auth->getUserThemes($_SESSION['email']);
            $theme = $this->setting->themeComponents($userTheme[0]->theme);
            $wrapper = [];
            foreach($theme as $key)
            {
                $wrapper[$key['settingKey']] = $key['settingValue'];
            }
    
            $result = [
                'selectedTheme' => $userTheme[0]->theme,
                'data' => $wrapper,
            ];
        }

        return $result;
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