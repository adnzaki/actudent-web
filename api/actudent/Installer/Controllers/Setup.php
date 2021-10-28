<?php namespace Actudent\Installer\Controllers;

class Setup extends \Actudent\Core\Controllers\Actudent
{
    public function __construct()
    {
        // Session should be removed to avoid
        // system check to database that has not been installed
        session()->remove(['id', 'email', 'nama', 'userLevel', 'logged_in']);
        session()->remove(['org_id', 'org_name']);

        // set app language based on default language
        $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';
        $this->setLanguage($defaultLang);
    }

    public function index()
    {   
        if(ENVIRONMENT === 'development')   
        {
            if(db_installed())
            {
                return redirect()->to(base_url('admin/home'));
            }
            else
            {
                $data = $this->common();
                $data['title']      = lang('Setup.title');    
                $config             = config('Database');
                $data['dbName']     = $config->default['database'];
        
                return parse('Actudent\Installer\Views\setup\setup-view', $data);
            }
        }
        else
        {
            echo access_denied();
        }
    }    

    public function dispatch($module)
    {
        if(ENVIRONMENT === 'development')
        {
            $firstLetter = strtoupper(substr($module, 0, 1));
            $func = 'create' . $firstLetter . substr($module, 1, strlen($module)) . 'Module';
            
            // call module creation
            $this->$func();

            return $this->response->setJSON(['status' => 'OK']);
        }
        else
        {
            echo access_denied();
        }
    }

    public function dropTables()
    {
        if(ENVIRONMENT === 'development')
        {
            // do not change the order!
            $tables = [
                'tb_timelog',
                'tb_school',
                'tb_score_student', 'tb_score',
                'tb_chat', 'tb_chat_users',
                'tb_timeline',
                'tb_agenda_user', 'tb_agenda',
                'tb_homework', 'tb_presence', 'tb_journal',
                'tb_schedule', 'tb_schedule_settings',
                'tb_student_grade', 'tb_student_parent', 'tb_student',
                'tb_lessons_grade', 'tb_lessons',
                'tb_room', 'tb_grade', 'tb_staff', 'tb_parent', 
                'tb_user_devices', 'tb_user_language', 'tb_user'
            ];
    
            $model = new \Actudent\Installer\Models\SetupModel;
            $model->dropTables($tables);
            return $this->response->setJSON(['msg' => 'Tables dropped successfully']);
        }
        else
        {
            echo access_denied();
        }
    }

    private function createUserModule()
    {
        $model = new \Actudent\Installer\Models\UserModel;
        $model->createUser();
        $model->createUserDevices();
        $model->createUserLanguage();
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
    }

    private function createMessageModule()
    {
        $model = new \Actudent\Installer\Models\MessageModel;
        $model->createMessageParticipant();
        $model->createMessage();
    }

    private function createScoreModule()
    {
        $model = new \Actudent\Installer\Models\ScoreModel;
        $model->createScore();
        $model->createScoreStudent();
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

        $subs = new \Actudent\Core\Models\SubscriptionModel;
        $organization = $subs->getOrganization();
        $registerSession = [
            'org_id'    => $organization->organization_id,
            'org_name'  => $organization->organization_name,
        ];

        session()->set($registerSession);
    }
}