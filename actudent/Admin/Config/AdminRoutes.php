<?php

$routes->group('admin', ['namespace' => 'Actudent\Admin\Controllers'], function($routes)
{
	$routes->get('/', 'Home::goToHome');
	$routes->add('login', 'Auth::index');
	$routes->add('login/validate', 'Auth::validasi');
	$routes->add('logout', 'Auth::logout');
	$routes->add('home', 'Home::index');
	$routes->add('siswa', 'Siswa::index');
	$routes->add('siswa/get-kelas', 'Siswa::getKelas');
	$routes->add('siswa/get-siswa/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Siswa::getDataSiswa/$1/$2/$3/$4/$5/$6');
	$routes->add('siswa/get-siswa/(:any)/(:any)/(:any)/(:any)/(:any)', 'Siswa::getDataSiswa/$1/$2/$3/$4/$5');
	$routes->add('kelas', 'Kelas::index');
	$routes->add('kelas/get-kelas/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Kelas::getDataKelas/$1/$2/$3/$4/$5/$6');
	$routes->add('kelas/get-kelas/(:any)/(:any)/(:any)/(:any)/(:any)', 'Kelas::getDataKelas/$1/$2/$3/$4/$5');
	$routes->add('agenda', 'Agenda::index');
	$routes->add('agenda/get-events/(:any)/(:any)', 'Agenda::getEvents/$1/$2');
	$routes->add('agenda/get-event-detail/(:any)', 'Agenda::getEventDetail/$1');
	$routes->add('agenda/search-guest/(:any)', 'Agenda::searchGuest/$1');
	$routes->add('agenda/search-guest', 'Agenda::searchGuest/$1');
	$routes->add('agenda/save', 'Agenda::save');
	$routes->add('agenda/save/(:any)', 'Agenda::save/$1');
	$routes->add('agenda/validate-file', 'Agenda::runFileValidation');
	$routes->add('agenda/upload/(:any)', 'Agenda::uploadFile/$1');
	$routes->add('agenda/delete/(:any)', 'Agenda::delete/$1');
	$routes->add('pengaturan-aplikasi', 'Setting::index');
	$routes->add('pengaturan-aplikasi/set-tema/(:any)', 'Setting::setWarnaTema/$1');
	$routes->add('pengaturan-aplikasi/set-bahasa/(:any)', 'Setting::setBahasa/$1');
	$routes->add('test-match', 'Test::testMatch');
	$routes->add('hash/(:any)', 'Test::hash/$1');
	$routes->add('test-login', 'Test::validateLogin');
	$routes->add('test-path', 'Test::getAttPath');
	$routes->add('test-insert-id', 'Test::insertIDTest');
	$routes->add('test-data', 'Test::testData');
});