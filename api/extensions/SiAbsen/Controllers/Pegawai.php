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

                if($this->getPresence(date('Y-m-d'), $tag) === null) {
                    $this->model->sendPresence($tag, $data, $this->getStaffId());
                }        
                
                $response = [
                    'code'      => 200,
                    'msg'       => lang('SiAbsen.siabsen_absen_berhasil'),
                ];
            }

            return $this->response->setJSON($response);
        }
    }

    public function outStatus()
    {
        if(is_teacher()) {
            $out = $this->getPresence(date('Y-m-d'), 'pulang');
            $in = $this->getPresence(date('Y-m-d'), 'masuk');
            $currentTime = $this->toDecimal(date('H:i:s'));
            $timeOut = $this->toDecimal($this->config->presence_timeout);
            if($in === null && $currentTime < $timeOut) {
                $status = lang('SiAbsen.siabsen_masuk_dulu');
                $canAbsent = 0; // unable to absent
            } elseif($in === null && $currentTime > $timeOut) {
                $status = lang('SiAbsen.siabsen_tidak_masuk');
                $canAbsent = 0; // unable to absent
            } else {
                if($out === null && $currentTime > $timeOut) {
                    $status = lang('SiAbsen.siabsen_belum_pulang');
                    $canAbsent = 1; // able to absent
                } elseif($out === null && $currentTime < $timeOut) {
                    $status = lang('SiAbsen.siabsen_belum_pulang');
                    $canAbsent = 0; // unable to absent
                } else {
                    $status = lang('SiAbsen.siabsen_sudah_pulang');
                    $canAbsent = 0; // unable to absent
                }
            }

            $response = [
                'status'    => $status,
                'canAbsent' => $canAbsent,
                'timeOut'   => $out === null ? '-' : substr($out->presence_datetime, 11, 8)
            ];
    
            return $this->response->setJSON($response);    
        }
    }

    public function inStatus()
    {
        if(is_teacher()) {
            $presence = $this->getPresence(date('Y-m-d'), 'masuk');
            $currentTime = $this->toDecimal(date('H:i:s'));
            $timeOut = $this->toDecimal($this->config->presence_timeout);
            $todayLimit = $this->toDecimal('23:59:00');
            $isLate = 0;
            
            if($presence === null && $currentTime > $timeOut && $currentTime < $todayLimit) {
                $status = lang('SiAbsen.siabsen_tidak_masuk');
                $canAbsent = 0; // unable to absent
            } else {
                if($presence === null) {
                    $status = lang('SiAbsen.siabsen_belum_masuk');
                    $canAbsent = 1; // able to absent
                } else {
                    
                    $timeIn = $this->toDecimal($this->config->presence_timein);
                    $timeLimit = $this->config->timelimit_allowed / 60 / 60;
                    $datetime = explode(' ', $presence->presence_datetime);
                    $presenceIn = $this->toDecimal($datetime[1]);
                    $ontimeLimit = $timeIn + $timeLimit;
        
                    if($presenceIn > $ontimeLimit) {
                        $status = lang('SiAbsen.siabsen_telat_masuk');
                    } else {
                        $status = lang('SiAbsen.siabsen_sudah_masuk');
                    }
    
                    $canAbsent = 0; // unable to absent
                    if($presenceIn > $ontimeLimit) {
                        $isLate = 1;
                    }
                }
            }

            $response = [
                'status'    => $status,
                'canAbsent' => $canAbsent,
                'late'      => $isLate,
                'timeIn'    => $presence === null ? '-' : substr($presence->presence_datetime, 11, 8)
            ];
    
            return $this->response->setJSON($response);
        }
    }
}