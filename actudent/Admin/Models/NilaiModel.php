<?php namespace Actudent\Admin\Models;

class NilaiModel extends \Actudent\Admin\Models\SharedModel
{
    /**
     * Query builder for tb_score
     */
    private $QBNilai;

    /**
     * Query builder for tb_score_student
     */
    private $QBNilaiSiswa;

    /**
     * Table tb_score
     * 
     * @var string
     */
    private $nilai = 'tb_score';

    /**
     * Table tb_score_student
     * 
     * @var string
     */
    private $nilaiSiswa = 'tb_score_student';

    /**
     * Setup query builders
     */
    public function __construct()
    {
        parent::__construct();        
        $this->QBNilai = $this->db->table($this->nilai);
        $this->QBNilaiSiswa = $this->db->table($this->nilaiSiswa);
    }

    /**
     * Get scores category by its grade
     * 
     * @param int $gradeID
     * @param string $scoreType
     * 
     * @return object
     */
    public function getScores($gradeID, $lesson, $scoreType)
    {
        $field = "score_id, score_category, score_description, {$this->nilai}.lessons_grade_id, {$this->nilai}.modified";
        $select = $this->QBNilai->select($field);
        $join1 = $select->join($this->mapelKelas, "{$this->nilai}.lessons_grade_id={$this->mapelKelas}.lessons_grade_id");
        $params = [
            "{$this->nilai}.deleted"            => 0, 
            'grade_id'                          => $gradeID, 
            'score_type'                        => $scoreType,
            "{$this->nilai}.lessons_grade_id"   => $lesson,
        ];
        return $join1->where($params)->get()->getResult();
    }
    
    /**
     * Get score detail
     * 
     * @param int $scoreID
     * 
     * @return object
     */
    public function getScoreDetail($scoreID)
    {
        return $this->QBNilai->getWhere(['score_id' => $scoreID])->getResult()[0];
    }

    /**
     * Get student's score
     * 
     * @param int $scoreID
     * @param int $studentID
     * 
     * @return object
     */
    public function getStudentScore($scoreID, $studentID)
    {
        return $this->QBNilaiSiswa
                    ->getWhere(['score_id' => $scoreID, 'student_id' => $studentID])
                    ->getResult();
    }

    /**
     * Save student score
     * 
     * @param int $scoreID
     * @param int $studentID
     * @param array $data
     * 
     * @return void
     */
    public function saveScores(int $scoreID, int $studentID, array $data): void
    {
        $check = $this->QBNilaiSiswa
                      ->where(['score_id' => $scoreID, 'student_id' => $studentID])
                      ->countAllResults();

        if($check > 0)
        {
            $this->QBNilaiSiswa->update($data, [
                'score_id' => $scoreID, 'student_id' => $studentID
            ]);
        }
        else
        {
            $this->QBNilaiSiswa->insert($data);
        }
    }

    /**
     * Add a score
     * 
     * @param array $data
     * @param int $lesson
     * @param string $lessonType
     * 
     * @return void
     */
    public function insert($data, $lesson, $lessonType)
    {
        $data['lessons_grade_id']   = $lesson;
        $data['score_type']         = $lessonType;
        $this->QBNilai->insert($data);
    }

    /**
     * Update a score
     * 
     * @param array $data
     * @param int $scoreID
     * 
     * @return void
     */
    public function update($data, $scoreID)
    {
        $this->QBNilai->update($data, ['score_id' => $scoreID]);
    }

    /**
     * Tag score as "deleted"
     * 
     * @param int $scoreID
     * 
     * @return void
     */
    public function delete($scoreID)
    {
        $this->QBNilai->update(['deleted' => 1], ['score_id' => $scoreID]);
    }

}