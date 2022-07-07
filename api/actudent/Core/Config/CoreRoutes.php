<?php

// Core application section 
$routes->group('core', ['namespace' => 'Actudent\Core\Controllers'], function($routes)
{
	$routes->add('login/validasi', 'Auth::isValidLogin');
	$routes->add('get-lang/(:any)/(:any)', 'Resources::getLocale/$1/$2');
	$routes->add('get-changelog/(:alpha)', 'Resources::getChangelog/$1');
	$routes->add('validate-token/(:any)', 'Resources::validateToken/$1');
	$routes->add('check-subscription', 'Resources::checkSubscription');
  	$routes->add('pengguna', 'Resources::getPengguna');
	$routes->add('sekolah', 'Resources::getSekolah');
	$routes->add('get-subscription-warning', 'Resources::showExpirationNotification');
	$routes->add('get-report-data', 'Resources::getReportData');
	$routes->add('set-language', 'Auth::setLanguage');
});