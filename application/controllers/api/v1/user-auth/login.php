<?php
/**
 * API untuk login user dan mendapatkan token.
 * method: 'POST'
 * path: '/api/v1/user-auth/login'
 * payload: form-data 
 * - userEmail (String)
 * - userPassword (String)
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
        $userEmail = $this->input->post('userEmail', TRUE);
        $userPassword = $this->input->post('userPassword', TRUE);

        if(empty($userEmail)||empty($userPassword)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
    }

    public function index() {
        $userEmail = $this->input->post('userEmail', TRUE);
        $userPassword = $this->input->post('userPassword', TRUE);

        $user = $this->userModel->checkUser($userEmail);
        if(element('status', $user)==TRUE) {
            if($this->verifyPassword($userPassword, element('userPassword', $user))){
                $token = $this->getToken(element('userID', $user),element('userName', $user), element('userEmail', $user),element('userLevel', $user));
                unset($user['status']);
                unset($user['userPassword']);
                $response = ['status' => TRUE, 'token' => $token, 'userData' => $user];
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
        $payload['userID'] = $userID;
        $payload['userName'] = $userName;
        $payload['userEmail'] = $userEmail;
        $payload['userLevel'] = $userLevel;
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
