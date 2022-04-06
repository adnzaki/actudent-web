<?php

$routes->group('mobile/v1/guru', ['namespace' => 'Mobile\V1\Guru\Controllers'], function($routes)
{
    $routes->add('home/test', 'Home::testResponse');
});