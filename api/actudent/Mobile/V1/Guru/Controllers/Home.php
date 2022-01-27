<?php namespace Mobile\V1\Guru\Controllers;

/**
 * Home class
 * 
 * This is your controller, each of them should extend 
 * the core controller in order to make everything works
 * as expected
 */
class Home extends \Actudent
{
    private $kelas;

    public function __construct()
    {
        // define the model here
        $this->kelas = new \Actudent\Admin\Models\KelasModel;
    }

    // URI path : api/public/mobile/v1/guru/home/test
    // Status   : Tested [Postman]
    public function testResponse()
    {
        // validated using valid_token() 
        // since it is the default validator for createResponse()
        // if there is no second argument applied
        return $this->createResponse(['data' => $this->kelas->getKelas()]);
    }
}