<?php

$routes->group('sync', ['namespace' => 'Actudent\Sync\Controllers'], function($routes)
{
    $routes->add('peserta-didik', 'Dapodik::pesertaDidik');
    $routes->add('gtk', 'Dapodik::gtk');
    $routes->add('rombel', 'Dapodik::rombonganBelajar');
    $routes->add('set-anggota-rombel', 'Dapodik::setAnggotaRombel');
    $routes->add('test-get-file', 'Test::getFile');
});