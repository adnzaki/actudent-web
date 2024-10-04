<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use PDFCreator;

class Admin extends \Actudent
{
    protected $model;

    protected $config;

    protected $aws;

    protected $kegiatan;

    private $days = [
        'senin' => 0, 'selasa' => 1, 'rabu' => 2,
        'kamis' => 3, 'jumat' => 4, 'sabtu' => 5,
        'minggu' => 6
    ];

    public function __construct()
    {
        $this->model = new \SiAbsen\Models\CoreModel;
        $this->kegiatan = new \SiAbsen\Models\KegiatanModel;
        $this->config = $this->model->getConfig();
        $this->aws = new \AwsClient;
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
        $employees = $this->model->getStaff('null', $limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->model->getStaffRows('null', $searchBy, $search);

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
        $employees = $this->model->getStaff('null', $rows, 0);
        $summary = [];
        foreach($employees as $e) {
            $summary[$e->staff_name] = $this->getPresenceStatus($e->staff_id, date('Y-m-d'));
        }

        $countStatus = function ($type) use ($summary) {
            return count(array_filter($summary, fn($v) => $v === $type));
        };

        return $this->createResponse([
            'absent'    => $countStatus(0),
            'present'   => $countStatus(1),
            'permit'    => $countStatus(2),
            'recent'    => $this->model->getRecentPresence()
        ]);
    }

    public function exportStaffSummary($staffId, $userId, $startDate, $endDate, $token)
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

            $periodStart = os_date()->format('d-MM-y', reverse($startDate, '-', '-'));
            $periodEnd = os_date()->format('d-MM-y', reverse($endDate, '-', '-'));
            $result = $this->_getDetailPresence($staffId, $userId, $startDate, $endDate);
            $splitEndDate = explode('-', $endDate);
            $printDate = os_date()->create("{$splitEndDate[0]}-{$splitEndDate[1]}-21");

            $title          = 'Rekap Absensi ' .$result['name'];
            $data['title']  = $title;
            $data['period'] = 'Periode '.$periodStart.' sd. '.$periodEnd;
            $data['data']   = $result['data'];
            $data['nip']    = $result['nip'];
            $data['name']   = $result['name'];
            $data['late']   = $result['late'];
            $data['work']   = $result['work'];
            $data['over']   = $result['over'];
            $data['alfa']   = $result['absent'];
            $data['hadir']  = $result['present'];
            $data['izin']   = $result['permit'];
            $data['date']   = 'Bekasi, ' . $printDate;
            $filename       = $title . ' ' . $data['period'];

            $html = view('SiAbsen\Views\ekspor-rekap-individu', $data);
            // return $html;
            PDFCreator::create($html, $filename);
        }
    }

    public function getDetailPresence($staffId, $userId, $startDate, $endDate)
    {
        if(valid_token()) {
            if($staffId === 'null') {
                $staffId = $this->getStaffId();
            }

            if($userId === 'null') {
                $staffData = $this->getStaffData();
                $userId = $staffData->user_id;
            }

            return $this->response->setJSON($this->_getDetailPresence($staffId, $userId, $startDate, $endDate));
        }
    }

    private function _getDetailPresence($staffId, $userId, $startDate, $endDate)
    {
        $staffDetail = $this->model->getStaffDetail($userId)[0];
        $summary = $this->getMonthlyPresence($staffId, $startDate, $endDate);
        $wrapper = [];
        $presenceCategory = [
            'alfa'  => get_lang('AdminAbsensi.absensi_alfa'),
            'hadir' => get_lang('AdminAbsensi.absensi_hadir'),
            'izin'  => get_lang('AdminAbsensi.absensi_izin'),
            '0'     => '-',
            'wajib' => '-',
        ];

        $totalLate = array_sum(array_column($summary, 'late_in_minute'));
        $totalWork = array_sum(array_column($summary, 'work_in_minute'));
        $totalOvertime = array_sum(array_column($summary, 'overtime_in_minute'));

        foreach($summary as $key) {
            $late = $key['late_in_minute'] !== '0'
                    ? $key['late_in_minute'] .' '. get_lang('SiAbsen.siabsen_menit')
                    : '-';

            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $ds = $this->model->getSnapshot($staffId, $key['date']);
            $snapshotTimeoutDecimal = 0;
            if($ds !== null) {
                $snapshotTimeoutDecimal = strtotime($ds->snapshot_date .' '. $ds->snapshot_timeout);
            }

            $work = $key['work_in_minute'] !== '0' && $currentTime > $snapshotTimeoutDecimal
                    ? $key['work_in_minute'] .' '. get_lang('SiAbsen.siabsen_menit')
                    : '-';

            $over = $key['overtime_in_minute'] !== '0'
                    ? $key['overtime_in_minute'] .' '. get_lang('SiAbsen.siabsen_menit')
                    : '-';

            $wrapper[] = [
                'date'      => $key['date'],
                'label'     => $presenceCategory[$key['status_day']],
                'in'        => empty($key['timein']) ? '-' : $key['timein'],
                'out'       => empty($key['timeout']) ? '-' : $key['timeout'],
                'late'      => $late,
                'work'      => $work,
                'over'      => $over,
                'required'  => $key['required_day'],
                'status'    => $key['status_day'],
                'dateStr'   => os_date()->format('DD-MM-y', reverse($key['date'], '-', '-'))
            ];
        }

        $monthlyStatus = array_column($summary, 'status_day');
        $totalTime = function($time) {
            return $time > 0
                    ? number_format($time, 0, ',', '.') .' '. get_lang('SiAbsen.siabsen_menit')
                    : '-';
        };

        $accumulation = ceil($totalWork / (8 * 60));

        $response = [
            'nip'       => $staffDetail->staff_nik,
            'name'      => $staffDetail->staff_name,
            'late'      => $totalTime($totalLate),
            'work'      => $totalTime($totalWork),
            'over'      => $totalTime($totalOvertime),
            'absent'    => $this->filterPresence($monthlyStatus, 'alfa'),
            'present'   => $this->filterPresence($monthlyStatus, 'hadir'),
            'permit'    => $this->filterPresence($monthlyStatus, 'izin'),
            'accumulation'  => $accumulation > 0 ? $accumulation : '-',
            'data'      => $wrapper,
        ];

        return $response;
    }

    public function exportAllStaffSummary($startDate, $endDate, $type, $token)
    {
        if(valid_token($token)) {
            $data = [];
            foreach($this->resources->getReportData($token) as $key => $val) {
                $data[$key] = $val;
            }

            $rows = $this->model->getStaffRows();
            $periodStart = os_date()->format('d-MM-y', reverse($startDate, '-', '-'));
            $periodEnd = os_date()->format('d-MM-y', reverse($endDate, '-', '-'));
            $splitEndDate = explode('-', $endDate);
            $printDate = os_date()->create("{$splitEndDate[0]}-{$splitEndDate[1]}-21");

            $title          = 'Rekapitulasi Absensi';
            $data['title']  = $title;
            $data['period'] = 'Periode '.$periodStart.' sd. '.$periodEnd;
            $data['data']   = $this->_getAllStaffSummary($startDate, $endDate, $type, $rows, 0, 'staff_name', 'staff_name', 'ASC', '');
            $data['date']   = 'Bekasi, ' . $printDate;
            $filename       = $title . '_' . $data['period']. '_'. time();

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
		$data->permit_date_str = os_date()->create($data->permit_date, 'D-M-Y', '-');
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

    public function getIndividualSummary($startDate, $endDate, $staffId = '')
    {
        if(valid_token()) {
            return $this->response->setJSON($this->_getIndividualSummary($startDate, $endDate, $staffId));
        }
    }

    private function _getIndividualSummary($startDate, $endDate, $staffId)
    {
        if(empty($staffId)) {
            $staffId = $this->getStaffId();
        }

        return $this->getMonthlyPresence($staffId, $startDate, $endDate);
    }

    public function getAllStaffSummary($startDate, $endDate, $type, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        if(is_admin()) {
            $data = $this->_getAllStaffSummary($startDate, $endDate, $type, $limit, $offset, $orderBy, $searchBy, $sort, $search);
            return $this->response->setJSON([
                'totalRows' => $this->model->getStaffRows($type, 'staff_name', $search),
                'container' => $data
            ]);
        }
    }

    private function _getAllStaffSummary($startDate, $endDate, $type, $limit, $offset, $orderBy, $searchBy, $sort, $search)
    {
        $employees = $this->model->getStaff($type, $limit, $offset, $orderBy, $searchBy, $sort, $search);
        $presenceSummary = [];
        foreach($employees as $e) {
            $data = $this->getMonthlyPresence($e->staff_id, $startDate, $endDate);
            $monthlyStatus = array_column($data, 'status_day');
            $presenceSummary[] = [
                'name'      => $e->staff_name,
                'nip'       => $e->staff_nik,
                'id'        => $e->staff_id,
                'user'      => $e->user_id,
                'absent'    => $this->filterPresence($monthlyStatus, 'alfa'),
                'present'   => $this->filterPresence($monthlyStatus, 'hadir'),
                'permit'    => $this->filterPresence($monthlyStatus, 'izin'),
            ];
        }

        return $presenceSummary;
    }

    protected function countLate($staffId, $date, $time, $timeFormat = 'm')
    {
        $dailySchedule = $this->model->getSnapshot($staffId, $date);
        $timein = $dailySchedule->snapshot_timein;
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

    protected function _getDailySchedule($staffId, $date)
    {
        $schedule = $this->model->getPresenceSchedule($staffId, $this->getDayOfWeek($date));

        return $schedule === null ? null : $schedule[0];
    }

    private function formatTime($diff, $displayFormat, $useDecimal = true)
    {
        if($diff > 0) {
            $decimalPlaces = $useDecimal ? 2 : 0;
            $minutes = $diff / 60;
            $minutesFormat = number_format($minutes, $decimalPlaces, ',', '.');
            $minutesStr = ' '.get_lang('SiAbsen.siabsen_menit');
            $hours = $minutes / 60;
            $hoursFormat = number_format($hours, $decimalPlaces, ',', '.');
            $hoursStr = ' '.get_lang('SiAbsen.siabsen_jam');
            $secondsStr = ' '.get_lang('SiAbsen.siabsen_detik');
            $secondsDiff = ($minutes - floor($minutes)) * 60;
            $modHour = ($hours - floor($hours)) * 60;
            $hm = floor($hours) . $hoursStr.' '. round($modHour) .$minutesStr;
            $ms = floor($minutes) . $minutesStr .' '. round($secondsDiff) . $secondsStr;

            $format = [
                'h'     => $hoursFormat . $hoursStr, // 1 hour | 1,233 hour
                'h:m'   => $hm, // 1 hour 32 minutes
                'h:m:s' => floor($hours) . $hoursStr .' '. floor($modHour) .$minutesStr.' '. round($secondsDiff) .$secondsStr, // 1 hour 32 minutes 24 detik
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

    protected function getMonthlyPresence($staffId, $startDate, $endDate)
    {
        $presenceData = $this->model->getMonthlyPresence($staffId, $startDate, $endDate);

        return $presenceData !== null ? $presenceData : [];
    }

    protected function getPresenceStatus($staffId, $date)
    {
        $dayValues = [];

        $schedules = $this->model->getPresenceSchedule($staffId);
        if($schedules !== null) {
            $dayValues = array_column($schedules, 'schedule_day');
        }

        $status = 3;

        // if day of week of the searched date is in teacher schedules...
        if(in_array($this->getDayOfWeek($date), $dayValues)) {
            // get only presence-in data
            // we do not need to check presence-out data, since teacher will only
            // be absent if they do not tap for presence-in
            $presence = $this->model->getPresence($staffId, $date, 'masuk');
            if($presence === null) {
                $presence = $this->model->getPresence($staffId, $date, 'pulang');
            }

            // if it exists, it means the teacher was present on that date
            // pass the value with 1 = present, 0 = absent, 2 = permit
            $hasPermission = $this->model->hasPermissionToday($date, $staffId);
            if($presence === null && $hasPermission) {
                $status = 2;
            } elseif($presence === null && ! $hasPermission) {
                $status = 0;
            } else {
                $status = 1;
            }
        }

        return $status;
    }

    protected function getDayOfWeek(string $date)
    {
        // get the day of week like 0 = sunday through 6 = saturday
        $dayOfWeek = date('w', strtotime($date));

        // match the day of week config
        // if $dayOfWeek is 0 (sunday), then convert it to 6
        // otherwise subtract one (eg. 1-1 = 0 for monday)
        return $dayOfWeek === 0 ? 6 : $dayOfWeek - 1;
    }

    public function getStaffPresence($filter, $date, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        $day = $this->getDayOfWeek($date);
        $data = $this->model->getTodayStaffPresence($filter, $day, $limit, $offset, $orderBy, $searchBy, $sort, $search);
        $rows = $this->model->getTodayStaffPresenceRows($filter, $day, $searchBy, $search);

        $wrapper = [];
        foreach($data as $key) {
            $in = $this->model->getPresence($key->staff_id, $date, 'masuk');
            $out = $this->model->getPresence($key->staff_id, $date, 'pulang');
            $timein = $in !== null ? explode(' ', $in->presence_datetime)[1] : '-';
            $timeout = $out !== null ? explode(' ', $out->presence_datetime)[1] : '-';
            $dailySchedule = $this->model->getSnapshot($key->staff_id, $date);

            // use this magic method!
            $worktime = $this->formatWorkTime($timein, $timeout, $dailySchedule);

            $wrapper[] = [
                'nip'           => $key->staff_nik,
                'name'          => $key->staff_name,
                'in'            => $timein,
                'out'           => $timeout,
                'late'          => $timein !== '-' ? $this->countLate($key->staff_id, $date, $timein)['str'] : '-',
                'inPhoto'       => $in !== null ? $in->presence_photo : '-',
                'outPhoto'      => $out !== null ? $out->presence_photo : '-',
                'minWorkTime'   => $this->formatTime($worktime['minWorkTime'], 'm', false),
                'workTime'      => $this->formatTime($worktime['worktime'], 'm', false),
                'overtime'      => $this->formatTime($worktime['overtime'], 'm', false),
                'scheduled'     => $worktime['scheduled'],
            ];
        }

        return $this->createResponse([
            'totalRows' => $rows,
            'container' => $wrapper
        ], 'is_admin');
    }

    protected function formatWorkTime($timein, $timeout, $ds)
    {
        $minWorkTime = 0; // default minimum work time if there is no schedule on the selected day
        $workTime = 0;
        $snapshot = [
            'timein'    => '--:--:--',
            'timeout'   => '--:--:--',
        ];

        // $ds = daily schedule
        if($ds !== null) {
            $snapshot = [
                'timein'    => $ds->snapshot_timein,
                'timeout'   => $ds->snapshot_timeout,
            ];

            $minWorkTime = $this->getWorkTime($ds->snapshot_timein, $ds->snapshot_timeout, 'raw');
            $workTime = $this->getWorkTime($ds->snapshot_timein, $ds->snapshot_timeout, 'raw');
            $timeinDecimal = $this->toDecimal($timein);
            $snapshotTimeinDecimal = $this->toDecimal($ds->snapshot_timein);
            $timeoutTimestamp = strtotime($ds->snapshot_date .' '. $ds->snapshot_timeout);

            $currentTime = strtotime(date('Y-m-d H:i:s'));
            if($currentTime < $timeoutTimestamp) {
                $workTime = 0;
            } else {
                // if an employee come late, then their working time is counted from presence-in to snapshot_timeout
                if($timeinDecimal > $snapshotTimeinDecimal) {
                    $workTime = $this->getWorkTime($timein, $ds->snapshot_timeout, 'raw');
                }

                // if an employee tap for presence-in or out only,
                // then their work time is a half of range from minimum work time
                if($timein === '-' && $timeout !== '-' || $timein !== '-' && $timeout === '-') {
                    $workTime = $minWorkTime / 2;
                }
            }

        }

        $overtime = 0;
        if($ds !== null && $timeout !== '-') {
            $timeoutSnapshot = $this->toDecimal($ds->snapshot_timeout);
            $presenceTimeout = $this->toDecimal($timeout);
            if($presenceTimeout > $timeoutSnapshot) {
                $overtime = ($presenceTimeout - $timeoutSnapshot) * 60 * 60;
            }
        }

        return [
            'worktime'      => $workTime,
            'overtime'      => $overtime,
            'minWorkTime'   => $minWorkTime,
            'scheduled'     => $snapshot
        ];
    }

    protected function getWorkTime($workStart, $workEnd, $format = 'm')
    {
        $workStart = $this->toDecimal($workStart);
        $workEnd = $this->toDecimal($workEnd);
        $workTime = $workEnd - $workStart;
        $result = $workTime * 60 * 60;

        return $format === 'raw' ? $result : $this->formatTime($result, $format);
    }

    protected function getPresence($date, $tag)
    {
        $presence = $this->model->getPresence($this->getStaffId(), $date, $tag);

        return $presence;
    }

    protected function toDecimal($time)
    {
        // ensure that $time has the correct time format
        if(strpos($time, ':') !== false) {
            $timeArr = explode(':', $time);
            $hours = intval($timeArr[0]);
            $minutes = intval($timeArr[1]) / 60;
            $seconds = 0;

            if(count($timeArr) > 2) {
                $seconds = intval($timeArr[2]) / 60 / 60;
            }

            return $hours + $minutes + $seconds;
        } else {
            return 0;
        }
    }

    protected function getStaffNik($token = '')
    {
        return $this->getStaffData()->staff_nik;
    }

    protected function getStaffId($token = '')
    {
        return $this->getStaffData()->staff_id;
    }

    protected function getStaffData($token = '')
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
