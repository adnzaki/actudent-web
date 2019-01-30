<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class student_list extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/StudentModel' => 'studentModel']);
        $this->initialize();
    }

    private function initialize(){
        $tokenID = $this->input->get_request_header('authorization');
        $this->initializeToken($tokenID);
    }

    public function index($user_id) {
        if(empty($user_id)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }

        $studentList = $this->studentModel->getStudentList($user_id);
        $response = ['status' => TRUE, 'results' => $studentList];
        $this->sendResponse($response, 200);
    }

    
}
