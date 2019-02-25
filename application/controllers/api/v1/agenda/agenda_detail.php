<?php
/**
 * API untuk mendapatkan detail agenda
 * method: 'GET'
 * path: '/api/v1/agenda/agenda_detail/{agendaId}'
 * headers: Authorization
 * params: agendaId
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class agenda_detail extends Actudent {

    public function __construct() {
        parent:: __construct();
        $this->load->model(['api/v1/AgendaModel' => 'agendaModel']);
        $this->initialize();
    }

    private function initialize(){
        $tokenID = $this->input->get_request_header('authorization');
        $this->initializeToken($tokenID);
    }

    public function index($agendaId) {
        if(empty($agendaId)) {
            $response = ['status' => FALSE, 'errorCode' => 'err002', 'msg' => $this->GetErrorMessage('err002')];
            $this->sendResponse($response, 500);
        }
        $agendaDetail = $this->agendaModel->getAgendaDetail($agendaId);
        $response = ['status' => TRUE, 'results' => $agendaDetail];
        $this->sendResponse($response, 200);
    }
    
}
