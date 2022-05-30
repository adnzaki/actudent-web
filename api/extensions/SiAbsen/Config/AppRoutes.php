<?php

$routes->group('siabsen', ['namespace' => 'SiAbsen\Controllers'], function($routes)
{
    $routes->add('validate-position', 'Admin::validatePosition');
    $routes->add('get-server-time', 'Admin::getServerTime');
    $routes->add('get-config', 'Admin::getConfig');
    $routes->add('status-masuk', 'Admin::inStatus');
    $routes->add('status-pulang', 'Admin::outStatus');
    $routes->add('kirim-absen/(:any)', 'Pegawai::sendPresence/$1');
    $routes->add('test-status/(:any)', 'Test::testStatus/$1');
});