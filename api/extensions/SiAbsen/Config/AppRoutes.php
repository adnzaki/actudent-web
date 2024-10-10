<?php

$routes->group('siabsen', ['namespace' => 'SiAbsen\Controllers'], function($routes)
{
    $routes->add('get-absensi-pegawai/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getStaffPresence/$1/$2/$3/$4/$5/$6');
    $routes->add('get-absensi-pegawai/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getStaffPresence/$1/$2/$3/$4/$5/$6/$7');
    $routes->add('validate-position', 'Admin::validatePosition');
    $routes->add('get-config', 'Admin::getConfig');
    $routes->add('get-detail-config', 'Admin::getFormattedConfig');
    $routes->add('save-config', 'Admin::saveConfig');
    $routes->add('status-masuk', 'Pegawai::inStatus');
    $routes->add('status-pulang', 'Pegawai::outStatus');
    $routes->add('upload/(:any)', 'Pegawai::uploadImage/$1');
    $routes->add('kirim-absen/(:any)', 'Pegawai::sendPresence/$1');
    $routes->add('unggah-lampiran', 'Pegawai::uploadPermitAttachment');
    $routes->add('hapus-lampiran', 'Pegawai::deleteUnusedPermitAttachment');
    $routes->add('kirim-izin', 'Pegawai::sendPermitRequest');
	$routes->add('kirim-izin/(:any)', 'Pegawai::sendPermitRequest/$1');
    $routes->add('get-izin/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Pegawai::getPermissions/$1/$2/$3/$4/$5/$6');
    $routes->add('get-izin/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Pegawai::getPermissions/$1/$2/$3/$4/$5/$6/$7');
    $routes->add('set-status-izin/(:any)', 'Admin::setPermitStatus/$1');
    $routes->add('get-detail-izin/(:any)', 'Admin::getPermissionDetail/$1');
    $routes->add('hapus-izin', 'Pegawai::deletePermission');
    $routes->add('rekap-bulanan/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getAllStaffSummary/$1/$2/$3/$4/$5/$6/$7/$8/$9');
    $routes->add('rekap-bulanan/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getAllStaffSummary/$1/$2/$3/$4/$5/$6/$7/$8');
    $routes->add('rekap-individu/(:any)/(:any)/(:any)', 'Admin::getIndividualSummary/$1/$2/$3');
    $routes->add('rekap-individu/(:any)/(:any)', 'Admin::getIndividualSummary/$1/$2');
    $routes->add('print-rekap-bulanan/(:any)/(:any)/(:any)', 'Admin::exportAllStaffSummary/$1/$2/$3');
    $routes->add('detail-absensi/(:any)/(:any)/(:any)/(:any)', 'Admin::getDetailPresence/$1/$2/$3/$4');
    $routes->add('print-rekap-individu/(:any)/(:any)/(:any)/(:any)', 'Admin::exportStaffSummary/$1/$2/$3/$4/$5');
    $routes->add('rekap-harian', 'Admin::getTodaySummary');
    $routes->add('get-notif-izin', 'Admin::getPermissionNotif');
    $routes->add('jadwal-absen-guru/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getPresenceSchedule/$1/$2/$3/$4/$5');
    $routes->add('jadwal-absen-guru/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getPresenceSchedule/$1/$2/$3/$4/$5/$6');
    $routes->add('sync-jadwal-mengajar/(:any)', 'Admin::getTeachingSchedule/$1');
    $routes->add('update-jadwal', 'Admin::updateSchedule');
    $routes->add('get-jadwal-harian', 'Pegawai::getDailySchedule');
    $routes->add('get-kegiatan/(:any)', 'Kegiatan::getEvents/$1');
    $routes->add('get-kegiatan/(:any)/(:any)', 'Kegiatan::getEvents/$1/$2');
    $routes->add('kirim-absen-agenda/(:any)', 'Kegiatan::sendAgendaPresence/$1');
    $routes->add('get-daftar-hadir/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Kegiatan::getEventDetail/$1/$2/$3/$4/$5/$6');
    $routes->add('test-get-jadwal', 'Test::testGetSchedules');
    $routes->add('test-status/(:any)', 'Test::testStatus/$1');
    $routes->add('test-aws/(:any)', 'Test::testAws/$1');
    $routes->add('test-late/(:any)/(:any)', 'Test::testCountLate/$1/$2');
    $routes->add('test-late/(:any)/(:any)/(:any)', 'Test::testCountLate/$1/$2/$3');
	$routes->add('test-common', 'Test::commonTest');

    // Pengajuan Cuti
    $routes->group('leave-request', ['namespace' => 'SiAbsen\Controllers'], function($routes) {
        $routes->add('list/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'LeaveRequest::getLeaveRequest/$1/$2/$3/$4/$5/$6');
        $routes->add('list/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'LeaveRequest::getLeaveRequest/$1/$2/$3/$4/$5/$6/$7');
        $routes->add('create', 'LeaveRequest::createLeaveRequest');
        $routes->add('update', 'LeaveRequest::updateLeaveRequest');
        $routes->add('attachment/create', 'LeaveRequest::createForm');
        $routes->add('template/download', 'LeaveRequest::downloadFormTemplate');
    });
});
