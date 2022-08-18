<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Kegiatan extends Admin
{
    public function getEvents($period)
    {
        if(valid_token()) {
            $period = reverse($period, '-', '-');
            $user = $this->getDataPengguna();
            $data = $this->kegiatan->getUserEvents((int)$user->user_id, $period);
            $formattedData = [];
            foreach($data as $d) {
                $start = explode(' ', $d->agenda_start);
                $end = explode(' ', $d->agenda_end);
                $startDate = $start[0];
                $endDate = $end[0];
                $startTime = $start[1];
                $endTime = $end[1];
                
                $rStartDate = reverse($startDate, '-', '-');
                $rEndDate = reverse($endDate, '-', '-');
                $time = $startTime .' - '. $endTime;
                $dateFormat = 'DD-MM-y';

                if($startDate === $endDate) {
                    $formattedData[] = [
                        'id'    => $d->agenda_id,
                        'date'  => os_date()->format($dateFormat, $rStartDate),
                        'name'  => $d->agenda_name,
                        'time'  => $time
                    ];
                } else {
                    $dayDiff = os_date()->diff($rStartDate, $rEndDate, 'num-only');

                    // this is current active date,
                    // here we will start to walk through the days..
                    $currentDate = $rStartDate;
                    for($i = 0; $i <= $dayDiff; $i++) {
                        $formattedData[] = [
                            'id'    => $d->agenda_id,
                            'date'  => os_date()->format($dateFormat, $currentDate),
                            'name'  => $d->agenda_name,
                            'time'  => $time
                        ];

                        $currentDate = os_date()->add($currentDate, 1);
                    }
                }
            }
    
            return $this->response->setJSON($formattedData);
        }
    }
}