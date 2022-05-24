<?php

$routes->group('siabsen', ['namespace' => 'SiAbsen\Controllers'], function($routes)
{
    $routes->add('validate-position', 'Admin::validatePosition');
    $routes->add('get-server-time', 'Admin::getServerTime');
});