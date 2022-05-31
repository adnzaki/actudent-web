<?php

namespace Config;

use Actudent\Core\Config\ActudentParserPlugin;
use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * This maps the locations of any namespaces in your application to
     * their location on the file system. These are used by the autoloader
     * to locate files the first time they have been instantiated.
     *
     * The '/app' and '/system' directories are already mapped for you.
     * you may change the name of the 'App' namespace if you wish,
     * but this should be done prior to creating any namespaced classes,
     * else you will need to modify all of those classes for this to work.
     *
     * Prototype:
     *```
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'	       => APPPATH
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $psr4 = [
        APP_NAMESPACE   => APPPATH, // For custom app namespace
        'Config'        => APPPATH . 'Config',
        'Actudent'	  	=> ACTUDENT_PATH,	
        'Mobile'		=> ACTUDENT_PATH . 'Mobile',
        'Keys'			=> ACTUDENT_PATH . 'Core/Config/Keys',
        'SiAbsen'       => SIABSEN_PATH
    ];

    /**
     * -------------------------------------------------------------------
     * Class Map
     * -------------------------------------------------------------------
     * The class map provides a map of class names and their exact
     * location on the drive. Classes loaded in this manner will have
     * slightly faster performance because they will not have to be
     * searched for within one or more directories as they would if they
     * were being autoloaded through a namespace.
     *
     * Prototype:
     *```
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $classmap = [
        'OstiumDate' 	=> ACTUDENT_PATH . 'Core/Libraries/OstiumDate.php',
        'PDFCreator'	=> ACTUDENT_PATH . 'Core/Libraries/PDFCreator.php',
        'ActudentJWT'	=> ACTUDENT_PATH . 'Core/Libraries/ActudentJWT.php',
        'Actudent'      => ACTUDENT_PATH . 'Core/Controllers/Actudent.php',
        'SimpleTag'     => ACTUDENT_PATH . 'Core/Libraries/simple-tag/SimpleTag.php',
        'AwsClient'     => SIABSEN_PATH . 'Libraries/AwsClient.php'
    ];

    /**
     * -------------------------------------------------------------------
     * Files
     * -------------------------------------------------------------------
     * The files array provides a list of paths to __non-class__ files
     * that will be autoloaded. This can be useful for bootstrap operations
     * or for loading functions.
     *
     * Prototype:
     * ```
     *	  $files = [
     *	 	   '/path/to/my/file.php',
     *    ];
     * ```
     *
     * @var array<int, string>
     */
    public $files = [
        APPPATH . 'ThirdParty/vendor/autoload.php'
    ];
}
