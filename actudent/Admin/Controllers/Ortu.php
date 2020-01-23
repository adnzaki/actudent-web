<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\OrtuModel;

class Ortu extends Actudent
{
    /**
     * @var Actudent\Admin\Models\OrtuModel
     */
    private $ortu;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ortu = new OrtuModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Orang Tua';

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\ortu\ortu-view');
    }

    public function getParents($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->ortu->getParents($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->ortu->getParentRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }
}