<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Admin extends \Actudent
{
    protected $model;

    protected $config;

    public function __construct()
    {
        $this->model = new \SiAbsen\Models\CoreModel;
        $this->config = $this->model->getConfig();
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
                if($out === null) {
                    $status = lang('SiAbsen.siabsen_belum_pulang');
                    $canAbsent = 1; // able to absent
                } else {
                    $status = lang('SiAbsen.siabsen_sudah_pulang');
                    $canAbsent = 0; // unable to absent
                }
            }

            $response = [
                'status'    => $status,
                'canAbsent' => $canAbsent
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
        
                    if($presenceIn > $timeIn) {
                        $status = lang('SiAbsen.siabsen_telat_masuk');
                    } else {
                        $status = lang('SiAbsen.siabsen_sudah_masuk');
                    }
    
                    $canAbsent = 0; // unable to absent
                    if($presenceIn > ($timeIn + $timeLimit)) {
                        $isLate = 1;
                    }
                }
            }

            $response = [
                'status'    => $status,
                'canAbsent' => $canAbsent,
                'late'      => $isLate,
            ];
    
            return $this->response->setJSON($response);
        }
    }

    private function getPresence($date, $tag)
    {
        $pengguna = $this->getDataPengguna();
        $presence = $this->model->getPresence($this->getStaffId(), $date, $tag);
        
        return count($presence) > 0 ? $presence[0] : null;
    }

    private function toDecimal($time)
    {
        $timeArr = explode(':', $time);
        $hours = intval($timeArr[0]);
        $minutes = intval($timeArr[1]);

        return $hours + ($minutes / 60);
    }

    protected function getStaffId()
    {
        $user = $this->getDataPengguna();
        $staff = $this->model->getStaffDetail($user->user_id);

        return $staff[0]->staff_id;
    }

    public function getConfig()
    {
        return $this->createResponse($this->config);
    }

    public function getServerTime()
    {
        $d = getdate();
        $response = [
            'hours'     => $d['hours'],
            'minutes'   => $d['minutes']
        ];

        return $this->response->setJSON($response);
    }
        
    public function validatePosition()
    {        
        return $this->createResponse($this->_validatePosition());
    }

    protected function _validatePosition()
    {
        $latFrom = $this->config->latitude;
        $longFrom = $this->config->longitude;
        $latTo = $this->request->getPost('lat');
        $longTo = $this->request->getPost('long');

        $range = $this->config->locationlimit_allowed; // maximum radius
        if($this->calculatePoints($latFrom, $longFrom, $latTo, $longTo) <= $range) {
            $response = [
                'code'  => 200,
                'msg'   => lang('SiAbsen.siabsen_lokasi_valid')
            ];
        } else {
            $response = [
                'code'  => 500,
                'msg'   => lang('SiAbsen.siabsen_lokasi_invalid', [ $range ])
            ];
        }

        return $response;
    }
    
    private function calculatePoints($latFrom, $longFrom, $latTo, $longTo)
    {        
        $long1 = deg2rad($longFrom);
		$long2 = deg2rad($longTo);
		$lat1 = deg2rad($latFrom);
		$lat2 = deg2rad($latTo);
			
		//Haversine Formula
		$dlong = $long2 - $long1;
		$dlati = $lat2 - $lat1;
			
		$val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
			
		$res = 2 * asin(sqrt($val));
			
		$radius = 6371;
        $toMeters = ($res * $radius) * 1000;
			
		return $toMeters;
    }
}