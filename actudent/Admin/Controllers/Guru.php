<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\GuruModel;

class Guru extends Actudent
{
    /**
     * @var Actudent\Admin\Models\GuruModel
     */
    private $guru;

    public function __construct()
    {
        $this->guru = new GuruModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Guru';

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\guru\guru-view');
    }

    public function getDataGuru($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->guru->getGuruQuery($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->guru->getGuruRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }
}