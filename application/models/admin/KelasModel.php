<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KelasModel extends CI_Model
{
    /**
     * Tabel tb_grade
     * 
     * @var string
     */
    private $kelas = 'tb_grade';

    /**
     * Query untuk mengambil data siswa 
     * 
     * @param int $limit 
     * @param int $offset 
     * @param string $orderBy
     * @param string $searchBy
     * @param string $sort
     * @param string $search 
     * @return object
     */
    public function getKelasQuery($limit, $offset, $orderBy = 'grade_name', $searchBy = 'grade_name', $sort = 'ASC', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);        

        // WHERE studentStatus = 1 ORDER BY studentName ASC LIMIT $offset, $limit         
        $query = $joinAndSearch->where('grade_status', '1')->order_by($orderBy, $sort)->limit($limit, $offset);
        return $query->get();
    }

    /**
     * Menghitung jumlah baris data kelas keseluruhan
     * 
     * @param string $searchBy
     * @param string $search
     * @return int
     */
    public function getKelasRows($searchBy = 'grade_name', $search = '')
    {
        $joinAndSearch = $this->joinAndSearchQuery($searchBy, $search);

        return $joinAndSearch->where('grade_status', '1')->get()->num_rows();
    }

    /**
     * Query join tabel tb_student, tb_student_grade dan tb_grade
     * serta query untuk pencarian data dengan "LIKE" 
     * 
     * @param string $searchBy
     * @param string $search
     * @return object
     */
    public function joinAndSearchQuery($searchBy, $search)
    {
        // Query:   SELECT studentNis, studentName, gradeName, studentStatus FROM tb_student
        //          JOIN tb_student_grade ON tb_student_grade.studentID = tb_student.studentID
        //          JOIN tb_grade ON tb_grade.gradeID = tb_student_grade.gradeID 
        $field = 'grade_name, period_from, period_until, grade_status';
        $join = $this->db->select($field)->from($this->kelas);
        
        if(! empty($search))
        {
            // Menampung parameter pencarian "studentNis-studentName-gradeName",
            // sehingga parameter bisa berdasarkan field studentNis, studentName atau gradeName.
            // Kode ini tidak berkaitan dengan plugin SSPaging yang hanya mendukung 1 parameter pencarian
            if(strpos($searchBy, '-') !== false)
            {
                $searchBy = explode('-', $searchBy);
                $this->db->like($searchBy[0], $search); 
                $this->db->or_like($searchBy[1], $search);                 
            }
            else 
            {
                $this->db->like($searchBy, $search); // cari berdasarkan satu parameter saja
            }
        }
        
        return $join;
    }

    /**
     * Mengambil daftar kelas 
     * 
     * @return void
     */
    public function getKelas()
    {
        return $this->db->get($this->kelas)->result();
    }
}
