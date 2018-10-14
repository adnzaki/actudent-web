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
            'admin/SekolahModel' => 'sekolah', 'AuthModel' => 'auth'
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
        $data = [
            'base_url'  => base_url(),
            'assets'    => base_url() . 'public/assets/',
            'appAssets' => base_url() . 'public/app-assets/',
            'css'       => base_url() . 'public/css/',
            'fonts'     => base_url() . 'public/fonts/',
            'images'    => base_url() . 'public/images/',
            'admin'     => base_url() . 'admin/',
            'namaSekolah' => $this->getDataSekolah(1)->schoolName,
            'namaPengguna' => isset($pengguna->userName) ? $pengguna->userName : '',
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
        return $this->sekolah->getDataSekolah($schoolID)[0];
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
            return $this->auth->getDataPengguna($_SESSION['email']);
        }
    }
}