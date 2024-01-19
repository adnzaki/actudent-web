<?php

use GeoIp2\Database\Reader;

class IPLocator
{
	private $dbPath = ACTUDENT_PATH . 'Core/Libraries/IPLocator/GeoLite2-City.mmdb';

	public function getLocation(string $ipAddress)
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
				'msg'		=> $error
			];
		}

		return $response;
	}
}
