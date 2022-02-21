<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\KelasModel;

class AbsensiModel extends SharedModel
{
    /**
     * Query Builder for tb_presence
     */
    private $QBAbsen;

    /**
     * Query Builder for tb_homework
     */
    private $QBHomework;

    /**
     * Table tb_presence
     * 
     * @var string
     */
    public $absensi = 'tb_presence';
    
    /**
     * Table tb_homework
     * 
     * @var string
     */
    public $homework = 'tb_homework';

    /**
     * @var Actudent\Admin\Models\KelasModel
     */
    public $kelas;

    /**
     * Table tb_staff
     * 
     * @var string
     */
    public $staff = 'tb_staff';


    /**
     * Load the tables...
     */
    public function __construct()
    {
        parent::__construct();
        $this->QBAbsen = $this->db->table($this->absensi);        
        $this->QBHomework = $this->db->table($this->homework);       
        $this->kelas = new KelasModel;
    }

    /**
     * Get presence of a student
     * 
     * @param string $journal >>> Journal ID
     * @param int $student >>> Student ID
     * @param string $date >>> Selected date
     * 
     * @return mixed
     */
    public function getPresence(string $journal, int $student, string $date)
    {
        $params = [
            'journal_id'    => $journal,
            'student_id'    => $student,
        ];

        $result = $this->QBAbsen->like('created', $date)->where($params);
        $presence = $result->get()->getResult();
        return $presence[0] ?? null;
    }

    /**
     * Get journals by selected date
     * 
     * @param string $date
     * @param int|null $grade
     * @param boolean $isReport
     * 
     * @return array
     */
    public function getJournalByDate(string $date, $grade = null, bool $isReport = false): array
    {
        $field = "journal_id, description, lesson_name, staff_name, schedule_start, schedule_end, schedule_order, {$this->mapelKelas}.grade_id, grade_name, {$this->jurnal}.created";
        $select = $this->QBJurnal->select($field);
        $join1 = $select->join($this->jadwal, "{$this->jadwal}.schedule_id={$this->jurnal}.schedule_id");
        $join2 = $join1->join($this->mapelKelas, "{$this->mapelKelas}.lessons_grade_id={$this->jadwal}.lessons_grade_id");
        $join3 = $join2->join($this->mapel, "{$this->mapel}.lesson_id={$this->mapelKelas}.lesson_id");
        $join4 = $join3->join($this->kelas->kelas, "{$this->mapelKelas}.grade_id={$this->kelas->kelas}.grade_id");
        $join5 = $join4->join($this->staff, "{$this->mapelKelas}.teacher_id={$this->staff}.staff_id");
        $where = $join5->like("{$this->jurnal}.created", $date)->where("{$this->mapelKelas}.grade_id", $grade);

        // check whether the request is come from PDF report or not
        if($isReport)
        {
            $where->orderBy('schedule_order', 'ASC');
        }

        $result = $where->get()->getResult();

        return $result;
    }

    /**
     * Get the number of presence
     * 
     * @param int $journalID
     * 
     * @return array
     */
    public function getPresenceCount(int $journalID): array
    {
        $present = $this->QBAbsen->getWhere(['journal_id' => $journalID, 'presence_status' => '1'])->getResult();
        $absent = $this->QBAbsen->getWhere(['journal_id' => $journalID, 'presence_status !=' => '1'])->getResult();

        return [
            'present' => count($present),
            'absent' => count($absent)
        ];
    }

    /**
     * Get today's presence
     * 
     * @param int $status
     * @param null|string $date
     * 
     * @return int
     */
    public function getTodayPresence(int $status, $date = null): int
    {
        if($date === null)
        {
            $date = date('Y-m-d');
        }

        $grade = $this->getRombel();
        $presence = 0;

        foreach($grade as $key)
        {
            $journal = $this->getJournalByDate($date, $key->grade_id);
            if(count($journal) > 0)
            {
                $query = $this->QBAbsen
                            ->select('DISTINCT `student_id`', false)
                            ->where(['presence_status' => $status, 'journal_id' => $journal[0]->journal_id])
                            ->like('created', $date)
                            ->get()->getResult();
                
                $presence += count($query);
            }
        }

        return $presence;
    }

    /**
     * Get today's absence with permission
     * 
     * @param null|string $date
     * 
     * @return int
     */
    public function getTodayAbsenceWithPermission($date = null): int
    {
        if($date === null)
        {
            $date = date('Y-m-d');
        }

        $grade = $this->getRombel();
        $presence = 0;
        foreach($grade as $key)
        {
            $journal = $this->getJournalByDate($date, $key->grade_id);
            if(count($journal) > 0)
            {
                $query = $this->QBAbsen
                            ->like('created', $date)
                            ->where('(presence_status = 2 or presence_status = 3)')
                            ->where('journal_id', $journal[0]->journal_id)
                            ->get()->getResult();
                
                $presence += count($query);
            }
        }

        return $presence;
    }

    /**
     * Get percentage of a presence
     * 
     * @return array
     */
    public function getPresencePercentage(): array
    {
        $percentage = [
            'present' => 0,
            'absent' => 0,
            'withPermission' => 0,
        ];

        $journalRows = $this->QBJurnal->select('*')->countAllResults();
        if($journalRows > 0)
        {
            $countStudents = $this->QBStudent->where('deleted', 0)->countAllResults();
            $present = $this->getTodayPresence('1');
            $absent = $this->getTodayPresence('0');
            $withPermission = $this->getTodayAbsenceWithPermission();
            $percentage = [
                'present' => ($present / $countStudents) * 100,
                'absent' => ($absent / $countStudents) * 100,
                'withPermission' => ($withPermission / $countStudents) * 100,
            ];
        }
        
        return $percentage;
    }

    /**
     * Get class group/grade list
     * 
     * @return array
     */
    public function getRombel(): array
    {
        $builder = $this->kelas->QBKelas;
        $params = ["{$this->kelas->kelas}.deleted" => 0, 'grade_status' => '1'];
        return $builder->select('grade_id, grade_name')->getWhere($params)->getResult();
    }

    /**
     * Get schedules of the day
     * 
     * @param string $day
     * @param int $grade
     * 
     * @return array
     */
    public function getJadwal(string $day, int $grade): array
    {
        $field  = 'schedule_id, lesson_name';
        $select = $this->QBJadwal->select($field);
        $join1  = $select->join($this->mapelKelas, "{$this->jadwal}.lessons_grade_id = {$this->mapelKelas}.lessons_grade_id");
        $join2  = $join1->join($this->mapel, "{$this->mapelKelas}.lesson_id = {$this->mapel}.lesson_id");
        $params = ['schedule_day' => $day, 'grade_id' => $grade, 'schedule_status' => 'active'];

        return $join2->where($params)->orderBy('schedule_order', 'ASC')->get()->getResult();
    }

    /**
     * Get journal data
     * 
     * @param int $journalID
     * 
     * @return array
     */
    public function getJournal(int $journalID): array
    {
        $journal = $this->QBJurnal->getWhere(['journal_id' => $journalID])->getResult();
        $homework = null;
        if($this->homeworkExists($journalID))
        {
            $homework = $this->QBHomework->getWhere(['journal_id' => $journalID])->getResult();
        }

        return [
            'journal'   => $journal[0] ?? null, 
            'homework'  => $homework[0] ?? null,
        ];
    }

    /**
     * Get journal archives
     * 
     * @param int|string $gradeID | "null" = skip grade selection
     * @param string $date
     * @param int|null $teacher
     * 
     * @return array
     */
    public function getJournalArchives($gradeID, string $date, $teacher = null): array
    {
        $field = "journal_id, description, lesson_name, {$this->mapelKelas}.grade_id, grade_name, {$this->jurnal}.created";
        $select = $this->QBJurnal->select($field);
        $join1 = $select->join($this->jadwal, "{$this->jadwal}.schedule_id={$this->jurnal}.schedule_id");
        $join2 = $join1->join($this->mapelKelas, "{$this->mapelKelas}.lessons_grade_id={$this->jadwal}.lessons_grade_id");
        $join3 = $join2->join($this->mapel, "{$this->mapel}.lesson_id={$this->mapelKelas}.lesson_id");
        $join4 = $join3->join($this->kelas->kelas, "{$this->mapelKelas}.grade_id={$this->kelas->kelas}.grade_id");

        if($gradeID === 'null')
        {
            $params = ['is_archive' => 1, "{$this->mapelKelas}.teacher_id" => $teacher];
        }
        else 
        {
            $params = ['is_archive' => 1, "{$this->mapelKelas}.grade_id" => $gradeID];
        }

        $result = $join4->like("{$this->jurnal}.created", $date)
                        ->where($params)
                        ->get()
                        ->getResult();
        
        return $result;                       
    }

    /**
     * Get homework from a journal archive
     * 
     * @param int $journalID
     * 
     * @return object|string
     */
    public function getHomeWorkArchive(int $journalID)
    {
        $homework = $this->QBHomework->getWhere(['journal_id' => $journalID])->getResult();

        return (count($homework) > 0) ? $homework[0] : '';
    }

    /**
     * Save presence data
     * 
     * @param array $data
     * @param int $journalID
     * @param string $date
     * 
     * @return void
     */
    public function savePresence(array $data, int $journalID, string $date): void
    {
        $time = date('H:i:s', strtotime('now'));
        $dateTime = "{$date} {$time}";
        $values = [
            'presence_status'   => $data['status'],
            'presence_mark'     => $data['mark'],
            'created'           => $dateTime
        ];        

        if($this->presenceExists($journalID, $data['id']))
        {
            $this->QBAbsen->update($values, [
                'journal_id' => $journalID,
                'student_id' => $data['id']
            ]);
        }
        else 
        {
            $values['journal_id'] = $journalID;
            $values['student_id'] = $data['id'];
            $this->QBAbsen->insert($values);
        }

        $lesson = $this->getLessonName($journalID)[0];
        $student = $this->getStudentName($data['id'])[0];

        $content = [];
        if($data['status'] === 1)
        {
            $content = [
                'title' => 'Kehadiran Mata Pelajaran',
                'body' => $student->student_name . ' mengikuti pelajaran ' . $lesson->lesson_name,
            ];
        }
        elseif($data['status'] === 0)
        {
            $content = [
                'title' => 'Kehadiran Mata Pelajaran',
                'body' => $student->student_name . ' tidak mengikuti pelajaran ' . $lesson->lesson_name,
            ];
        }

        if($data['status'] === 1 || $data['status'] === 0)
        {
            $this->sendNotification($data['id'], $content);
        }
    }    

    /**
     * Save the journal
     * 
     * @param array $data
     * @param int $scheduleID
     * @param string $date
     * @param boolean $includeHomework
     * 
     * @return mixed
     */
    public function saveJournal(array $data, int $scheduleID, string $date, bool $includeHomework = false)
    {
        $journalValues = [
            'description' => $data['description'],
            
        ];

        $timestamp = strtotime($data['due_date']);

        // set clock to 23.59
        $addHours = 23 * 60 * 60 + (59 * 60);

        // set due date 
        $dueDate = date('Y-m-d H:i:s', $timestamp + $addHours);
        $homeworkValues = [
            'homework_title'        => $data['homework_title'],
            'homework_description'  => $data['homework_description'],
            'due_date'              => $dueDate,
        ];

        $journal = $this->journalExists($scheduleID, $date);

        if(! $journal)
        {
            $time = date('H:i:s', strtotime('now'));
            $dateTime = "{$date} {$time}";
            $journalValues['schedule_id']   = $scheduleID;
            $journalValues['created']       = $dateTime;

            // insert journal first
            $this->QBJurnal->insert($journalValues);

            // get the journal ID
            $journalID = $this->db->insertID();

            if($includeHomework)
            {
                $homeworkValues['journal_id'] = $journalID;
                
                // insert the homework
                $this->QBHomework->insert($homeworkValues);    
                $this->sendHomeworkNotification($scheduleID, $journalID, $homeworkValues, $date);
            }
        }
        else 
        {
            $journalID = $journal[0]->journal_id;
            $this->QBJurnal->update($journalValues, ['journal_id' => $journalID]);

            if($includeHomework)
            {
                if($this->homeworkExists($journalID))
                {
                    $this->QBHomework->update($homeworkValues, ['journal_id' => $journalID]);
                }
                else 
                {
                    $homeworkValues['journal_id'] = $journalID;
                
                    // insert the homework
                    $this->QBHomework->insert($homeworkValues);
                }

                $this->sendHomeworkNotification($scheduleID, $journalID, $homeworkValues, $date);
            }
            
            return $journal;
        }
    }

    /**
     * Send homework notification
     * 
     * @param int $scheduleID
     * @param int $journalID
     * @param array $homework
     * @param string $date
     * 
     * @return void
     */
    private function sendHomeworkNotification(int $scheduleID, int $journalID, array $homework, string $date): void
    {
        $classGroup = $this->getClassGroupBySchedule($scheduleID)[0];
        $classMember = $this->kelas->getClassMember($classGroup->grade_id);
        $lesson = $this->getLessonName($journalID)[0];
        foreach($classMember as $member)
        {
            // notification content
            $content = [
                'title' => 'Pemberitahuan Tugas Baru untuk ' . $member->student_name,
                'body'  => $lesson->lesson_name .
                            ': ' . $homework['homework_title'] . 
                            ' telah terbit, batas pengumpulan tugas ' . 
                            os_date()->format('DD-MM-Y', reverse($date, '-', '-')),
            ];

            // send notification
            $this->sendNotification($member->student_id, $content);
        }
    } 

    /**
     * Get class group by schedule_id
     * 
     * @param int $scheduleID
     * 
     * @return array
     */
    public function getClassGroupBySchedule(int $scheduleID): array
    {
        $field = "schedule_id, {$this->mapelKelas}.grade_id, grade_name";
        $select = $this->QBJadwal->select($field);
        $join1 = $select->join($this->mapelKelas, "{$this->mapelKelas}.lessons_grade_id={$this->jadwal}.lessons_grade_id");
        $join2 = $join1->join($this->kelas->kelas, "{$this->kelas->kelas}.grade_id={$this->mapelKelas}.grade_id");

        return $join2->where('schedule_id', $scheduleID)->get()->getResult();
    }

    /**
     * Get student name
     * 
     * @param int $studentID
     * 
     * @return array
     */
    public function getStudentName(int $studentID)
    {
        return $this->QBStudent->getWhere(['student_id' => $studentID])->getResult();
    }

    /**
     * Get lesson name by journalID
     * 
     * @param int $journalID
     * 
     * @return array
     */
    public function getLessonName(int $journalID): array
    {
        $field = "journal_id, description, lesson_name";
        $select = $this->QBJurnal->select($field);
        $join1 = $select->join($this->jadwal, "{$this->jadwal}.schedule_id={$this->jurnal}.schedule_id");
        $join2 = $join1->join($this->mapelKelas, "{$this->mapelKelas}.lessons_grade_id={$this->jadwal}.lessons_grade_id");
        $join3 = $join2->join($this->mapel, "{$this->mapel}.lesson_id={$this->mapelKelas}.lesson_id");

        return $join3->where('journal_id', $journalID)->get()->getResult();
    }

    /**
     * Check if journal of a schedule has been created before on the same date
     * 
     * @param int $scheduleID
     * @param string $date
     * 
     * @return int|boolean
     */
    public function journalHasCreatedBefore(int $scheduleID, string $date)
    {
        // Get the lessons_grade_id of current schedule
        $lessonGrade = $this->QBJadwal->select('lessons_grade_id')
                        ->where('schedule_id', $scheduleID)
                        ->get()
                        ->getResult()[0]
                        ->lessons_grade_id;

        // Check if journal has been created by its lessons_grade_id and date
        $field  = "journal_id, {$this->jurnal}.schedule_id, description, created, lessons_grade_id";
        $select = $this->QBJurnal->select($field);
        $join   = $select->join($this->jadwal, "{$this->jadwal}.schedule_id = {$this->jurnal}.schedule_id");
        $like   = $join->like('created', $date);
        $previousJournal = $join->where([
            'lessons_grade_id' => $lessonGrade,
        ])->get()->getResult();

        // return journal_id if exists, or false otherwise
        return $previousJournal[0]->journal_id ?? false;
    }

    /**
     * Check if a homework is exist
     * 
     * @param int $journalID
     * 
     * @return boolean
     */
    private function homeworkExists(int $journalID): bool
    {
        $query = $this->QBHomework->where('journal_id', $journalID);
        if($query->countAllResults() > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    /**
     * Check if a presence exists
     * 
     * @param int $journalID
     * @param int $studentID
     * 
     * @return boolean
     */
    public function presenceExists(int $journalID, int $studentID): bool
    {
        $check = $this->QBAbsen->where(['journal_id' => $journalID, 'student_id' => $studentID]);

        if($check->countAllResults() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Check if a journal in schedule is exist
     * 
     * @param int $scheduleID
     * @param string $date
     * 
     * @return array|boolean
     */
    public function journalExists(int $scheduleID, string $date)
    {
        $like = $this->QBJurnal->like('created', $date);
        $result = $like->where(['schedule_id' => $scheduleID]);
        $jurnal = $result->get()->getResult();

        if($result->countAllResults() > 0)
        {
            return $jurnal;
        }
        else
        {
            return false;
        }
    }

}