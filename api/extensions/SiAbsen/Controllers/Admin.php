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

    protected function getPresence($date, $tag)
    {
        $presence = $this->model->getPresence($this->getStaffId(), $date, $tag);
        
        return count($presence) > 0 ? $presence[0] : null;
    }

    protected function toDecimal($time)
    {
        $timeArr = explode(':', $time);
        $hours = intval($timeArr[0]);
        $minutes = intval($timeArr[1]);

        return $hours + ($minutes / 60);
    }

    protected function getStaffNik()
    {
        return $this->getStaffData()->staff_nik;
    }

    protected function getStaffId()
    {
        return $this->getStaffData()->staff_id;
    }

    private function getStaffData()
    {
        $user = $this->getDataPengguna();
        $staff = $this->model->getStaffDetail($user->user_id);

        return $staff[0];
    }

    public function getConfig()
    {
        return $this->createResponse($this->config);
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