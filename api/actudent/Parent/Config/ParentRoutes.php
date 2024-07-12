<?php

$routes->group('parent', ['namespace' => 'Actudent\Parent\Controllers'], function($routes)
{
	$routes->add('get-presence-info', 'Dashboard::getPresenceInfo');
	$routes->add('get-today-schedule', 'Dashboard::getTodaySchedule');
	$routes->add('get-homework-info', 'Dashboard::getHomeworkInfo');
});
