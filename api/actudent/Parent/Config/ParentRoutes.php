<?php

$routes->group('parent', ['namespace' => 'Actudent\Parent\Controllers'], function($routes)
{
	$routes->add('get-presence-info', 'Dashboard::getPresenceInfo');
});
