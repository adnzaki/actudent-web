<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Test extends Admin
{
    public function testStatus($tag)
    {
        if(valid_token()) {
            $pengguna = $this->getDataPengguna();
            $date = date('Y-m-d');
            $presence = $this->model->getPresence($pengguna->user_id, $date, $tag);
    
            return $this->response->setJSON($presence);
        }
    }
}