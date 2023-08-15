<?php namespace Actudent\Installer\Controllers;

use Actudent\Installer\Models\OrganizationModel;

class Setup extends \Actudent
{
    public function checkInstallation()
    {
        $org = new OrganizationModel;
        $check = $org->hasInstallation() ? 1 : 0;

        return $this->response->setJSON(['status' => $check]);
    }

    public function createOrganization()
    {     
        $token = $this->request->getPost('token');

        if(password_verify($token, env('installation_token'))) {
            $uri = new \CodeIgniter\HTTP\URI(base_url());
            $data = [
                'organization_name'         => $this->request->getPost('organization_name'),
                'organization_origination'  => $uri->getHost(),
            ];


            $org = new OrganizationModel;
            $org->addSubscription($this->request->getPost('subscription_type'), $org->insertOrganization($data));
            $org->insertSchool($data);
            $org->addDatabaseName($this->request->getPost('database_name'));
            $org->addAdmin();
            $org->addInstallation();

            $response = [
                'status'    => 'success',
                'msg'       => 'Actudent installation completed. Redirecting to login page...'
            ];
        } else {
            $response = [
                'status'    => 'failed',
                'msg'       => 'Please provide a valid developer token.'
            ];
        }


        return $this->response->setJSON($response);
    }

    public function validateForm()
    {
        $rules = [
            'organization_name'         => ['rules' => 'required', 'label' => 'school name'],
            'subscription_type'         => ['rules' => 'required', 'label' => 'subscription type'],
            'database_name'             => ['rules' => 'required', 'label' => 'database name'],
            'token'                     => ['rules' => 'required', 'label' => 'developer token']
        ];

        if(validate($rules)) {
            $response = [
                'status'    => 'success',
                'msg'       => 'Form validation successful.'
            ];
        } else {
            $response = [
                'status'    => 'failed',
                'msg'       => $this->validation->getErrors()
            ];
        }


        return $this->response->setJSON($response);
    }
    
    public function dispatch($module)
    {
        $token = $this->request->getPost('token');
        if(password_verify($token, env('installation_token'))) {
            $func = 'create' . ucfirst($module) . 'Module';
            
            // call module creation
            $this->$func();
    
            return $this->response->setJSON(['status' => 'OK']);            

        } else {
            return $this->response->setJSON(['status' => 'failed']);    
        }
    }

    private function createUserModule()
    {
        $model = new \Actudent\Installer\Models\UserModel;
        $model->createUser();
        $model->createUserDevices();
    }

    private function createParentModule()
    {
        $model = new \Actudent\Installer\Models\ParentModel;
        $model->createParent();
    }

    private function createStaffModule()
    {
        $model = new \Actudent\Installer\Models\StaffModel;
        $model->createStaff();
    }

    private function createGradeModule()
    {
        $model = new \Actudent\Installer\Models\GradeModel;
        $model->createGrade();
    }

    private function createStudentModule()
    {
        $model = new \Actudent\Installer\Models\StudentModel;
        $model->createStudent();
        $model->createStudentGrade();
        $model->createStudentParent();
    }

    private function createRoomModule()
    {
        $model = new \Actudent\Installer\Models\RoomModel;
        $model->createRoom();
    }

    private function createLessonsModule()
    {
        $model = new \Actudent\Installer\Models\LessonsModel;
        $model->createLessons();
        $model->createLessonsGrade();
    }

    private function createScheduleModule()
    {
        $model = new \Actudent\Installer\Models\ScheduleModel;
        $model->createSchedule();
        $model->createScheduleSettings();
        $model->insertScheduleSettings();
    }

    private function createPresenceModule()
    {
        $model = new \Actudent\Installer\Models\PresenceModel;
        $model->createJournal();
        $model->createHomework();
        $model->createPresence();
    }

    private function createAgendaModule()
    {
        $model = new \Actudent\Installer\Models\AgendaModel;
        $model->createAgenda();
        $model->createAgendaUser();
    }

    private function createSchoolModule()
    {
        $model = new \Actudent\Installer\Models\SchoolModel;
        $model->createSchool();
    }

    private function createTimelogModule()
    {
        $model = new \Actudent\Installer\Models\TimelogModel;
        $model->createTimelog();
    }

    private function createSettingModule()
    {
        $model = new \Actudent\Installer\Models\SettingModel;
        $model->createReportSetting();
    }
}