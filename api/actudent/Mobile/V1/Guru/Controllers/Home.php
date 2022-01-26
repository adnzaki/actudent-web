<?php namespace Mobile\V1\Guru\Controllers;

/**
 * Home class
 * 
 * This is your controller, each of them should extend 
 * the core controller in order to make everything works
 * as expected
 */
class Home extends \Actudent\Core\Controllers\Actudent
{
    private $kelas;

    public function __construct()
    {
        // define the model here
        $this->kelas = new \Actudent\Admin\Models\KelasModel;
    }

<<<<<<< HEAD:api/actudent/Mobile/V1/Guru/Controllers/Home.php
    // URI path : api/public/mobile/v1/guru/home/test
=======
    // URI path : api/public/mobile/guru/v1/home/test
>>>>>>> df6d9eadf33dbcac190a409a209224e0b35a85a0:api/actudent/Mobile/Guru/Controllers/Home.php
    // Status   : Tested [Postman]
    public function testResponse()
    {
        // validated using valid_token() 
        // since it is the default validator for createResponse()
        // if there is no second argument applied
        return $this->createResponse(['data' => $this->kelas->getKelas()]);
    }
}