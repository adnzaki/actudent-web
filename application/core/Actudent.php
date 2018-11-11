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

/**
 * Actudent Class
 * Ini adalah class inti dari Actudent App. Class ini menyimpan fungsi umum dan 
 * menjadi kunci agar aplikasi dapat berjalan.
 */
class Actudent extends CI_Controller
{

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
        $schoolID = isset($pengguna->schoolID) ? $pengguna->schoolID : '';
        $namaSekolah = $this->getDataSekolah($schoolID);
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
            'namaSekolah'           => isset($namaSekolah->schoolName) ? $namaSekolah->schoolName : '',
            'namaPengguna'          => isset($pengguna->userName) ? $pengguna->userName : '',
            'theme'                 => isset($userTheme) ? $userTheme : '',
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
    protected function getDataSekolah($schoolID)
    {
        if(isset($_SESSION['email']))
        {
            return $this->sekolah->getDataSekolah($schoolID)[0];
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
}