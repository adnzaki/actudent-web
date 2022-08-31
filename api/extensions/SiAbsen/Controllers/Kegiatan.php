<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Kegiatan extends Pegawai
{
    public function sendAgendaPresence($agendaId)
    {
        if(valid_token()) {
            $position = $this->_validatePosition();
            if($position['code'] === 500) {
                $response = [
                    'code'      => 500,
                    'msg'       => get_lang('SiAbsen.siabsen_absen_gagal'),
                    'reason'    => $position['msg'] 
                ]; 
            } else { 
                $data = [ 
                    'agenda'    => $agendaId,
                    'user'      => $this->getUserId(),
                    'datetime'  => date('Y-m-d H:i:s'),
                    'lat'       => $this->request->getPost('lat'),
                    'long'      => $this->request->getPost('long'),
                    'photo'     => $this->request->getPost('photo'),
                ];

                $this->kegiatan->insertPresence($data);
                
                $response = [
                    'code'      => 200,
                    'msg'       => get_lang('SiAbsen.siabsen_absen_berhasil'),
                ];
            }

            return $this->response->setJSON($response);
        }
    }

    public function getEvents($period)
    {
        if(valid_token()) {
            $period = reverse($period, '-', '-');
            $data = $this->kegiatan->getUserEvents($this->getUserId(), $period);
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
                $time = substr($startTime, 0, 5) .' - '. substr($endTime, 0, 5);
                $dateFormat = 'DD-MM-y';

                if($startDate === $endDate) {
                    $formattedData[] = [
                        'id'        => $d->agenda_id,
                        'date'      => os_date()->format($dateFormat, $rStartDate),
                        'name'      => $d->agenda_name,
                        'time'      => $time,
                        'priority'  => $d->agenda_priority,
                        'canPresent'=> $this->canPresent($d->agenda_id, $d->agenda_start, $d->agenda_end)
                    ];
                } else {
                    $dayDiff = os_date()->diff($rStartDate, $rEndDate, 'num-only');

                    // this is current active date,
                    // here we will start to walk through the days..
                    $currentDate = $rStartDate;
                    for($i = 0; $i <= $dayDiff; $i++) {
                        $dateTimeRaw = reverse($currentDate, '-', '-') .' '. $startTime;

                        $formattedData[] = [
                            'id'        => $d->agenda_id,
                            'date'      => os_date()->format($dateFormat, $currentDate),
                            'name'      => $d->agenda_name,
                            'time'      => $time,
                            'priority'  => $d->agenda_priority,
                            'canPresent'=> $this->canPresent($d->agenda_id, $dateTimeRaw, $d->agenda_end)
                        ];

                        $currentDate = os_date()->add($currentDate, 1);
                    }
                }
            }
    
            return $this->response->setJSON($formattedData);
        }
    }

    private function canPresent($id, $start, $end)
    {
        if(valid_token()) {
            $currentDateTime = strtotime(date('Y-m-d H:i:s'));
            $startDate = strtotime($start);
            $endDate = strtotime($end);
            $today = date('Y-m-d');
            $eventDate = explode(' ', $start)[0];
            
            if($this->kegiatan->presenceExists($id, $this->getUserId())) {
                return 'present';
            } else {
                if($today === $eventDate 
                    && ($startDate - $currentDateTime) <= 1800
                    && $currentDateTime < $endDate) {
                    return 1;
                } else {            
                    $status = 'not_started';
        
                    if($currentDateTime > $endDate) {
                        $status = 'ended';
                    }
        
                    return $status;
                }
            }
        }
    }

    private function getUserId()
    {
        $user = $this->getDataPengguna();

        return (int)$user->user_id;
    }
}