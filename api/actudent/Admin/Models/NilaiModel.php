<?php namespace Actudent\Admin\Models;

class NilaiModel extends SharedModel
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
     * @param int $lesson
     * @param string $scoreType
     * 
     * @return array
     */
    public function getScores(int $gradeID, int $lesson, string $scoreType): array
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
     * Get lesson name by score_id
     * 
     * @param int $scoreID
     * 
     * @return string
     */
    public function getLessonName(int $scoreID): string
    {
        $field = "score_id, {$this->mapel}.lesson_name";
        $select = $this->QBNilai->select($field);
        $join1 = $select->join($this->mapelKelas, "{$this->nilai}.lessons_grade_id={$this->mapelKelas}.lessons_grade_id");
        $join2 = $join1->join($this->mapel, "{$this->mapelKelas}.lesson_id={$this->mapel}.lesson_id");
        $params = ['score_id' => $scoreID];
        $result = $join2->where(['score_id' => $scoreID])->get()->getResult()[0];

        return $result->lesson_name;
    }
    
    /**
     * Get score detail
     * 
     * @param int $scoreID
     * 
     * @return object
     */
    public function getScoreDetail(int $scoreID): object
    {
        return $this->QBNilai->getWhere(['score_id' => $scoreID])->getResult()[0];
    }

    /**
     * Get student's score
     * 
     * @param int $scoreID
     * @param int $studentID
     * 
     * @return array
     */
    public function getStudentScore(int $scoreID, int $studentID): array
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
    public function insert(array $data, int $lesson, string $lessonType): void
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
    public function update(array $data, int $scoreID): void
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
    public function delete(int $scoreID): void
    {
        $this->QBNilai->update(['deleted' => 1], ['score_id' => $scoreID]);
    }

}