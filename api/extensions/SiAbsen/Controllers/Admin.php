<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Admin extends \Actudent
{
    protected $model;

    protected $config;

    protected $aws;

    public function __construct()
    {
        $this->model = new \SiAbsen\Models\CoreModel;
        $this->config = $this->model->getConfig();
        $this->aws = new \AwsClient;
    }

    public function getPermissionDetail($id)
    {
        $data = $this->model->getPermissionDetail($id);
        $data->permit_date = os_date()->format('D-M-Y', reverse($data->permit_date, '-', '-'), '-');
        $data->permit_starttime = substr($data->permit_starttime, 0, 5);
        $data->permit_endtime = substr($data->permit_endtime, 0, 5);

        return $this->createResponse($data);
    }

    public function setPermitStatus($id)
    {
        if(is_admin()) {
            $status = $this->request->getPost('status');
            $this->model->setPermitStatus($status, $id);

            return $this->response->setJSON([
                'msg' => 'OK'
            ]);
        }        
    }

    public function getIndividualSummary($period, $staffType, $staffId = '')
    {
        if(valid_token()) {
            return $this->response->setJSON($this->_getIndividualSummary($period, $staffType, $staffId));
        }
    }

    private function _getIndividualSummary($period, $staffType, $staffId)
    {
        if(empty($staffId)) {
            $staffId = $this->getStaffId();
        }

        return $this->countMonthlySummary(
            $staffId, 
            $staffType, 
            (int)substr($period, 0, 2), 
            (int)substr($period, 3, 4)
        );
    }

    public function getAllStaffSummary($period, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        if(is_admin()) {
            $data = $this->_getAllStaffSummary($period, $limit, $offset, $orderBy, $searchBy, $sort, $search);
            return $this->response->setJSON([
                'container' => $data,
                'totalRows' => $this->model->getStaffRows()
            ]);
        }
    }

    private function _getAllStaffSummary($period, $limit, $offset, $orderBy, $searchBy, $sort, $search)
    {
        $employees = $this->model->getStaff($limit, $offset, $orderBy, $searchBy, $sort, 'null', $search);
        $presenceSummary = [];
        foreach($employees as $e) {
            $data = $this->countMonthlySummary($e->staff_id, $e->staff_type, (int)substr($period, 0, 2), (int)substr($period, 3, 4));
            $presenceSummary[] = [
                'name'      => $e->staff_name,
                'nip'       => $e->staff_nik,
                'absent'    => $this->filterPresence($data, 0),
                'present'   => $this->filterPresence($data, 1),
                'permit'    => $this->filterPresence($data, 2),
                'data'      => $data,
            ];
        }

        return $presenceSummary;
    }

    private function filterPresence($array, $status)
    {
        $result = count(array_filter($array, fn($v) => $v === $status));

        return $result > 0 ? $result : '-';
    }

    protected function countMonthlySummary($staffId, $staffType, $month, $year)
    {
        $dayValues = [];
        $days = [
            'minggu' => 0, 'senin' => 1, 'selasa' => 2,
            'rabu' => 3, 'kamis' => 4, 'jumat' => 5, 'sabtu' => 6
        ];

        // if the employee is staff, then the schedule is from monday through friday
        if($staffType === 'staff') {
            $dayValues = [ 1, 2, 3, 4, 5 ];
        } else {
            // get which days the teacher has teaching schedule 
            $schedules = $this->model->getTeacherSchedules($staffId);
            foreach($schedules as $s) {
                $dayValues[] = $days[$s->schedule_day]; // example: $this->days['senin']
            }
        }

        $presenceData = [];

        // get total days of the selected month
        $totalDays = os_date()->daysInMonth($month, $year);

        // walk through the days of month and look for absence data
        foreach(range(1, $totalDays) as $td) {
            // set the date into YYYY-MM-DD format
            $searchDate = reverse(os_date()->shortDate($td, $month, $year), '-', '-');

            // get the day of week like 0 = sunday through 6 = saturday
            $dayOfWeek = date('w', strtotime($searchDate));

            // if day of week of the searched date is in teacher schedules...
            if(in_array($dayOfWeek, $dayValues)) {
                // get only presence-in data
                // we do not need to check presence-out data, since teacher will only
                // be absent if they do not tap for presence-in
                $in = $this->model->getPresence($staffId, $searchDate, 'masuk');

                // if it exists, it means the teacher was present on that date
                // pass the value with 1 = present, 0 = absent, 2 = permit
                $hasPermission = $this->model->hasPermissionToday($searchDate, $staffId);
                if($in === null && $hasPermission) {
                    $status = 2;
                } elseif($in === null && ! $hasPermission) {
                    $status = 0;
                } else {
                    $status = 1;
                }

                $presenceData[$searchDate] = $status;
            }
        }          

        return $presenceData;
    }

    public function getStaffPresence($date, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->model->getStaff($limit, $offset, $orderBy, $searchBy, $sort, 'null', $search);
        $rows = $this->model->getStaffRows($searchBy, 'null', $search);

        $wrapper = [];
        foreach($data as $key) {
            $in = $this->model->getPresence($key->staff_id, $date, 'masuk');
            $out = $this->model->getPresence($key->staff_id, $date, 'pulang');
            
            $wrapper[] = [
                'nip'   => $key->staff_nik,
                'name'  => $key->staff_name,
                'in'    => $in !== null ? explode(' ', $in->presence_datetime)[1] : '-',
                'out'   => $out !== null ? explode(' ', $out->presence_datetime)[1] : '-',
                'inPhoto'   => $in !== null ? $in->presence_photo : '-',
                'outPhoto'  => $out !== null ? $out->presence_photo : '-',
            ];
        }

        return $this->createResponse([
            'container' => $wrapper,
            'totalRows' => $rows,
        ], 'is_admin');
    }

    protected function getPresence($date, $tag)
    {
        $presence = $this->model->getPresence($this->getStaffId(), $date, $tag);
        
        return $presence;
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