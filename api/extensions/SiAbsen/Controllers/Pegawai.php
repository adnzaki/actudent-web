<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class Pegawai extends Admin
{
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
            'permit_reason'     => 'required',
            'permit_photo'      => 'required',
        ];

        $messages = [
            'permit_date' => [
                'required'      => lang('SiAbsen.siabsen_permit_error.date_required'),
                'valid_date'    => lang('SiAbsen.siabsen_permit_error.date_invalid'),
            ],
            'permit_starttime' => [
                'required'      => lang('SiAbsen.siabsen_permit_error.starttime_required'),
                'valid_date'    => lang('SiAbsen.siabsen_permit_error.time_invalid'),
            ],
            'permit_endtime' => [
                'required'      => lang('SiAbsen.siabsen_permit_error.endtime_required'),
                'valid_date'    => lang('SiAbsen.siabsen_permit_error.time_invalid'),
            ],
            'permit_reason' => [
                'required'      => lang('SiAbsen.siabsen_permit_error.reason_required'),
            ],'permit_photo' => [
                'required'      => lang('SiAbsen.siabsen_permit_error.photo_required'),
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
            'attachment' => 'is_image[attachment]|max_size[attachment,1024]'
        ];
        $fileMessages = [
            'attachment' => [
                'is_image' => lang('Admin.invalid_filetype'),
                'max_size' => lang('Admin.file_too_large'),
            ]
        ];

        return $this->validate($fileRules, $fileMessages);
    }

    public function sendPresence($tag)
    {
        if(valid_token()) {
            $position = $this->_validatePosition();
            if($position['code'] === 500) {
                $response = [
                    'code'      => 500,
                    'msg'       => lang('SiAbsen.siabsen_absen_gagal'),
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
                    'msg'       => lang('SiAbsen.siabsen_absen_berhasil'),
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
            $result = $this->aws->putObject($path);
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
            $timeOut = $this->toDecimal($this->config->presence_timeout);
            $hasPermission = $this->model->hasPermissionToday($currentDate, $this->getStaffId());

            if($in === null && $hasPermission) {
                $status = lang('SiAbsen.siabsen_permit_prayer');
                $canAbsent = 0; // unable to absent
            } else {
                if($in === null && $currentTime < $timeOut) {
                    $status = lang('SiAbsen.siabsen_masuk_dulu');
                    $canAbsent = 0; // unable to absent
                } elseif($in === null && $currentTime > $timeOut) {
                    $status = lang('SiAbsen.siabsen_besok_absen');
                    $canAbsent = 0; // unable to absent
                } else {
                    if($out === null && $currentTime > $timeOut) {
                        $status = lang('SiAbsen.siabsen_belum_pulang');
                        $canAbsent = 1; // able to absent
                    } elseif($out === null && $currentTime < $timeOut) {
                        $status = lang('SiAbsen.siabsen_belum_pulang');
                        $canAbsent = 0; // unable to absent
                    } else {
                        $status = lang('SiAbsen.siabsen_sudah_pulang');
                        $canAbsent = 0; // unable to absent
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
            $timeOut = $this->toDecimal($this->config->presence_timeout);
            $todayLimit = $this->toDecimal('23:59:00');
            $isLate = 0;
            $hasPermission = $this->model->hasPermissionToday($currentDate, $this->getStaffId());
            
            if($presence === null && $hasPermission) {
                $status = lang('SiAbsen.siabsen_permit_approved');
                $canAbsent = 0; // unable to absent
            } else {
                if($presence === null && $currentTime > $timeOut && $currentTime < $todayLimit) {
                    $status = lang('SiAbsen.siabsen_tidak_masuk');
                    $canAbsent = 0; // unable to absent
                } else {
                    if($presence === null) {
                        $status = lang('SiAbsen.siabsen_belum_masuk');
                        $canAbsent = 1; // able to absent
                    } else {
                        
                        $timeIn = $this->toDecimal($this->config->presence_timein);
                        $timeLimit = $this->config->timelimit_allowed / 60 / 60;
                        $datetime = explode(' ', $presence->presence_datetime);
                        $presenceIn = $this->toDecimal($datetime[1]);
                        $ontimeLimit = $timeIn + $timeLimit;
            
                        if($presenceIn > $ontimeLimit) {
                            $status = lang('SiAbsen.siabsen_telat_masuk');
                        } else {
                            $status = lang('SiAbsen.siabsen_sudah_masuk');
                        }
        
                        $canAbsent = 0; // unable to absent
                        if($presenceIn > $ontimeLimit) {
                            $isLate = 1;
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
}