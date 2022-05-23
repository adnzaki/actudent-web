<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Admin extends \Actudent
{
    public function main()
    {
        echo 'Welcome!';
    }
}