<?php namespace Actudent\Installer\Controllers;

class Setup extends \Actudent
{
    public function dispatch($module)
    {
        $firstLetter = strtoupper(substr($module, 0, 1));
        $func = 'create' . $firstLetter . substr($module, 1, strlen($module)) . 'Module';
        
        // call module creation
        $this->$func();

        return $this->response->setJSON(['status' => 'OK']);
    }

    public function dropTables()
    {
        // do not change the order!
        $tables = [
            'tb_timelog',
            'tb_school',
            'tb_agenda_user', 'tb_agenda',
            'tb_homework', 'tb_presence', 'tb_journal',
            'tb_schedule', 'tb_schedule_settings',
            'tb_student_grade', 'tb_student_parent', 'tb_student',
            'tb_lessons_grade', 'tb_lessons',
            'tb_room', 'tb_grade', 'tb_staff', 'tb_parent', 
            'tb_user_devices', 'tb_user'
        ];

        $model = new \Actudent\Installer\Models\SetupModel;
        $model->dropTables($tables);
        return $this->response->setJSON(['msg' => 'Tables dropped successfully']);
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
}