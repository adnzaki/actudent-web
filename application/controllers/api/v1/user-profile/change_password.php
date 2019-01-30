<?php
/**
 * API untuk menubah password user.
 * method: 'POST'
 * path: '/api/v1/user-profile/change_password/{userID}'
 * headers: authorization
 * params: userID 
 * payload: form-data
 * - userPassword (String)
 * - newPassword (String)
 */
defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

class change_password extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/UserModel' => 'userModel']);
        $this->initialize();
    }

    private function initialize(){
        $userPassword = $this->input->post('user_password', TRUE);
        $newPassword = $this->input->post('new_password', TRUE);
        $tokenID = $this->input->get_request_header('authorization');

        if(empty($tokenID)){
            $response = ['status' => FALSE, 'errorCode' => 'err006', 'msg' => $this->GetErrorMessage('err006')];    
            $this->sendResponse($response, 500);
        }
        if(empty($userPassword)||empty($newPassword)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
        $this->checkToken($tokenID);
    }

    public function index($userID) {
        if(empty($userID)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }

        $userPassword = $this->input->post('user_password', TRUE);
        $newPassword = $this->input->post('new_password', TRUE);

        $user = $this->userModel->checkUserbyId($userID);
        if(element('status', $user)==TRUE) {
            if($this->verifyPassword($userPassword, element('user_password', $user))){
                $data = array('user_password' => $this->createPassword($newPassword));
                $this->userModel->updateUser($data, $userID);
                $response = ['status' => TRUE, 'successCode' => 'suc001', 'msg' => $this->GetSuccessMessage('suc001')];
                $this->sendResponse($response, 200);
            } else {
                $response = ['status' => FALSE, 'errorCode' => 'err001', 'msg' => $this->GetErrorMessage('err001')];
                $this->sendResponse($response, 400);
            }
        } else {
            $response = ['status' => FALSE, 'errorCode' => 'err001', 'msg' => $this->GetErrorMessage('err001')];
            $this->sendResponse($response, 400);
        }
    }

    public function createPassword($password){
        $options = ['cost' => 12];
        return password_hash($password, PASSWORD_DEFAULT, $options);
    }

    public function verifyPassword($password, $hashPassword){
        if(password_verify($password,$hashPassword)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}
