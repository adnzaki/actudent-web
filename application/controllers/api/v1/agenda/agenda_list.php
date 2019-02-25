<?php
/**
 * API untuk mendapatkan list agenda
 * method: 'POST'
 * path: '/api/v1/agenda/agenda_list/{userId}'
 * headers: Authorization
 * params: userId
 * payload:
 * - agenda_month (string)
 * - agenda_year (string)
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class agenda_list extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/AgendaModel' => 'agendaModel']);
        $this->initialize();
    }

    private function initialize(){
        $agendaMonth = $this->input->post('agenda_month', TRUE);
        $agendaYear = $this->input->post('agenda_year', TRUE);
        if(empty($agendaMonth)||empty($agendaYear)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }

        $tokenID = $this->input->get_request_header('authorization');
        $this->initializeToken($tokenID);
    }

    public function index($userId) {
        if(empty($userId)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
        $agendaMonth = $this->input->post('agenda_month', TRUE);
        $agendaYear = $this->input->post('agenda_year', TRUE);
        $agendaList = $this->agendaModel->getAgendaList($userId, $agendaMonth, $agendaYear);
        $response = ['status' => TRUE, 'results' => $agendaList];
        $this->sendResponse($response, 200);
    }
    
}
