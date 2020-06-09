<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\KelasModel;

class AbsensiModel extends \Actudent\Admin\Models\SharedModel
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
     * @param int $journal >>> Journal ID
     * @param int $student >>> Student ID
     * @param string $date >>> Selected date
     * 
     * @return boolen|object
     */
    public function getPresence($journal, $student, $date)
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
     * Get class group/grade list
     * 
     * @return object
     */
    public function getRombel()
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
     * @return object
     */
    public function getJadwal($day, $grade)
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
     * @return object
     */
    public function getJournal($journalID)
    {
        $journal = $this->QBJurnal->getWhere(['journal_id' => $journalID])->getResult();
        $homework = null;
        if($this->homeworkExists($journalID))
        {
            $homework = $this->QBHomework->getWhere(['journal_id' => $journalID])->getResult();
        }

        return [
            'journal'   => $journal[0], 
            'homework'  => $homework,
        ];
    }

    /**
     * Get journal archives
     * 
     * @param int $gradeID
     * @param string $date
     * 
     * @return object
     */
    public function getJournalArchives($gradeID, $date)
    {
        $field = "journal_id, description, lesson_name, grade_name, {$this->jurnal}.created";
        $select = $this->QBJurnal->select($field);
        $join1 = $select->join($this->jadwal, "{$this->jadwal}.schedule_id={$this->jurnal}.schedule_id");
        $join2 = $join1->join($this->mapelKelas, "{$this->mapelKelas}.lessons_grade_id={$this->jadwal}.lessons_grade_id");
        $join3 = $join2->join($this->mapel, "{$this->mapel}.lesson_id={$this->mapelKelas}.lesson_id");
        $join4 = $join3->join($this->kelas->kelas, "{$this->mapelKelas}.grade_id={$this->kelas->kelas}.grade_id");

        $params = ['is_archive' => 1, "{$this->mapelKelas}.grade_id" => $gradeID];
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
     * @return object|string
     */
    public function getHomeWorkArchive($journalID)
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
    public function savePresence($data, $journalID, $date)
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

    }

    /**
     * Save the journal
     * 
     * @param array $data
     * @param int $scheduleID
     * @param string $date
     * @param boolean $includeHomework
     * 
     * @return void
     */
    public function saveJournal($data, $scheduleID, $date, $includeHomework = false)
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
            }
            
            return $journal;
        }
    }

    /**
     * Check if journal of a schedule has been created before on the same date
     * 
     * @param int $scheduleID
     * @param string $date
     * 
     * @return object
     */
    public function journalHasCreatedBefore($scheduleID, $date)
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
     * @return object|boolean
     */
    private function homeworkExists($journalID)
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
     * @return object|boolean
     */
    public function presenceExists($journalID, $studentID)
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
     * @return object|boolean
     */
    public function journalExists($scheduleID, $date)
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