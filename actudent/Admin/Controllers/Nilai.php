<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\NilaiModel;

class Nilai extends Actudent
{
    /**
     * @var NilaiModel
     */
    private $nilai;

    public function __construct()
    {
        $this->nilai = new NilaiModel;
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('AdminNilai.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\nilai\nilai-view');
    }
    
}