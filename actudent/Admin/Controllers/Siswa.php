<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\SiswaModel;
use Actudent\Admin\Models\KelasModel;

class Siswa extends Actudent
{
    /**
     * @var Actudent\Admin\Models\SiswaModel
     */
    private $siswa;

    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    private $kelas;

    public function __construct()
    {
        $this->siswa = new SiswaModel;
        $this->kelas = new KelasModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminSiswa.page_title');;

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\siswa\siswa-view');
    }

    public function getDataSiswa($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->siswa->getSiswaQuery($limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->siswa->getSiswaRows($searchBy, $search);
        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $rows,
        ]);
    }

    public function getKelas()
    {
        return $this->response->setJSON($this->kelas->getKelas());
    }
}