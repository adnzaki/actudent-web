<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Pegawai extends Admin
{
    public function sendPresence($tag)
    {
        if(valid_token()) {
            $position = $this->_validatePosition();
            if($position['code'] === 500) {
                $response = [
                    'code'      => 500,
                    'msg'       => lang('SiAbsen.siabsen_absen_gagal'),
                    'reason'    => $position['msg']
                ];
            } else {
                $data = [
                    'lat'   => $this->request->getPost('lat'),
                    'long'  => $this->request->getPost('long'),
                    'photo' => null // will be AWS url
                ];
        
                $this->model->sendPresence($tag, $data, $this->getStaffId());
                
                $response = [
                    'code'      => 200,
                    'msg'       => lang('SiAbsen.siabsen_absen_berhasil'),
                ];
            }

            return $this->response->setJSON($response);
        }
    }
}