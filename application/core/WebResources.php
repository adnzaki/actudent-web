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

class WebResources
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model([
            'admin/SekolahModel' => 'sekolah', 'AuthModel' => 'auth',
            'admin/SettingModel' => 'setting',
        ]);
    }

    /**
     * Mengambil data sekolah dari SekolahModel
     * 
     * @param int $schoolID
     * @return object
     */
    public function getDataSekolah()
    {
        if(isset($_SESSION['email']))
        {
            return $this->CI->sekolah->getDataSekolah()[0];
        }        
    }

    /**
     * Mengambil data pengguna yang sudah login
     * 
     * @return void
     */
    public function getDataPengguna()
    {
        if(isset($_SESSION['email']))
        {
            return $this->CI->auth->getDataPengguna($_SESSION['email']);
        }
    }

    /**
     * Mengambil tema berdasarkan user yang sedang login
     * 
     * @return void
     */
    public function getUserThemes()
    {
        if(isset($_SESSION['email']))
        {
            $userTheme = $this->CI->auth->getUserThemes($_SESSION['email']);
            $theme = $this->CI->setting->themeComponents($userTheme[0]->theme);
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
    public function setLanguage(string $lang): void
    {
        // Set bahasa yang dipilih pengguna
        $this->CI->lang->load('actudent', $lang);

        // simpan ke dalam session
        $this->CI->session->set_userdata('actudent_lang', $lang);
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
            $lang = $this->CI->auth->getUserLanguage($_SESSION['email']);
            return $lang[0]->user_language;
        }
    }
}