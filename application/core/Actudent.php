<?php
/**
 * ACTUDENT
 * 
 * Attitude Control for Student
 * 
 * Software ini dilisensikan di bawah Wolestech Private License
 * Copyright (c) 2018, Wolestech | Software Developer and Network Builder
 * 
 * Actudent adalah aplikasi yang diperuntukkan untuk sekolah sebagai sarana 
 * "controlling" dan "monitoring" siswa di sekolah yang mencakup kehadiran siswa,
 * kegiatan sekolah, jadwal pelajaran, nilai siswa serta sarana komunikasi antara sekolah dan orang tua
 * 
 * @copyright   Copyright (c) 2018, Wolestech
 * @license     Wolestech Private License
 * @author      WolesDev Team
 * @link        https://wolestech.com
 * @version     1.0.0 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '../vendor/autoload.php';
use \Firebase\JWT\JWT;

/**
 * Actudent Class
 * Ini adalah class inti dari Actudent App. Class ini menyimpan fungsi umum dan 
 * menjadi kunci agar aplikasi dapat berjalan.
 */
class Actudent extends CI_Controller
{
    /**
     * @var string
     */
    public $secretKey = 'Wolestech@2018#Actudent$';

    /**
     * Class Constructor 
     * 
     * @return void
     */
    public function __construct()
    {
        parent:: __construct();
        $this->load->model([
            'admin/SekolahModel' => 'sekolah', 'AuthModel' => 'auth',
            'admin/SettingModel' => 'setting',
        ]);
    }

    /**
     * Fungsi yang menyuplai variabel global untuk aplikasi 
     * 
     * @return array
     */
    protected function shared()
    {
        $pengguna = $this->getDataPengguna();        
        $sekolah = $this->getDataSekolah();
        $theme = $this->getUserThemes()['data'];
        $userTheme = $this->getUserThemes()['selectedTheme'];
        $data = [
            'base_url'              => base_url(),
            'assets'                => base_url() . 'public/assets/',
            'appAssets'             => base_url() . 'public/app-assets/',
            'css'                   => base_url() . 'public/css/',
            'fonts'                 => base_url() . 'public/fonts/',
            'images'                => base_url() . 'public/images/',
            'admin'                 => base_url() . 'admin/',            
            'namaSekolah'           => $sekolah->schoolName ?? '',
            'namaPengguna'          => $pengguna->userName ?? '',
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
     * Get error messages
     * 
     * @param string $code 
     * @return void
     */
    public function GetErrorMessage($code)
    {
        $ErrorMessage = [
            'err001' => 'Invalid email or password', 
            'err002' => 'There is one or more parameter needs', 
            'err003' => 'Invalid Token',
            'err004' => 'Signature verification failed',
            'err005' => 'User already exists',
            'err006' => 'Token required',
        ];

        return element($code, $ErrorMessage);
    }

    /**
     * Get success message
     * 
     * @param string $code
     * @return void
     */
    public function GetSuccessMessage($code)
    {
        $SuccessMessage = [
            'suc001' => 'Success', 
            'suc002' => '', 
        ];

        return element($code, $SuccessMessage);
    }

    /**
     * Send response..
     * 
     * @param array $response
     * @param int $statusHeader 
     * @return void
     */
    public function sendResponse($response, $statusHeader)
    {
		$this->output
        ->set_status_header($statusHeader)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
		->_display();
		exit;
    }

    /**
     * Check token
     * 
     * @param mixed $tokenID
     * @return void
     */
    public function checkToken($tokenID)
    {
        try 
        {
            $decode = JWT::decode($tokenID, $this->secretKey,array('HS256'));
            $whereArray = ['user_id' => $decode->user_id, 'user_name' => $decode->user_name, 'user_email' => $decode->user_email, 'user_level' => $decode->user_level, 'user_status' => '1'];
            if(!$this->userModel->isValidUser($whereArray))
            {
                $response = ['status' => FALSE, 'errorCode' => 'err003', 'msg' => $this->GetErrorMessage('err003')];    
                $this->sendResponse($response, 400);
            }
        } 
        catch (Exception $e) 
        {
            $response = ['status' => FALSE, 'errorCode' => 'err004', 'msg' => $this->GetErrorMessage('err004')];
            $this->sendResponse($response, 400);
        }
    }
}