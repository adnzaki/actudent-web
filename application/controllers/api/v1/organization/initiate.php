<?php
/**
 * API untuk mengecek user terdaftar atau tidak saat initialize domain email
 * method: 'POST'
 * path: '/api/v1/organization/initiate'
 * headers: Authorization
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class initiate extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/UserModel' => 'userModel']);
        $this->initialize();
    }

    private function initialize(){
        $userEmail = $this->input->post('user_email', TRUE);
        // $tokenID = $this->input->get_request_header('authorization');
        // $this->initializeToken($tokenID);
        if(empty($userEmail)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
    }

    public function index() {
        $userEmail = $this->input->post('user_email', TRUE);
        $userDetail =  $this->userModel->checkUser($userEmail);
        if(element('status', $userDetail)==TRUE) {
            unset($userDetail['status']);
            unset($userDetail['user_status']);
            unset($userDetail['user_password']);
            $response = ['status' => TRUE, 'results' => $userDetail];
            $this->sendResponse($response, 200);
        } else {
            $response = ['status' => FALSE, 'errorCode' => 'err007', 'msg' => $this->GetErrorMessage('err007')];
            $this->sendResponse($response, 400);
        }
    }
    
}
