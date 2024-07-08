<?php

$routes->group('install', ['namespace' => 'Actudent\Installer\Controllers'], function($routes)
{
    $routes->add('validate', 'Setup::validateForm');
	$routes->add('setup-database', 'Setup::addTokenKey');
    $routes->add('check', 'Setup::checkInstallation');
    $routes->add('create/(:alpha)', 'Setup::dispatch/$1');
    $routes->add('create-organization', 'Setup::createOrganization');
    $routes->add('basic-test', 'Test::basic');
});
