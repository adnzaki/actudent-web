<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Pegawai extends Admin
{
    public function deletePermission()
    {
        if(valid_token()) {
            $id = $this->request->getPost('id');
            $detail = $this->_getPermissionDetail($id);
            if($detail->permit_status === 'submitted') {
                $this->aws->folder('staff-permit')->deleteObject($detail->permit_photo);
                $this->model->deletePermission($id);
                $response = ['status' => 200];
            } else {
                $response = ['status' => 500];
            }

            return $this->response->setJSON($response);
        }
    }
    public function getPermissions($withId, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        if(valid_token()) {
            if($withId === 'true') {
                $withId = $this->getStaffId();
            }

            $data = $this->model->getPermissions($limit, $offset, $search, $withId, $orderBy, $searchBy, $sort);

            return $this->response->setJSON([
                'container' => $data,
                'totalRows' => $this->model->getPermissionRows($withId),
            ]);
        }
    }

    public function sendPermitRequest()
    {
        if(valid_token()) {
            $validation = $this->permitValidation();
            if(! validate($validation[0], $validation[1])) {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            } else {
                $data = $this->formData();
                $this->model->insertPermit($data, $this->getStaffId());

                return $this->response->setJSON([
                    'code' => '200',
                    'msg' => 'Data submitted successfully',
                ]);
            }
        }
    }

    private function permitValidation()
    {
        $rules = [
            'permit_date'       => 'required|valid_date[Y-m-d]',
            'permit_starttime'  => 'required|valid_date[H:i]',
            'permit_endtime'    => 'required|valid_date[H:i]',
            'permit_presence'   => 'required',
            'permit_reason'     => 'required',
            'permit_photo'      => 'required',
        ];

        $messages = [
            'permit_date' => [
                'required'      => get_lang('SiAbsen.permit_date_required'),
                'valid_date'    => get_lang('SiAbsen.permit_date_invalid'),
            ],
            'permit_starttime' => [
                'required'      => get_lang('SiAbsen.permit_starttime_required'),
                'valid_date'    => get_lang('SiAbsen.permit_time_invalid'),
            ],
            'permit_endtime' => [
                'required'      => get_lang('SiAbsen.permit_endtime_required'),
                'valid_date'    => get_lang('SiAbsen.permit_time_invalid'),
            ],
            'permit_presence' => [
                'required'      => get_lang('SiAbsen.permit_type_required'),
            ],
            'permit_reason' => [
                'required'      => get_lang('SiAbsen.permit_reason_required'),
            ],'permit_photo' => [
                'required'      => get_lang('SiAbsen.permit_photo_required'),
            ]
        ];
        
        return [$rules, $messages];
    }
    
    private function formData()
    {
        return [
            'permit_date'       => $this->request->getPost('permit_date'),
            'permit_starttime'  => $this->request->getPost('permit_starttime'),
            'permit_endtime'    => $this->request->getPost('permit_endtime'),
            'permit_presence'   => $this->request->getPost('permit_presence'),
            'permit_reason'     => $this->request->getPost('permit_reason'),
            'permit_photo'      => $this->request->getPost('permit_photo'),
        ];
    }

    public function deleteUnusedPermitAttachment()
    {
        $url = $this->request->getPost('url');
        $this->aws->folder('staff-permit')->deleteObject($url);
        
        return $this->response->setJSON(['msg' => 'OK']);
    }

    public function uploadPermitAttachment()
    {
        if(valid_token()) {   
            if($this->validateFile()) {
                $attachment = $this->request->getFile('attachment');
                $newFilename = $attachment->getRandomName();
                $dirPath = PUBLICPATH . 'attachments/izin/';
                $filePath = $dirPath . $newFilename;
                $attachment->move($dirPath, $newFilename);
                \Config\Services::image()
                        ->withFile($filePath)
                        ->resize(1024, 1024, true)
                        ->save($filePath);
    
                $result = $this->aws->folder('staff-permit')->putObject($filePath);
                if(file_exists($filePath))
                {
                    unlink($filePath);
                }
                
                $response = [
                    'msg' => 'OK',
                    'img' => $result // get AWS object URL
                ];

                return $this->response->setJSON($response);
            } else {
                return $this->response->setJSON($this->validation->getErrors());
            }
        }
    }

    private function validateFile()
    {
        $fileRules = [
            'attachment' => 'is_image[attachment]'
        ];
        $fileMessages = [
            'attachment' => [
                'is_image' => get_lang('Admin.invalid_filetype'),
            ]
        ];

        return $this->validate($fileRules, $fileMessages);
    }

    public function sendPresence($tag)
    {
        if(valid_token()) {
            $position = $this->_validatePosition();
            if($position['code'] === 400) {
                $response = [
                    'code'      => 500,
                    'msg'       => get_lang('SiAbsen.siabsen_absen_gagal'),
                    'reason'    => $position['msg']
                ];
            } else {
                $data = [
                    'lat'   => $this->request->getPost('lat'),
                    'long'  => $this->request->getPost('long'),
                    'photo' => $this->request->getPost('photo'),
                ];

                if($this->getPresence(date('Y-m-d'), $tag) === null) {
                    $this->model->sendPresence($tag, $data, $this->getStaffId());
                }        
                
                $response = [
                    'code'      => 200,
                    'msg'       => get_lang('SiAbsen.siabsen_absen_berhasil'),
                ];
            }

            return $this->response->setJSON($response);
        }
    }

    public function uploadImage($tag)
    {
        if(valid_token()) {
            $attachment = $this->request->getPost('photo');
            $newFilename = date('Ymd').'_'.$this->getStaffNik().'_'.$tag.'.jpeg';
            $dirPath = PUBLICPATH . 'images/absensi/';
            file_put_contents($dirPath . $newFilename, base64_decode($attachment));
            
            $path = $dirPath . $newFilename;

            // upload to AWS S3...
            if($tag === 'agenda') {
                $result = $this->aws->folder('agenda-presence')->putObject($path);
            } else {
                $result = $this->aws->putObject($path);
            }

            if(file_exists($path))
            {
                unlink($path);
            }
            
            $response = [
                'msg' => 'OK',
                'img' => $result // get AWS object URL
            ];

            return $this->response->setJSON($response);
        }
    }

    public function outStatus()
    {
        if(valid_token()) {
            $currentDate = date('Y-m-d');
            $out = $this->getPresence($currentDate, 'pulang');
            $in = $this->getPresence($currentDate, 'masuk');
            $currentTime = $this->toDecimal(date('H:i:s'));
            $hasPermission = $this->model->hasPermissionToday($currentDate, $this->getStaffId());
            $dayOfWeek = $this->getDayOfWeek($currentDate);
            
            $checkSchedule = $this->model->scheduleExists($this->getStaffId(), $dayOfWeek);
            if(! $checkSchedule) {
                $status = get_lang('SiAbsen.siabsen_no_schedule_today');
                $canAbsent = 0; // unable to absent
            } else {
                if($in === null && $hasPermission) {
                    $status = get_lang('SiAbsen.siabsen_permit_prayer');
                    $canAbsent = 0; // unable to absent
                } else {
                    $todaySchedule = $this->model->getTodaySchedule($this->getStaffId(), $dayOfWeek);
                    $timeOut = $this->toDecimal($todaySchedule->schedule_timeout);
                    if($in === null && $currentTime < $timeOut) {
                        $status = get_lang('SiAbsen.siabsen_masuk_dulu');
                        $canAbsent = 0; // unable to absent
                    } else {
                        if($out === null && $currentTime > $timeOut) {
                            $status = get_lang('SiAbsen.siabsen_belum_pulang');
                            $canAbsent = 1; // able to absent
                        } elseif($out === null && $currentTime < $timeOut) {
                            $status = get_lang('SiAbsen.siabsen_belum_pulang');
                            $canAbsent = 0; // unable to absent
                        } else {
                            $status = get_lang('SiAbsen.siabsen_sudah_pulang');
                            $canAbsent = 0; // unable to absent
                        }
                    }
                }
            }


            $response = [
                'status'    => $status,
                'canAbsent' => $canAbsent,
                'timeOut'   => $out === null ? '-' : substr($out->presence_datetime, 11, 8)
            ];
    
            return $this->response->setJSON($response);    
        }
    }

    public function inStatus()
    {
        if(valid_token()) {
            $currentDate = date('Y-m-d');
            $presence = $this->getPresence($currentDate, 'masuk');
            $currentTime = $this->toDecimal(date('H:i:s'));            
            $todayLimit = $this->toDecimal('23:59:00');
            $isLate = 0;
            $hasPermission = $this->model->hasPermissionToday($currentDate, $this->getStaffId());
            $dayOfWeek = $this->getDayOfWeek($currentDate);

            $checkSchedule = $this->model->scheduleExists($this->getStaffId(), $dayOfWeek);
            if(! $checkSchedule) {
                $status = get_lang('SiAbsen.siabsen_no_schedule_today');
                $canAbsent = 0; // unable to absent
            } else {
                if($presence === null && $hasPermission) {
                    $status = get_lang('SiAbsen.siabsen_permit_approved');
                    $canAbsent = 0; // unable to absent
                } else {
                    // get today schedule                       
                    $todaySchedule = $this->model->getTodaySchedule($this->getStaffId(), $dayOfWeek);
                    $timeOut = $this->toDecimal($todaySchedule->schedule_timeout);

                    if($presence === null && $currentTime > $timeOut && $currentTime < $todayLimit) {
                        $status = get_lang('SiAbsen.siabsen_tidak_masuk');
                        $canAbsent = 0; // unable to absent
                    } else {
                        if($presence === null) {
                            $status = get_lang('SiAbsen.siabsen_belum_masuk');
                            $canAbsent = 1; // able to absent
                        } else {     
                            // get today presence data
                            $datetime = explode(' ', $presence->presence_datetime);

                            // check the schedule timein compared to snapshot
                            $snapshot = $this->model->getSnapshot($this->getStaffId(), $datetime[0]);
                            $timeIn = $this->toDecimal($snapshot->snapshot_timein);

                            // get late tolerance
                            $timeLimit = $this->config->timelimit_allowed / 60 / 60;
                            
                            $presenceIn = $this->toDecimal($datetime[1]);

                            // get time limit for counting lateness
                            $ontimeLimit = $timeIn + $timeLimit;
                
                            if($presenceIn > $ontimeLimit) {
                                $late = $this->countLate($this->getStaffId(), $datetime[0], $datetime[1]);
                                $status = get_lang('SiAbsen.siabsen_telat_masuk', [$late['str']]);
                            } else {
                                $status = get_lang('SiAbsen.siabsen_sudah_masuk');
                            }
            
                            $canAbsent = 0; // unable to absent
                            if($presenceIn > $ontimeLimit) {
                                $isLate = 1;
                            }
                        }
                    }
                }
            }            

            $response = [
                'status'    => $status,
                'canAbsent' => $canAbsent,
                'late'      => $isLate,
                'timeIn'    => $presence === null ? '-' : substr($presence->presence_datetime, 11, 8)
            ];
    
            return $this->response->setJSON($response);
        }
    }

    public function getDailySchedule()
    {
        if(valid_token()) {
            $schedule = $this->_getDailySchedule($this->getStaffId(), date('Y-m-d'));
            if($schedule === null) {
                $response = [
                    'schedule_timein' => '-',
                    'schedule_timeout' => '-'
                ];
            } else {
                $response = $schedule;
            }
    
            return $this->response->setJSON($response);
        }
    }
}