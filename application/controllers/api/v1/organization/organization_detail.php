<?php
/**
 * API untuk mendapatkan info organization/sekolah
 * method: 'GET'
 * path: '/api/v1/organization/organization_detail'
 * headers: Authorization
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class organization_detail extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/OrganizationModel' => 'organizationModel']);
        $this->initialize();
    }

    private function initialize(){
        $tokenID = $this->input->get_request_header('authorization');
        $this->initializeToken($tokenID);
    }

    public function index() {
        $schoolDetail = $this->organizationModel->getSchoolDetail();
        $response = ['status' => TRUE, 'results' => $schoolDetail];
        $this->sendResponse($response, 200);
    }
    
}
