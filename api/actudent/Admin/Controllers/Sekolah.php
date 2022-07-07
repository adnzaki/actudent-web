<?php namespace Actudent\Admin\Controllers;

class Sekolah extends \Actudent
{
    public function schoolData()
    {
        $data = $this->common();

        $response = [
            get_lang('Sekolah.sekolah_nama')        => $data['namaSekolah'],
            get_lang('Sekolah.sekolah_alamat')      => $data['alamatSekolah'],
            get_lang('Sekolah.sekolah_telp')        => $data['telpSekolah'],
            get_lang('Sekolah.sekolah_kota')        => $data['lokasiSekolah'],
            get_lang('Sekolah.sekolah_kepsek')      => $data['kepalaSekolah'],
            get_lang('Sekolah.sekolah_web')         => $data['webSekolah'],
            'Email'                             => $data['emailSekolah'],
            get_lang('Sekolah.sekolah_nama_opd')    => $data['namaOPD'],
            get_lang('Sekolah.sekolah_nama_subopd') => $data['subOPD'],
        ];

        return $this->response->setJSON($response);
    }

    public function getSchoolDetail()
    {
        $sekolah = $this->sekolah->getDataSekolah()[0];
        $response = [
            'main'          => $sekolah,
            'letterhead'    => json_decode($sekolah->school_letterhead),
        ];

        return $this->response->setJSON($response);
    }
}