<?php

$routes->group('install', ['namespace' => 'Actudent\Installer\Controllers'], function($routes)
{
    $routes->add('setup', 'Setup::index');
    $routes->add('setup/create-module/(:alpha)', 'Setup::dispatch/$1');
    $routes->add('setup/drop-tables', 'Setup::dropTables');
    $routes->add('registrasi', 'Registration::index');
});