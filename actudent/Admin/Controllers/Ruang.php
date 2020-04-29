<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\RuangModel;

class Ruang extends Actudent
{
    /**
     * @var Actudent\Admin\Models\RuangModel
     */
    private $ruang;

    public function __construct()
    {
        $this->ruang = new RuangModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminRuang.ruang_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\ruang\ruang-view');
    }
}