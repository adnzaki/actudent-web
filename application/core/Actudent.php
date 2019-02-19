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

$jwtVendor = APPPATH . '../vendor/autoload.php';
if(file_exists($jwtVendor))
{
    require $jwtVendor;
}

require 'WebResources.php';

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
     * Web Resources object
     * @var object
     */
    protected $web;

    /**
     * Class Constructor 
     * 
     * @return void
     */
    public function __construct()
    {
        parent:: __construct();
        $this->load->model(['api/v1/UserModel' => 'userModel']);        
        
        $this->web = new WebResources;
        $bahasa = $this->web->getUserLanguage();
        $this->lang->load('actudent', $bahasa);
    }

    /**
     * Fungsi yang menyuplai variabel global untuk aplikasi 
     * 
     * @return array
     */
    protected function shared()
    {
        $pengguna = $this->web->getDataPengguna();  
        $sekolah = $this->web->getDataSekolah();
        $theme = $this->web->getUserThemes()['data'];
        $userTheme = $this->web->getUserThemes()['selectedTheme'];
        $bahasa = $this->web->getUserLanguage();
        $data = [
            'base_url'              => base_url(),
            'assets'                => base_url() . 'public/assets/',
            'appAssets'             => base_url() . 'public/app-assets/',
            'css'                   => base_url() . 'public/css/',
            'fonts'                 => base_url() . 'public/fonts/',
            'images'                => base_url() . 'public/images/',
            'admin'                 => base_url() . 'admin/',    
            'public'                => base_url() . 'public/',
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
            'err007' => 'User does not exists',
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

    public function initializeToken($tokenID){
        if(empty($tokenID)){
            $response = ['status' => FALSE, 'errorCode' => 'err006', 'msg' => $this->GetErrorMessage('err006')];    
            $this->sendResponse($response, 500);
        }
        $this->checkToken($tokenID);
    }
}