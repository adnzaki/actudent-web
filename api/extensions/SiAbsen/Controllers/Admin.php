<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Admin extends \Actudent
{
    private $model;

    public function __construct()
    {
        $this->model = new \SiAbsen\Models\CoreModels;
    }

    public function getConfig()
    {
        $config = $this->model->getConfig();

        return $this->createResponse($config);
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
        if(valid_token()) {
            $latFrom = -6.211010362521487;
            $longFrom = 106.98767371385004;
            $latTo = $this->request->getPost('latTo');
            $longTo = $this->request->getPost('longTo');
    
            $range = 100; // 100 meters
            if($this->calculatePoints($latFrom, $longFrom, $latTo, $longTo) <= $range) {
                $response = [
                    'code'  => 200,
                    'msg'   => 'Posisi lokasi valid'
                ];
            } else {
                $response = [
                    'code'  => 500,
                    'msg'   => 'Posisi lokasi tidak valid. Range tidak boleh lebih dari ' . $range . ' meter.'
                ];
            }
    
            return $this->response->setJSON($response);
        }
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