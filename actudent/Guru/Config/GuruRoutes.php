<?php

$routes->group('guru', ['namespace' => 'Actudent\Guru\Controllers'], function($routes)
{
	$routes->get('/', 'TeacherHome::goToHome');
	$routes->add('home', 'TeacherHome::page');
	$routes->add('home/absensi-seminggu', 'TeacherHome::getLastSevenDaysPresence');
	$routes->add('login', 'Auth::index');
	$routes->add('login/validate', 'Auth::validasi');
	$routes->add('logout', 'Auth::logout');
	$routes->add('agenda', 'ReadAgenda::page');
	$routes->add('agenda/get-events/(:any)/(:any)', 'ReadAgenda::getEvents/$1/$2');
	$routes->add('agenda/get-event-detail/(:any)', 'ReadAgenda::getEventDetail/$1');
	$routes->add('agenda/display-attachment/(:any)', 'ReadAgenda::displayAttachment/$1');
	$routes->add('pengaturan-aplikasi', 'Pengaturan::index');
	$routes->add('pengaturan-aplikasi/set-tema/(:any)', 'Pengaturan::setWarnaTema/$1');
	$routes->add('pengaturan-aplikasi/set-bahasa/(:any)', 'Pengaturan::setBahasa/$1');
	$routes->add('jadwal-kehadiran', 'SchedulePresence::page');
	$routes->add('jadwal-kehadiran/daftar-jadwal/(:any)', 'SchedulePresence::getTeacherSchedules/$1');
	$routes->add('jadwal-kehadiran/cek-jurnal/(:any)/(:any)', 'SchedulePresence::checkJournal/$1/$2');
	$routes->add('jadwal-kehadiran/get-absen/(:any)/(:any)/(:any)', 'SchedulePresence::getListAbsensi/$1/$2/$3');
	$routes->add('jadwal-kehadiran/get-jurnal/(:any)', 'SchedulePresence::getJournal/$1');
	$routes->add('jadwal-kehadiran/save/(:any)/(:any)/(:any)', 'SchedulePresence::save/$1/$2/$3');
	$routes->add('jadwal-kehadiran/simpan-absen/(:any)/(:any)/(:any)', 'SchedulePresence::savePresence/$1/$2/$3');
	$routes->add('jadwal-kehadiran/izin', 'SchedulePresence::validateMark');
	$routes->add('jadwal-kehadiran/arsip-jurnal/(:any)/(:any)', 'SchedulePresence::getJournalArchives/$1/$2');
	$routes->add('timeline', 'ReadTimeline::page');
	$routes->add('timeline/get-posts/(:any)/(:any)', 'ReadTimeline::getPosts/$1/$2');
	$routes->add('timeline/get-detail/(:any)', 'ReadTimeline::getPostDetail/$1');
});