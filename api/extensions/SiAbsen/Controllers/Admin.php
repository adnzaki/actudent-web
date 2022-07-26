<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use PDFCreator;

class Admin extends \Actudent
{
    protected $model;

    protected $config;

    protected $aws;

    private $days = [
        'senin' => 0, 'selasa' => 1, 'rabu' => 2, 
        'kamis' => 3, 'jumat' => 4, 'sabtu' => 5,
        'minggu' => 6
    ];

    public function __construct()
    {
        $this->model = new \SiAbsen\Models\CoreModel;
        $this->config = $this->model->getConfig();
        $this->aws = new \AwsClient;
        $this->timer = \Config\Services::timer();
    }

    public function updateSchedule()
    {
        if(is_admin()) {
            $scheduleStr = $this->request->getPost('schedule');    
            $staffId = (int)$this->request->getPost('id');  
            $schedule = json_decode($scheduleStr, true);
            $values = [];

            foreach($schedule as $key => $val) {
                $day = substr($key, -1, 1);
                $values[] = [
                    'staff_id'          => $staffId,
                    'schedule_day'      => $day,
                    'schedule_timein'   => $val['timein'],
                    'schedule_timeout'  => $val['timeout']
                ];
            }

            $this->model->updateSchedule($staffId, $values);

            return $this->response->setJSON(['msg' => 'OK']);
        }                
    }

    public function getTeachingSchedule($staffId)
    {
        if(is_admin()) {
            timer('sync');
            $schedule = $this->model->getTeacherSchedules($staffId);
            $wrapper = [];
            foreach($schedule as $s) {
                $first = $this->model->getFirstAndLastSchedule($staffId, $s->schedule_day, 'min');
                $last = $this->model->getFirstAndLastSchedule($staffId, $s->schedule_day, 'max');
                $wrapper[] = [
                    'day'   => $s->schedule_day,
                    'first' => $first->schedule_start,
                    'last'  => $last->schedule_end
                ];
            }

            $values = [];    
            if(count($wrapper) > 0) {
                foreach($wrapper as $w) {
                    $day = $this->days[$w['day']];

                    // prepare data
                    $values[] = [
                        'staff_id'          => $staffId,
                        'schedule_day'      => $day,
                        'schedule_timein'   => str_replace('.', ':', $w['first']),
                        'schedule_timeout'  => str_replace('.', ':', $w['last'])
                    ];
    
                }
            }

            // do insertion
            $this->model->updateSchedule($staffId, $values);
    
            timer('sync');
            $elapsed = timer()->getElapsedTime('sync');
    
            return $this->response->setJSON([
                'elapsed'   => number_format($elapsed, 3, ',', '.'),
                'status'    => 'OK',
            ]);
        }
    }

    public function getPresenceSchedule($limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        timer('getSchedule');
        // get the employees first (must be SSPaging-compatible format)
        $employees = $this->model->getStaff($limit, $offset, $orderBy, $searchBy, $sort, 'null', $search);
        $rows = $this->model->getStaffRows($searchBy, 'null', $search);
        
        // prepare the data container
        $data = [];

        foreach($employees as $e) {
            $presenceSchedule = $this->model->getPresenceSchedule($e->staff_id);
            $dayValues = [];
            $schedule = [];

            // if presence schedule exists
            if($presenceSchedule !== null) {
                // create array containing presence schedule
                $daysArray = array_column($presenceSchedule, 'schedule_day');
                $timeinArray = array_column($presenceSchedule, 'schedule_timein');
                $timeoutArray = array_column($presenceSchedule, 'schedule_timeout');

                foreach($daysArray as $a => $b) {
                    $dayValues[] = [
                        'value'     => (int)$b,
                        'timein'    => $timeinArray[$a],
                        'timeout'   => $timeoutArray[$a]
                    ];
                }
            }            

            // here we loop the days from monday to sunday (0-6)
            // to generate the final presence schedule
            $schedule = [];
            foreach(range(0, 6) as $k => $v) {   
                $filtered = function($array, $val) {
                    $filterItems = array_filter($array, fn($v) => $v['value'] === $val);
                    $default = [
                        'value'     => 'null',
                        'timein'    => '',
                        'timeout'   => ''
                    ];

                    return count($filterItems) > 0 
                            ? array_slice($filterItems, 0, 1)[0] 
                            : $default;
                };

                $schedule['day'.$k] = $filtered($dayValues, $v);
            }

            $data[] = [
                'name'      => $e->staff_name,
                'nip'       => $e->staff_nik,
                'id'        => $e->staff_id,
                'type'      => $e->staff_type,
                'schedule'  => $schedule
            ];
        }

        timer('getSchedule');
        $elapsed = timer()->getElapsedTime('getSchedule');

        return $this->createResponse([
            'elapsed'   => number_format($elapsed, 5, ',', '.'),
            'container' => $data,
            'totalRows' => $rows
        ], 'is_admin');
    }

    public function getPermissionNotif()
    {
        $data = $this->model->getPermissionNotif();
        return $this->createResponse(['notif' => $data], 'is_admin');
    }

    public function getTodaySummary()
    {
        $rows = $this->model->getStaffRows();
        $employees = $this->model->getStaff($rows, 0);
        $summary = [];
        foreach($employees as $e) {
            $summary[$e->staff_name] = $this->getPresenceStatus($e->staff_id, $e->staff_type, date('Y-m-d'));
        }

        $countStatus = function ($type) use ($summary) {
            return count(array_filter($summary, fn($v) => $v === $type));
        };

        return $this->createResponse([
            'absent' => $countStatus(0),
            'present' => $countStatus(1),
            'permit' => $countStatus(2),
        ]);
    }

    public function exportStaffSummary($staffId, $userId, $period, $token)
    {
        if(valid_token($token)) {
            $data = [];        
            foreach($this->resources->getReportData($token) as $key => $val) {
                $data[$key] = $val;
            }

            if($staffId === 'null' || $userId === 'null') {
                $staffData = $this->getStaffData($token);
                $staffId = $staffData->staff_id;
                $userId = $staffData->user_id;
            }

            $periodArr = explode('-', $period); // [ month, year ]
            $month = (int)$periodArr[0];
            $year = $periodArr[1];
            $lastDate = os_date()->daysInMonth($month, $year);
            $result = $this->_getDetailPresence($staffId, $userId, $period);
            
            $title          = 'Rekapitulasi Absensi Bulan ' . os_date()->getMonthName($month);
            $data['title']  = $title;
            $data['year']   = 'Tahun ' . $year;
            $data['data']   = $result['data'];
            $data['nip']    = $result['nip'];
            $data['name']   = $result['name'];
            $data['late']   = $result['late'];
            $data['date']   = 'Bekasi, ' . os_date()->fullDate($lastDate, $month, $year, false);
            $filename       = $title . '_' . $year . '_'. time();
    
            $html = view('SiAbsen\Views\ekspor-rekap-individu', $data);
            // return $html;
            PDFCreator::create($html, $filename); 
        }
    }

    public function getDetailPresence($staffId, $userId, $period)
    {
        if(valid_token()) {
            if($staffId === 'null') {
                $staffId = $this->getStaffId();
            }
    
            if($userId === 'null') {
                $staffData = $this->getStaffData();
                $userId = $staffData->user_id;
            }
    
            return $this->response->setJSON($this->_getDetailPresence($staffId, $userId, $period));
        }
    }

    private function _getDetailPresence($staffId, $userId, $period)
    {
        $staffDetail = $this->model->getStaffDetail($userId)[0];
        $period = explode('-', $period);
        $summary = $this->countMonthlySummary($staffId, $staffDetail->staff_type, (int)$period[0], $period[1]);
        $wrapper = [];
        $presenceCategory = [
            get_lang('AdminAbsensi.absensi_alfa'),
            get_lang('AdminAbsensi.absensi_hadir'),
            get_lang('AdminAbsensi.absensi_izin'),
            '-'
        ];

        $totalLate = 0;

        foreach($summary as $key => $val) {
            $in = $this->model->getPresence($staffId, $key, 'masuk');
            $out = $this->model->getPresence($staffId, $key, 'pulang');
            $timein = $in !== null ? explode(' ', $in->presence_datetime)[1] : '-';
            $late = $this->countLate($key, $timein);
            $totalLate += $late['raw'];

            $wrapper[] = [
                'date'      => $key,
                'label'     => $presenceCategory[$val],
                'in'        => $timein,
                'out'       => $out !== null ? explode(' ', $out->presence_datetime)[1] : '-',
                'late'      => $timein !== '-' ? $late['str'] : '',
                'status'    => $val,
                'dateStr'   => os_date()->format('DD-MM-y', reverse($key, '-', '-'))
            ];
        }

        $response = [
            'nip'   => $staffDetail->staff_nik,
            'name'  => $staffDetail->staff_name,
            'data'  => $wrapper,
            'late'  => $this->formatTime($totalLate, 'm')
        ];

        return $response;
    }

    public function exportAllStaffSummary($period, $token)
    {
        if(valid_token($token)) {
            $data = [];        
            foreach($this->resources->getReportData($token) as $key => $val) {
                $data[$key] = $val;
            }

            $rows = $this->model->getStaffRows();
            $periodArr = explode('-', $period); // [ month, year ]
            $month = (int)$periodArr[0];
            $year = $periodArr[1];
            $lastDate = os_date()->daysInMonth($month, $year);
            
            $title          = 'Rekapitulasi Absensi Bulan ' . os_date()->getMonthName($month);
            $data['title']  = $title;
            $data['year']   = 'Tahun ' . $year;
            $data['data']   = $this->_getAllStaffSummary($period, $rows, 0, 'staff_name', 'staff_name', 'ASC', '');
            $data['date']   = 'Bekasi, ' . os_date()->fullDate($lastDate, $month, $year, false);
            $filename       = $title . '_' . $year . '_'. time();
    
            $html = view('SiAbsen\Views\ekspor-rekap-bulanan', $data);
            // return $html;
            PDFCreator::create($html, $filename); 
        }
    }

    public function getPermissionDetail($id)
    {
        return $this->createResponse($this->_getPermissionDetail($id));
    }

    protected function _getPermissionDetail($id)
    {
        $data = $this->model->getPermissionDetail($id);
        $data->permit_date = os_date()->format('D-M-Y', reverse($data->permit_date, '-', '-'), '-');
        $data->permit_starttime = substr($data->permit_starttime, 0, 5);
        $data->permit_endtime = substr($data->permit_endtime, 0, 5);

        return $data;
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
                'id'        => $e->staff_id,
                'user'      => $e->user_id,
                'absent'    => $this->filterPresence($data, 0),
                'present'   => $this->filterPresence($data, 1),
                'permit'    => $this->filterPresence($data, 2),
            ];
        }

        return $presenceSummary;
    }

    protected function countLate($date, $time, $timeFormat = 'm')
    {
        $timein = $this->config->presence_timein;
        $dateTimeIn = $date .' '. $time;
        $timeConfig = $date . ' ' . $timein;
        $timeinTimestamp = strtotime($dateTimeIn);
        $timeConfigTimestamp = strtotime($timeConfig);
        $diff = 0;
        if($timeinTimestamp > $timeConfigTimestamp) {
            $diff = $timeinTimestamp - $timeConfigTimestamp;
        }

        return [
            'raw'   => $diff,
            'str'   => $this->formatTime($diff, $timeFormat)
        ];
    }

    private function formatTime($diff, $displayFormat)
    {
        if($diff > 0) {
            $minutes = $diff / 60;
            $minutesFormat = number_format($minutes, 2, ',', '.');
            $minutesStr = ' '.get_lang('SiAbsen.siabsen_menit');
            $hours = $minutes / 60;
            $hoursFormat = number_format($hours, 2, ',', '.');
            $hoursStr = ' '.get_lang('SiAbsen.siabsen_jam');
            $secondsStr = ' '.get_lang('SiAbsen.siabsen_detik');
            $secondsDiff = ($minutes - floor($minutes)) * 60;
            $hm = floor($hours) . $hoursStr.' '.floor($minutes).$minutesStr;
            $ms = floor($minutes) . $minutesStr .' '. $secondsDiff . $secondsStr;
    
            $format = [
                'h'     => $hoursFormat . $hoursStr, // 1 hour | 1,233 hour
                'h:m'   => $hm, // 1 hour 32 minutes
                'h:m:s' => floor($hours) . $hoursStr .' '. $ms, // 1 hour 32 minutes 24 detik
                'm'     => $minutesFormat . $minutesStr, // 32,345 minutes
                'm:s'   => $ms, // 32 minutes 24 seconds
                's'     => $diff . $secondsStr // 3842 seconds
            ];        
    
            return $format[$displayFormat];
        } else {
            return '-';
        }
    }

    private function filterPresence($array, $status)
    {
        $result = count(array_filter($array, fn($v) => $v === $status));

        return $result > 0 ? $result : '-';
    }

    protected function countMonthlySummary($staffId, $staffType, $month, $year)
    {
        $presenceData = [];

        // get total days of the selected month
        $totalDays = os_date()->daysInMonth($month, $year);

        // walk through the days of month and look for absence data
        foreach(range(1, $totalDays) as $td) {
            // set the date into YYYY-MM-DD format
            $searchDate = reverse(os_date()->shortDate($td, $month, $year), '-', '-');

            $presenceData[$searchDate] = $this->getPresenceStatus($staffId, $staffType, $searchDate);
        }          

        return $presenceData;
    }

    protected function getPresenceStatus($staffId, $staffType, $date)
    {
        $dayValues = [];

        $schedules = $this->model->getPresenceSchedule($staffId);

        // get the day of week like 0 = sunday through 6 = saturday
        $dayOfWeek = date('w', strtotime($date));

        // match the day of week config
        // if $dayOfWeek is 0 (sunday), then convert it to 6
        // otherwise subtract one (eg. 1-1 = 0 for monday)
        $dayOfWeekMatch = $dayOfWeek === 0 ? 6 : $dayOfWeek - 1;
        $status = 3;

        // if day of week of the searched date is in teacher schedules...
        if(in_array($dayOfWeekMatch, $dayValues)) {
            // get only presence-in data
            // we do not need to check presence-out data, since teacher will only
            // be absent if they do not tap for presence-in
            $in = $this->model->getPresence($staffId, $date, 'masuk');

            // if it exists, it means the teacher was present on that date
            // pass the value with 1 = present, 0 = absent, 2 = permit
            $hasPermission = $this->model->hasPermissionToday($date, $staffId);
            if($in === null && $hasPermission) {
                $status = 2;
            } elseif($in === null && ! $hasPermission) {
                $status = 0;
            } else {
                $status = 1;
            }
        }

        return $status;
    }

    public function getStaffPresence($date, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $data = $this->model->getStaff($limit, $offset, $orderBy, $searchBy, $sort, 'null', $search);
        $rows = $this->model->getStaffRows($searchBy, 'null', $search);

        $wrapper = [];
        foreach($data as $key) {
            $in = $this->model->getPresence($key->staff_id, $date, 'masuk');
            $out = $this->model->getPresence($key->staff_id, $date, 'pulang');
            $timein = $in !== null ? explode(' ', $in->presence_datetime)[1] : '-';
            
            $wrapper[] = [
                'nip'       => $key->staff_nik,
                'name'      => $key->staff_name,
                'in'        => $timein,
                'out'       => $out !== null ? explode(' ', $out->presence_datetime)[1] : '-',
                'late'      => $timein !== '-' ? $this->countLate($date, $timein)['str'] : '-',
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

    protected function getStaffNik($token = '')
    {
        return $this->getStaffData()->staff_nik;
    }

    protected function getStaffId($token = '')
    {
        return $this->getStaffData()->staff_id;
    }

    private function getStaffData($token = '')
    {
        $user = $this->getDataPengguna($token);
        $staff = $this->model->getStaffDetail($user->user_id);

        return $staff[0];
    }

    public function saveConfig()
    {
        if(is_admin()) {
            $rules = [
                'intime'    => 'required|valid_date[H:i]',
                'outtime'   => 'required|valid_date[H:i]',
                'lat'       => 'required|decimal',
                'long'      => 'required|decimal',
                'tolerance' => 'required|is_natural|less_than_equal_to[120]',
                'range'     => 'required|is_natural'
            ];
    
            $messages = [
                'intime' => [
                    'required'          => get_lang('SiAbsen.siabsen_config_error.field_required'),
                    'valid_date'        => get_lang('SiAbsen.siabsen_permit_error.time_invalid'),
                ],
                'outtime' => [
                    'required'          => get_lang('SiAbsen.siabsen_config_error.field_required'),
                    'valid_date'        => get_lang('SiAbsen.siabsen_permit_error.time_invalid'),
                ],
                'lat' => [
                    'required'          => get_lang('SiAbsen.siabsen_config_error.field_required'),
                    'decimal'           => get_lang('SiAbsen.siabsen_config_error.integer_only'),
                ],
                'long' => [
                    'required'          => get_lang('SiAbsen.siabsen_config_error.field_required'),
                    'decimal'           => get_lang('SiAbsen.siabsen_config_error.integer_only'),
                ],
                'tolerance' => [
                    'required'          => get_lang('SiAbsen.siabsen_config_error.field_required'),
                    'is_natural'        => get_lang('SiAbsen.siabsen_config_error.numeric_only'),
                    'less_than_equal_to'=> get_lang('SiAbsen.siabsen_config_error.timelimit', [120]),
                ],
                'range' => [
                    'required'          => get_lang('SiAbsen.siabsen_config_error.field_required'),
                    'is_natural'        => get_lang('SiAbsen.siabsen_config_error.numeric_only'),
                ]
            ];
    
            if(! validate($rules, $messages)) {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            } else {
                $forms = [
                    'intime'    => $this->request->getPost('intime'),
                    'outtime'   => $this->request->getPost('outtime'),
                    'lat'       => $this->request->getPost('lat'),
                    'long'      => $this->request->getPost('long'),
                    'tolerance' => $this->request->getPost('tolerance'),
                    'range'     => $this->request->getPost('range'),
                ];

                $this->model->updateConfig(1, $forms);

                return $this->response->setJSON([
                    'code' => '200',
                    'msg' => 'Config has been updated',
                ]);
            }
        }
    }

    public function getFormattedConfig()
    {
        $presenceConfig = [
            'intime'    => substr($this->config->presence_timein, 0, 5),
            'outtime'   => substr($this->config->presence_timeout, 0, 5),
            'lat'       => $this->config->latitude,
            'long'      => $this->config->longitude,
            'tolerance' => $this->config->timelimit_allowed / 60,
            'range'     => $this->config->locationlimit_allowed
        ];

        return $this->createResponse($presenceConfig);
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
                'msg'   => get_lang('SiAbsen.siabsen_lokasi_valid')
            ];
        } else {
            $response = [
                'code'  => 500,
                'msg'   => get_lang('SiAbsen.siabsen_lokasi_invalid', [ $range ])
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