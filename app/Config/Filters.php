<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'			=> \CodeIgniter\Filters\CSRF::class,
		'toolbar'		=> \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot'		=> \CodeIgniter\Filters\Honeypot::class,
		// 'admin'		 	=> \Actudent\Admin\Filters\AdminFilter::class,
		// 'guru'		 	=> \Actudent\Guru\Filters\GuruFilter::class,
		// 'subscription'	=> \Actudent\Core\Filters\CoreFilter::class,
		'throttle'		=> \App\Filters\Throttle::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			'honeypot',
			// 'csrf',
			'throttle',
			// 'admin' => ['except' => [
			// 		'admin/login', 'admin/login/validasi', 
			// 		'core/get-admin-lang/*', 'core/get-changelog/*', 'admin/test-*', 
			// 		'guru/*', 'guru', 'attachments/*',
			// 		'service-expired', 'install', 'install/*',
			// 		'ui-test', 'ui-test/*',
			// 		'ui/dist/pwa', 'ui/dist/pwa/*'
			// 	]
			// ],
			// 'guru' => ['except' => [
			// 		'guru/login', 'guru/login/validasi', 
			// 		'core/get-admin-lang/*', 'core/get-changelog/*', 'admin/test-*', 
			// 		'admin/*', 'admin', 'attachments/*',
			// 		'service-expired', 'install', 'install/*',
			// 		'ui-test', 'ui-test/*',
			// 		'ui/dist/pwa', 'ui/dist/pwa/*'
			// 	]
			// ],
			// 'subscription' => ['except' => [
			// 		'service-expired', 'install', 'install/*',
			// 		'ui-test', 'ui-test/*',
			// 		'ui/dist/pwa', 'ui/dist/pwa/*'
			// 	]
			// ],
		],
		'after'  => [
			'toolbar',	
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
		//'acfilter' => ['before' => ['home']],
	];
}
