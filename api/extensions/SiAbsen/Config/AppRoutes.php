<?php

$routes->group('siabsen', ['namespace' => 'SiAbsen\Controllers'], function($routes)
{
    $routes->add('welcome', 'Admin::main');
});