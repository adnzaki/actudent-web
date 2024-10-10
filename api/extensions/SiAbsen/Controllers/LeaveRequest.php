<?php namespace SiAbsen\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

class LeaveRequest extends Admin
{
	private $school, $formGenerator;

    public function __construct()
    {
		parent::__construct();
        $this->leaveRequest = new \SiAbsen\Models\LeaveRequestModel;
        $this->school = new \Actudent\Core\Models\SekolahModel;
        $this->formGenerator = new \FormGenerator;
    }

    public function getLeaveRequest($withId, $limit, $offset, $orderBy, $searchBy, $sort, $search = '')
    {
        if(!valid_token()){
            return $this->response->setJSON([
                'message' => 'Not Found'
            ]);
        }

        if($withId === 'true') {
            $withId = $this->getStaffData()->staff_id;
        }
        $data = $this->leaveRequest->getLeaveRequest($limit, $offset, $search, $withId, $orderBy, $searchBy, $sort);

        return $this->response->setJSON([
            'container' => $data,
            'totalRows' => $this->leaveRequest->getLeaveRequestRows($withId),
        ]);
    }

    function createLeaveRequest(){
        if(valid_token()) {
            $validation = $this->formValidation();
            if(!validate($validation[0], $validation[1])) {
                return $this->response->setJSON([
                    'code' => '500',
                    'msg' => $this->validation->getErrors(),
                ]);
            } else {
                // return $this->response->setJSON([
                //     'code' => '200',
                //     'msg' => 'Data submitted successfully',
                //     'token' => bearer_token(),
                // ]);
                $data = $this->formData();
                $data['status'] = 'SUBMITTED';
                $data['staff_id'] = $this->getStaffId();
                $leaveId = $this->leaveRequest->insertLeaveRequest($data);
                $this->createAttachmentForm($leaveId);

                return $this->response->setJSON([
                    'code' => '200',
                    'msg' => 'Data submitted successfully',
                    'id' => $leaveId
                ]);
            }
        }
    }


    public function downloadFormTemplate(){
        $filePath = SIABSEN_PATH . 'Assets\form_cuti_v1.pdf';
        return $this->response->download($filePath, null);
    }

    public function createAttachmentForm($leaveId)
    {
        $leaveData = $this->leaveRequest->getLeaveRequestById($leaveId);
        if(empty($leaveData)) {
            return $this->response->setJSON([
                'message' => 'Not Found'
            ]);
        }

        $schoolData = $this->school->getDataSekolah();
        if(empty($schoolData)) {
            return $this->response->setJSON([
                'message' => 'Not Found'
            ]);
        }
        $leaveData['school_name'] = $schoolData[0]->school_name;
        $pathFile = $this->formGenerator->CreateForm($leaveData);

        $data = ['attachment' => $pathFile];
        $this->leaveRequest->updateLeaveRequest($data, $leaveData['leave_id']);

        return $this->response->setJSON([
            'message' => 'OK',
            'data' => $leaveData
        ]);
    }

    private function formValidation()
    {
        $rules = [
            'leave_type'       => 'required',
            'start_date'       => 'required|valid_date[Y-m-d]',
            'end_date'       => 'required|valid_date[Y-m-d]',
            'reason'        => 'required',
            'working_period'        => 'required',
            'working_period_label'        => 'required',
            'address'               => 'required',
            'phone_number'        => 'required',
        ];

        $messages = [
            'leave_type' => [
                'required'      => 'Kolom jenis cuti tidak boleh kosong',
            ],
            'start_date' => [
                'required'      => 'Kolom tanggal cuti tidak boleh koson',
                'valid_date'    => get_lang('SiAbsen.permit_date_invalid'),
            ],
            'end_date' => [
                'required'      => 'Kolom tanggal cuti tidak boleh koson',
                'valid_date'    => get_lang('SiAbsen.permit_date_invalid'),
            ],
            'reason' => [
                'required'      => 'Kolom alasan tidak boleh kosong'
            ],
            'working_period' => [
                'required'      => 'Kolom lama bekerja tidak boleh kosong'
            ],
            'working_period_label' => [
                'required'      => 'Kolom lama bekerja tidak boleh kosong'
            ],
            'address' => [
                'required'      => 'Kolom alamat tidak boleh kosong'
            ],
            'phone_number' => [
                'required'      => 'Kolom nomor telepon tidak boleh kosong'
            ],
        ];

        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'leave_type'       => $this->request->getPost('leave_type'),
            'start_date'  => $this->request->getPost('start_date'),
            'end_date'    => $this->request->getPost('end_date'),
            'reason'   => $this->request->getPost('reason'),
            'working_period'     => $this->request->getPost('working_period'),
            'working_period_label'      => $this->request->getPost('working_period_label'),
            'address'      => $this->request->getPost('address'),
            'phone_number'      => $this->request->getPost('phone_number'),
        ];
    }

}
