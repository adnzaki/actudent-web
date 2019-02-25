<?php
/**
 * API untuk mendapatkan list timeline
 * method: 'POST'
 * path: '/api/v1/timeline/timeline_list/{userId}'
 * headers: Authorization
 * params: userId
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class agenda_list extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/AgendaModel' => 'agendaModel']);
        $this->initialize();
    }

    private function initialize(){
        // $tokenID = $this->input->get_request_header('authorization');
        // $this->initializeToken($tokenID);
    }

    public function index($userId) {
        if(empty($userId)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
        $agendaList = $this->agendaModel->getAgendaList($userId);
        $response = ['status' => TRUE, 'results' => $agendaList];
        $this->sendResponse($response, 200);
    }
    
}
