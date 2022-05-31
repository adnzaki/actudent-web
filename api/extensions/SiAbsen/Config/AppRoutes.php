<?php

$routes->group('siabsen', ['namespace' => 'SiAbsen\Controllers'], function($routes)
{
    $routes->add('validate-position', 'Admin::validatePosition');
    $routes->add('get-config', 'Admin::getConfig');
    $routes->add('status-masuk', 'Pegawai::inStatus');
    $routes->add('status-pulang', 'Pegawai::outStatus');
    $routes->add('upload/(:any)', 'Pegawai::uploadImage/$1');
    $routes->add('kirim-absen/(:any)', 'Pegawai::sendPresence/$1');
    $routes->add('test-status/(:any)', 'Test::testStatus/$1');
    $routes->add('test-aws/(:any)', 'Test::testAws/$1');
});