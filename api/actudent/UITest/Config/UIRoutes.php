<?php

// Route group for loading user interface
$routes->group('test', ['namespace' => 'Actudent\UITest\Controllers'], function($routes)
{
    $routes->get('/', 'Build::js');
});

// Route group for API URL
$routes->group('ui-test', ['namespace' => 'Actudent\UITest\Controllers'], function($routes)
{
    $routes->add('convert-hostname', 'Build::convertHostname');
    $routes->add('token', 'Build::token');
    $routes->add('generate-token', 'Build::generateToken');
    $routes->add('get-data', 'Build::testGetData');
    $routes->add('pengguna', 'Build::getPengguna');
});
