<?php
/**
 * API untuk mengambil data user.
 * method: 'GET'
 * path: '/api/v1/user-profile/profile/{userID}'
 * headers: authorization
 * params: userID 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

class profile extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/UserModel' => 'userModel']);
        $this->initialize();
    }

    private function initialize(){
        $tokenID = $this->input->get_request_header('authorization');
        $this->initializeToken($tokenID);
    }

    public function index($userID) {
        if(empty($userID)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }

        $user = $this->userModel->checkUserbyId($userID);
        if(element('status', $user)==TRUE) {
            unset($user['user_status']);
            unset($user['user_password']);
            $response = ['status' => TRUE, 'successCode' => 'suc001', 'msg' => $this->GetSuccessMessage('suc001'), 'result' => $user];
            $this->sendResponse($response, 200);
        } else {
            $response = ['status' => FALSE, 'errorCode' => 'err001', 'msg' => $this->GetErrorMessage('err001')];
            $this->sendResponse($response, 400);
        }
    }
    
}
