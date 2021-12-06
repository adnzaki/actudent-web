<?php

$routes->group('mobile/guru', ['namespace' => 'Actudent\Mobile\Guru\Controllers'], function($routes)
{
    $routes->add('home/test', 'Home::testResponse');
});