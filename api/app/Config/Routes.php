<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);
// $routes->setAutoRoute(true);
$routes->set404Override('Actudent\Core\Controllers\Error::show404');

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

/**
 * --------------------------------------------------------------------
 * Actudent Modules Routing
 * --------------------------------------------------------------------
 */
// Admin section
require ACTUDENT_PATH . 'Admin/Config/AdminRoutes.php';

// Teacher section
require ACTUDENT_PATH . 'Guru/Config/GuruRoutes.php';

// Parent section
require ACTUDENT_PATH . 'Parent/Config/ParentRoutes.php';

// Installer section
require ACTUDENT_PATH . 'Installer/Config/InstallerRoutes.php';

// Core section
require ACTUDENT_PATH . 'Core/Config/CoreRoutes.php';

// Sync section
require ACTUDENT_PATH . 'Sync/Config/SyncRoutes.php';

/**
 * -----------------------------------------------------------------
 * Mobile Routes
 * -----------------------------------------------------------------
 */
require ACTUDENT_PATH . 'Mobile/V1/Guru/Config/GuruRoutes.php';

/**
 * -----------------------------------------------------------------
 * SiAbsen Routes
 * -----------------------------------------------------------------
 */
require SIABSEN_PATH . 'Config/AppRoutes.php';

// require ACTUDENT_PATH . 'Mobile/OrangTua/Config/OrtuRoutes.php';

$routes->add('service-expired', '\Actudent\Core\Controllers\Error::expiredPage');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
