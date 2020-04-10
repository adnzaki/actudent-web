<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AbsensiModel;

class Absensi extends Actudent
{
    /**
     * @var Actudent\Admin\Models\AbsensiModel
     */
    private $absensi;

    public function __construct()
    {
        $this->absensi = new AbsensiModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Kehadiran';

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\absensi\absensi-view');
    }
}