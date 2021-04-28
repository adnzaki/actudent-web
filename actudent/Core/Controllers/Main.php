<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Main extends \Actudent\Core\Controllers\Actudent
{
    public function index()
    {
        $data = $this->common();
        return parse('Actudent\Core\Views\MainView', $data);
    }
}