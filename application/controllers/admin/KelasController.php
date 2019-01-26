<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KelasController extends Actudent
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
            $this->load->model('admin/KelasModel', 'kelas');
        }
    }
    public function index()
    {
        $data = $this->shared();
        $data['title'] = 'Kelas';
        $this->parser->parse('admin/pages/kelas/kelas-view', $data);
    }

    public function getDataKelas($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getKelasQuery($limit, $offset, $orderBy, $searchBy, $sort, $search)->result();
        $rows = $this->kelas->getKelasRows($searchBy, $search);
        echo json_encode([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }
}