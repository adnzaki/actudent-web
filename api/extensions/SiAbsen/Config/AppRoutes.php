<?php

$routes->group('siabsen', ['namespace' => 'SiAbsen\Controllers'], function($routes)
{
    $routes->add('get-absensi-pegawai/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getStaffPresence/$1/$2/$3/$4/$5/$6');
    $routes->add('get-absensi-pegawai/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Admin::getStaffPresence/$1/$2/$3/$4/$5/$6/$7');
    $routes->add('validate-position', 'Admin::validatePosition');
    $routes->add('get-config', 'Admin::getConfig');
    $routes->add('status-masuk', 'Pegawai::inStatus');
    $routes->add('status-pulang', 'Pegawai::outStatus');
    $routes->add('upload/(:any)', 'Pegawai::uploadImage/$1');
    $routes->add('kirim-absen/(:any)', 'Pegawai::sendPresence/$1');
    $routes->add('unggah-lampiran', 'Pegawai::uploadPermitAttachment');
    $routes->add('hapus-lampiran', 'Pegawai::deleteUnusedPermitAttachment');
    $routes->add('kirim-izin', 'Pegawai::sendPermitRequest');
    $routes->add('get-izin/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Pegawai::getPermissions/$1/$2/$3/$4/$5/$6');
    $routes->add('get-izin/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)', 'Pegawai::getPermissions/$1/$2/$3/$4/$5/$6/$7');
    $routes->add('set-status-izin/(:any)', 'Admin::setPermitStatus/$1');
    $routes->add('get-detail-izin/(:any)', 'Admin::getPermissionDetail/$1');
    $routes->add('rekap-bulanan/(:any)/(:any)', 'Admin::getMonthlySummary/$1/$2');
    $routes->add('test-status/(:any)', 'Test::testStatus/$1');
    $routes->add('test-aws/(:any)', 'Test::testAws/$1');
});