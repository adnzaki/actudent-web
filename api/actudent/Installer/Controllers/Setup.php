<?php namespace Actudent\Installer\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Installer\Models\OrganizationModel;
use CodeIgniter\Files\File;

class Setup extends \App\Controllers\BaseController
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

	public function addTokenKey()
	{
		$token = $this->request->getPost('token');
        if(password_verify($token, env('installation_token'))) {
			$secretKey = generate_symbol(4) . random_string('crypto', 16) . generate_symbol(4);
			$path = ACTUDENT_PATH . 'Core/Config/Keys/JawaBarat/KotaBekasi.php';
			$file = new File($path);
			if ($file->isWritable()) {
				$addKey = $file->openFile('r');
				$currentContent = $addKey->fread($file->getSize());

				$addKey = "    '".get_subdomain()."' => '".$secretKey."',\n    ];";
				$newContent = str_replace(['];'], [$addKey], $currentContent);

				$modifyFile = $file->openFile('w');
				$modifyFile->fwrite($newContent);

				$this->addDatabaseConfig();
				return $this->response->setJSON(['status' => 'OK']);
			} else {
				return $this->response->setJSON(['status' => 'failed']);
			}
		} else {
			return $this->response->setJSON(['status' => 'failed']);
		}
	}

	private function addDatabaseConfig()
	{
		$path = APPPATH . 'Config/DatabaseList/DbTemplate.php';
		$file = new File($path);
		$content = $file->openFile('r')->fread($file->getSize());

		// the substitution values...
		$traitName = ucfirst(get_subdomain());
		$dbUser = $this->request->getPost('db_user');
		$dbPassword = $this->request->getPost('db_password');
		$dbName = $this->request->getPost('database_name');

		// do substitution
		$search = ['%trait_name%', '%group_name%', '%db_user%', '%db_password%', '%db_name%', '/*', '*/'];
		$replace = [$traitName, strtolower($traitName), $dbUser, $dbPassword, $dbName, '', ''];
		$content = str_replace($search, $replace, $content);

		// create file and write the content to it
		$createFile = fopen(APPPATH . 'Config/DatabaseList/' . $traitName . '.php', 'w');
		fwrite($createFile, $content);

		// Add config to db wrapper
		$this->addWrapper($traitName);

	}

	private function addWrapper(string $traitName)
	{
		$path = APPPATH . 'Config/DatabaseList/DBGroupWrapper.php';
		$file = new File($path);
		if ($file->isWritable()) {
			$addGroup = $file->openFile('r');
			$currentContent = $addGroup->fread($file->getSize());
			$newContent = str_replace('}', "    use \Config\DatabaseList\\" . $traitName . ";\n}", $currentContent);
			$modifyFile = $file->openFile('w');
			$modifyFile->fwrite($newContent);
		}
	}

    public function validateForm()
    {
        $rules = [
            'organization_name'         => ['rules' => 'required', 'label' => 'school name'],
            'subscription_type'         => ['rules' => 'required', 'label' => 'subscription type'],
            'database_name'             => ['rules' => 'required', 'label' => 'database name'],
            'token'                     => ['rules' => 'required', 'label' => 'developer token'],
			'db_user'					=> ['rules' => 'required', 'label' => 'database user'],
        ];

		if(ENVIRONMENT === 'production') {
			$rules = array_merge($rules, [
				'db_password' => ['rules' => 'required', 'label' => 'database password']
			]);
		}

		$data = $this->request->getPost(array_keys($rules));

        if($this->validateData($data, $rules)) {
            $response = [
                'status'    => 'success',
                'msg'       => 'Form validation successful.'
            ];
        } else {
            $response = [
                'status'    => 'failed',
                'msg'       => $this->validator->getErrors()
            ];
        }


        return $this->response->setJSON($response);
    }

    private function createUserModule()
    {
        $model = new \Actudent\Installer\Models\UserModel;
        $model->createUser();
        $model->createUserDevices();
    }

	private function createSessionModule()
    {
		$model = new \Actudent\Installer\Models\LoginHistoryModel;
		$model->createLogins();
		$model->createSessions();
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

    private function createTimelineModule()
    {
        $model = new \Actudent\Installer\Models\TimelineModel;
        $model->createTimeline();
        $model->createTimelineImages();
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

	private function createHolidaysModule()
    {
        $model = new \Actudent\Installer\Models\HolidaysModel;
        $model->createHolidays();
    }
}
