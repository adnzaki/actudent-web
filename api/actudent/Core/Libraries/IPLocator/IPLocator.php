<?php

use GeoIp2\Database\Reader;

class IPLocator
{
	private $dbPath = ACTUDENT_PATH . 'Core/Libraries/IPLocator/GeoLite2-City.mmdb';

	private $errorMessage = 'Unknown IP address';

	public $provider;


	public function __construct(string $provider = 'maxmind')
	{
		$this->provider = $provider;
	}

	public function setErrorMessage(string $message)
	{
		$this->errorMessage = $message;

		return $this;
	}

	public function getLocation(string $ipAddress)
	{
		if($this->provider === 'maxmind') {
			return $this->getLocationFromMaxmind($ipAddress);
		} elseif($this->provider === 'ipgeolocation') {
			return $this->getLocationFromIpgeolocation($ipAddress);
		}
	}

	public function getLocationFromIpgeolocation(string $ipAddress)
	{
		$apiKey = '34dbcc1408b34f46a9af469c56699372';
		$excludes = 'currency,time_zone';

		// prepare curl
        $ch = curl_init();

		// set url
        curl_setopt($ch, CURLOPT_URL, 'https://api.ipgeolocation.io/ipgeo?apiKey='.$apiKey.'&ip=' . $ipAddress . '&excludes=' . $excludes);

		// return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
        $output = curl_exec($ch);

        curl_close($ch);

		$geolocation = json_decode($output, true);
		if(array_key_exists('message', $geolocation)) {
			$response = (object)[
				'status' => 'Error',
				'msg' => $this->errorMessage
			];
		} else {
			$response = (object)[
				'status'		=> 'OK',
				'ip' 			=> $geolocation['ip'],
				'countryCode' 	=> $geolocation['country_code2'],
				'countryName' 	=> $geolocation['country_name'],
				'stateCode' 	=> $geolocation['state_code'],
				'stateName' 	=> $geolocation['state_prov'],
				'cityName' 		=> $geolocation['city'],
				'zipcode' 		=> $geolocation['zipcode'],
				'latitude' 		=> $geolocation['latitude'],
				'longitude' 	=> $geolocation['longitude'],
				'isp'			=> $geolocation['isp'],
				'organization'	=> $geolocation['organization'],
			];
		}

		return $response;
	}

	public function getLocationFromMaxmind(string $ipAddress)
	{
		try {
			$reader = new Reader($this->dbPath);
			$record = $reader->city($ipAddress);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}

		if (empty($error)) {
			$ip 			= !empty($record->traits->network) ? $record->traits->network : '';
			$countryCode 	= !empty($record->country->isoCode) ? $record->country->isoCode : '';
			$countryName 	= !empty($record->country->name) ? $record->country->name : '';
			$stateCode 		= !empty($record->mostSpecificSubdivision->isoCode) ? $record->mostSpecificSubdivision->isoCode : '';
			$stateName 		= !empty($record->mostSpecificSubdivision->name) ? $record->mostSpecificSubdivision->name : '';
			$cityName 		= !empty($record->city->name) ? $record->city->name : '';
			$zipcode 		= !empty($record->postal->code) ? $record->postal->code : '';
			$latitude 		= !empty($record->location->latitude) ? $record->location->latitude : '';
			$longitude 		= !empty($record->location->longitude) ? $record->location->longitude : '';

			$response = (object)[
				'status'		=> 'OK',
				'ip' 			=> $ip,
				'countryCode' 	=> $countryCode,
				'countryName' 	=> $countryName,
				'stateCode' 	=> $stateCode,
				'stateName' 	=> $stateName,
				'cityName' 		=> $cityName,
				'zipcode' 		=> $zipcode,
				'latitude' 		=> $latitude,
				'longitude' 	=> $longitude
			];
		} else {
			$response = (object)[
				'status'	=> 'Error',
				'msg'		=> $this->errorMessage
			];
		}

		return $response;
	}
}
