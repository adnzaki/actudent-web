<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\PesanModel;

class Pesan extends Actudent
{
    private $pesan;

    public function __construct()
    {
        $this->pesan = new PesanModel();
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('AdminPesan.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\pesan\pesan-view');
    }
}