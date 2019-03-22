<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\KelasModel;

class Kelas extends \CodeIgniter\Controller
{
    /**
     * @var Actudent\Core\Controllers\Actudent
     */
    private $actudent;

    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    private $kelas;

    public function __construct()
    {
        $this->actudent = new Actudent;
        $this->kelas = new KelasModel;
    }

    public function index()
	{
        $data = $this->actudent->common();
        $data['title'] = 'Kelas';

        return Actudent::$parser->setData($data)
                ->render('Actudent\Admin\Views\kelas\kelas-view');
    }

    public function getDataKelas($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->kelas->getKelasQuery($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->kelas->getKelasRows($searchBy, $search);
        echo json_encode([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }
}