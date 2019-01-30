<?php
/**
 * API untuk login user dan mendapatkan token.
 * method: 'POST'
 * path: '/api/v1/user-auth/login'
 * payload: form-data 
 * - user_email (String)
 * - user_password (String)
 */
defined('BASEPATH') OR exit('No direct script access allowed');

    require APPPATH . '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

class login extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/UserModel' => 'userModel']);
        $this->initialize();
    }

    private function initialize(){
        $userEmail = $this->input->post('user_email', TRUE);
        $userPassword = $this->input->post('user_password', TRUE);

        if(empty($userEmail)||empty($userPassword)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
    }

    public function index() {
        $userEmail = $this->input->post('user_email', TRUE);
        $userPassword = $this->input->post('user_password', TRUE);

        $user = $this->userModel->checkUser($userEmail);
        if(element('status', $user)==TRUE) {
            if($this->verifyPassword($userPassword, element('user_password', $user))){
                $token = $this->getToken(element('user_id', $user),element('user_name', $user), element('user_email', $user),element('user_level', $user));
                unset($user['user_status']);
                unset($user['user_password']);
                $response = ['status' => TRUE, 'token' => $token, 'user_data' => $user];
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
  
    public function getToken($userID, $userName, $userEmail, $userLevel){
        $payload['user_id'] = $userID;
        $payload['user_name'] = $userName;
        $payload['user_email'] = $userEmail;
        $payload['user_level'] = $userLevel;
        $payload['iat'] = $this->getCurrentDate();
        $payload['exp'] = $this->getCurrentDate() + 3600;
        return JWT::encode($payload, $this->secretKey);
    }

    public function verifyPassword($password, $hashPassword){
        if(password_verify($password,$hashPassword)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getCurrentDate(){
        $date = new DateTime();
        return $date->getTimestamp();
    }
    
}
