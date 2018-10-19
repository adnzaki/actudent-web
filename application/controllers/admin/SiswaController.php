<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiswaController extends Actudent
{
    public function __construct()
    {
        parent:: __construct();
        if(! isset($_SESSION['email']))
        {
            redirect('admin/auth');
        }
        else 
        {
            $this->load->model('admin/SiswaModel', 'siswa');
        }
    }
    public function index()
    {
        $data = $this->shared();
        $data['title'] = 'Siswa';
        $this->parser->parse('admin/pages/siswa/siswa-view', $data);
    }

    public function getDataSiswa($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->siswa->getSiswaQuery($limit, $offset, $orderBy, $searchBy, $sort, $search)->result();
        $rows = $this->siswa->getSiswaRows($searchBy, $search);
        echo json_encode([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }
}