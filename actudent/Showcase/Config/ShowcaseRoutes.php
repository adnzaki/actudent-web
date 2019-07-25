<?php 

$routes->group('showcase', ['namespace' => 'Actudent\Showcase\Controllers'], function($routes)
{
    $routes->get('/', 'Home::index');
});