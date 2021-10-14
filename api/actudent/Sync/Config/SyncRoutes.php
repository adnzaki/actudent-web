<?php

$routes->group('sync', ['namespace' => 'Actudent\Sync\Controllers'], function($routes)
{
    $routes->add('peserta-didik', 'Sync::pesertaDidik');
    $routes->add('gtk', 'Sync::gtk');
});