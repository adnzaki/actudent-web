<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Error401 extends \CodeIgniter\Controller
{
    /**
     * @var Actudent\Core\Controllers\Actudent
     */
    private $actudent;

    public function __construct()
    {
        $this->actudent = new Actudent;
    }

    public function index()
    {
        $data = $this->actudent->common();
        $data['title'] = lang('Error.lost_title');
        return Actudent::$parser->setData($data)
            ->render('Actudent\Admin\Views\error401');
    }
}