<?php

// Route group for loading user interface
$routes->group('ui/dist/pwa', ['namespace' => 'Actudent\UITest\Controllers'], function($routes)
{
    $routes->add('home', 'Build::js');
    $routes->add('test/kupret', 'Build::kupret');
});

// Route group for API URL
$routes->group('ui-test', ['namespace' => 'Actudent\UITest\Controllers'], function($routes)
{
    $routes->add('token', 'Build::token');
    $routes->add('generate-token', 'Build::generateToken');
    $routes->add('get-data', 'Build::testGetData');
});
