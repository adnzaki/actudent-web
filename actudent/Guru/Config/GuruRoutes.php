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
	$routes->add('nilai', 'GuruNilai::page');
	$routes->add('nilai/daftar-pelajaran', 'GuruNilai::getTeacherLessons');
	$routes->add('nilai/get-kategori/(:any)/(:any)/(:any)', 'GuruNilai::getScores/$1/$2/$3');
	$routes->add('nilai/save/(:num)/(:alpha)', 'GuruNilai::save/$1/$2');
	$routes->add('nilai/save/(:any)/(:any)/(:any)', 'GuruNilai::save/$1/$2/$3');
	$routes->add('nilai/detail/(:any)', 'GuruNilai::getScoreDetail/$1');
	$routes->add('nilai/hapus', 'GuruNilai::deleteScore');
	$routes->add('nilai/kelola/(:num)/(:num)', 'GuruNilai::getStudentScore/$1/$2');
	$routes->add('nilai/simpan-nilai/(:any)', 'GuruNilai::saveScores/$1');
	$routes->add('nilai/ekspor/(:num)/(:num)', 'GuruNilai::exportScores/$1/$2');
	$routes->add('umpan-balik', 'GuruFeedback::page');
	$routes->add('umpan-balik/validasi', 'GuruFeedback::FeedbackValidation');
	$routes->add('umpan-balik/send/', 'GuruFeedback::send');
	$routes->add('umpan-balik/send/(:any)', 'GuruFeedback::send/$1');
	$routes->add('umpan-balik/validasi-gambar', 'GuruFeedback::runFileValidation');
	$routes->add('umpan-balik/upload-gambar', 'GuruFeedback::uploadFile');
});