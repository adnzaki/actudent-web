<?php
/**
 * API untuk mendapatkan detail siswa
 * method: 'GET'
 * path: '/api/v1/student/student_detail'
 * headers: Authorization
 * params: student_id
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class student_detail extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/StudentModel' => 'studentModel']);
        $this->initialize();
    }

    private function initialize(){
        $tokenID = $this->input->get_request_header('authorization');
        $this->initializeToken($tokenID);
    }

    public function index($studentId) {
        if(empty($studentId)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
        $studentDetail = $this->studentModel->getStudentDetail($studentId);
        $response = ['status' => TRUE, 'results' => $studentDetail];
        $this->sendResponse($response, 200);
    }
    
}
