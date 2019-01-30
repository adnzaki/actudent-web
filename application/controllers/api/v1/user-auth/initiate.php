<?php
/**
 * API untuk mengecek user authentification valid atau tidak.
 * method: 'GET'
 * path: '/api/v1/user-auth/initiate'
 * headers: Authorization
 */
defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

class initiate extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/UserModel' => 'userModel']);
        $this->initialize();
    }

    private function initialize(){
        $tokenID = $this->input->get_request_header('authorization');
        if(empty($tokenID)){
            $response = ['status' => FALSE, 'errorCode' => 'err006', 'msg' => $this->GetErrorMessage('err006')];    
            $this->sendResponse($response, 500);
        }
    }

    public function index() {
        $tokenID = $this->input->get_request_header('authorization');
        try {
            $decode = JWT::decode($tokenID, $this->secretKey,array('HS256'));
            $whereArray = ['user_id' => $decode->user_id, 'user_name' => $decode->user_name, 'user_email' => $decode->user_email, 'user_level' => $decode->user_level, 'user_status' => '1'];
            if($this->userModel->isValidUser($whereArray)){
                $response = ['status' => TRUE, 'successCode' => 'suc001', 'msg' => $this->GetSuccessMessage('suc001')];    
                $this->sendResponse($response, 200);
            } else {
               $response = ['status' => FALSE, 'errorCode' => 'err003', 'msg' => $this->GetErrorMessage('err003')];    
               $this->sendResponse($response, 400);
            }
        } catch (Exception $e) {
            $response = ['status' => FALSE, 'errorCode' => 'err004', 'msg' => $this->GetErrorMessage('err004')];
            $this->sendResponse($response, 400);
        }
    }
    
}
