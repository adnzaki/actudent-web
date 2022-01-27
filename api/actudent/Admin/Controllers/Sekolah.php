<?php namespace Actudent\Admin\Controllers;

class Sekolah extends \Actudent
{
    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('Sekolah.title');
        return parse('Actudent\Admin\Views\sekolah\sekolah-view', $data);
    }

    public function schoolData()
    {
        $data = $this->common();

        $response = [
            lang('Sekolah.sekolah_nama')        => $data['namaSekolah'],
            lang('Sekolah.sekolah_alamat')      => $data['alamatSekolah'],
            lang('Sekolah.sekolah_telp')        => $data['telpSekolah'],
            lang('Sekolah.sekolah_kota')        => $data['lokasiSekolah'],
            lang('Sekolah.sekolah_kepsek')      => $data['kepalaSekolah'],
            lang('Sekolah.sekolah_web')         => $data['webSekolah'],
            'Email'                             => $data['emailSekolah'],
            lang('Sekolah.sekolah_nama_opd')    => $data['namaOPD'],
            lang('Sekolah.sekolah_nama_subopd') => $data['subOPD'],
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