<?php
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
        $tokenID = $this->input->get_request_header('Authorization');
        if(empty($tokenID)){
            $response = ['status' => FALSE, 'errorCode' => 'err006', 'msg' => $this->GetErrorMessage('err006')];    
            $this->sendResponse($response, 500);
            exit;
        }
    }

    public function index() {
        $tokenID = $this->input->get_request_header('Authorization');
        try {
            $decode = JWT::decode($tokenID, $this->secretKey,array('HS256'));
            $whereArray = ['userID' => $decode->userID, 'userName' => $decode->userName, 'userEmail' => $decode->userEmail, 'userLevel' => $decode->userLevel, 'userStatus' => '1'];
            if($this->userModel->isValidUser($whereArray)){
                $response = ['status' => TRUE];    
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
