<?php namespace Actudent\Core\Controllers;

class Error extends \CodeIgniter\Controller
{
    public function show404()
    {
        new \Actudent\Core\Controllers\Actudent;
        $data = Actudent::common();
        $data['title'] = lang('Error.lost_title');
        echo Actudent::$parser->setData($data)
            ->render('Actudent\Core\Views\error404');
    }    
}