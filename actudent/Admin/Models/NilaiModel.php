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
        $field = "score_category, score_description, {$this->nilai}.modified";
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

}