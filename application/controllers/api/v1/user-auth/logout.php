<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

class logout extends Actudent {

    public function __construct() {
        parent:: __construct();
       
    }

    private function initialize(){
        
    }

    public function index() {
    
    }

    
}
