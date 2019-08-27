<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\KelasModel;

class Kelas extends Actudent
{
    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    private $kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Kelas';

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\kelas\kelas-view');
    }

    public function getDataKelas($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getKelasQuery($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->kelas->getKelasRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }
}