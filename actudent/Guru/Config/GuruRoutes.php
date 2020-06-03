<?php

$routes->group('guru', ['namespace' => 'Actudent\Guru\Controllers'], function($routes)
{
	$routes->add('home', 'Home::index');
	$routes->add('login', 'Auth::index');
	$routes->add('login/validate', 'Auth::validasi');
	$routes->add('logout', 'Auth::logout');
	$routes->add('pengaturan-aplikasi', 'Pengaturan::index');
	$routes->add('pengaturan-aplikasi/set-tema/(:any)', 'Pengaturan::setWarnaTema/$1');
	$routes->add('pengaturan-aplikasi/set-bahasa/(:any)', 'Pengaturan::setBahasa/$1');
});