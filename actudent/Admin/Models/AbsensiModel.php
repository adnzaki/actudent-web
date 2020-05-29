<?php namespace Actudent\Admin\Models;

use Actudent\Admin\Models\KelasModel;

class AbsensiModel extends \Actudent\Admin\Models\SharedModel
{
    /**
     * Query Builder for tb_presence
     */
    private $QBAbsen;

    /**
     * Query Builder for tb_journal
     */
    private $QBJurnal;

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
     * Table tb_journal
     * 
     * @var string
     */
    public $jurnal = 'tb_journal';
    
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
        $this->QBJurnal = $this->db->table($this->jurnal);
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
        if($result->countAllResults() > 0)
        {          
            $presence = $result->get()->getResult()[0];

            return $presence;
        }
        else
        {
            return null;
        }
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
        $params = ['schedule_day' => $day, 'grade_id' => $grade];

        return $join2->where($params)->orderBy('schedule_id', 'ASC')->get()->getResult();
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
            $journalValues['schedule_id']   = $scheduleID;
            $journalValues['date']          = $date;

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
        $field  = "journal_id, {$this->jurnal}.schedule_id, description, date, lessons_grade_id";
        $select = $this->QBJurnal->select($field);
        $join   = $select->join($this->jadwal, "{$this->jadwal}.schedule_id = {$this->jurnal}.schedule_id");
        $previousJournal = $join->where([
            'lessons_grade_id' => $lessonGrade,
            'date' => $date,
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
     * Check if a journal in schedule is exist
     * 
     * @param int $scheduleID
     * @param string $date
     * 
     * @return object|boolean
     */
    public function journalExists($scheduleID, $date)
    {
        $result = $this->QBJurnal->where(['schedule_id' => $scheduleID, 'date' => $date]);
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