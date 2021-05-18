<?php

// Route group for loading user interface
$routes->group('main', ['namespace' => 'Actudent\Core\Controllers'], function($routes)
{
    $routes->get('/', 'Main::index');
});

// Core application section 
$routes->group('core', ['namespace' => 'Actudent\Core\Controllers'], function($routes)
{
	$routes->add('get-admin-lang/(:any)', 'Resources::getLocaleResource/$1');
	$routes->add('get-lang/(:any)', 'Resources::getLocaleForUI/$1');
	$routes->add('get-changelog/(:alpha)', 'Resources::getChangelog/$1');
	$routes->add('validate-token/(:any)', 'Resources::validateToken/$1');
  	$routes->add('pengguna', 'Resources::getPengguna');
	$routes->add('sekolah', 'Resources::getSekolah');
});