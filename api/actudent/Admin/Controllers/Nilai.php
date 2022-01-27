<?php namespace Actudent\Admin\Controllers;

use Actudent\Admin\Models\NilaiModel;
use Actudent\Admin\Models\KelasModel;
use Actudent\Guru\Models\NilaiModel as NilaiGuru;
use ExcelCreator;
use Config\Mimes;

class Nilai extends \Actudent
{
    /**
     * @var NilaiModel
     */
    private $nilai;

    /**
     * @var KelasModel
     */
    private $kelas;

    /**
     * @var Actudent\Guru\Models\NilaiModel
     */
    protected $nilaiGuru;

    public function __construct()
    {
        $this->nilai = new NilaiModel;
        $this->kelas = new KelasModel;
        $this->nilaiGuru = new NilaiGuru;
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('AdminNilai.page_title');

        return parse('Actudent\Admin\Views\nilai\nilai-view', $data);
    }

    public function getScores($gradeID, $lesson, $scoreType)
    {
        $data = $this->nilai->getScores($gradeID, $lesson, $scoreType);
        $kategori = [
            'Tugas'     => 'Tugas',
            'UH'        => 'Ulangan Harian',
            'PTS'       => 'Penilaian Tengah Semester',
            'PAS'       => 'Penilaian Akhir Semester',
            'Kinerja'   => 'Proses/Kinerja',
            'Proyek'    => 'Proyek'
        ];

        foreach($data as $res)
        {
            $res->score_category = $kategori[$res->score_category];
            $split = explode(' ', $res->modified);
            $res->modified = reverse($split[0], '-', '/') . ' ' . $split[1];
        }

        return $this->response->setJSON($data);
    }

    public function getScoreDetail($scoreID)
    {
        return $this->response->setJSON($this->nilai->getScoreDetail($scoreID));
    }

    public function getStudentScore($gradeID, $scoreID)
    {
        return $this->response->setJSON($this->_getStudentScore($gradeID, $scoreID));
    }

    public function saveScores($scoreID)
    {
        $request = $this->request->getPost('params');
        $toArray = json_decode($request, true);
        foreach($toArray as $res)
        {
            if(! is_numeric($res['score']))
            {
                $res['score'] = 0;
            }
            
            $values = [
                'score_id'      => $scoreID,
                'student_id'    => $res['id'],
                'score'         => $res['score'],
                'score_note'    => $res['note']
            ];

            $this->nilai->saveScores($scoreID, $res['id'], $values);
        }

        return $this->response->setJSON(['status' => 'OK']);
    }

    public function exportScores($gradeID, $scoreID)
    {
        // get data first
        $scores = $this->_getStudentScore($gradeID, $scoreID);

        $grade = $this->kelas->getClassDetail($gradeID);
        $scoreDetail = $this->nilai->getScoreDetail($scoreID);

        // initialize ExcelCreator() and PHPSpreadsheet
        $excel = new ExcelCreator();
        $spreadsheet = $excel->spreadsheet;
        $scoreGrade = "{$scoreDetail->score_description} ({$grade->grade_name})";

        // set properties
        $spreadsheet->getProperties()
                ->setCreator('Wolestech')
                ->setLastModifiedBy('Actudent')
                ->setTitle($scoreGrade);

        $spreadsheet->setActiveSheetIndex(0);

        $cellTitle = ["Nilai {$scoreDetail->score_description}"];
        $lessonCell = ['Mata Pelajaran: ' . $this->nilai->getLessonName($scoreID)];
        $gradeCell = ['Kelas: ' . $grade->grade_name];

        $header = [
            'No.', 'Nama Siswa', 'Nilai', 'Catatan'
        ];

        $data = [];
        
        $no = 1;
        foreach($scores as $score)
        {
            $scoreData = [$no, $score['student'], $score['score'], $score['note']];

            array_push($data, $scoreData);

            $no++;
        }

        // fill data       
        $excel->fillCell($cellTitle);
        $excel->fillCell($lessonCell, 'A3');
        $excel->fillCell($gradeCell, 'A4');
        $excel->fillCell($header, 'A5');
        $excel->fillCell($data, 'A6');

        // merge and wrap title
        $excel->mergeCells('A1:D1');

        $maxCellsRange = count($scores);
        $maxRowsData = '6-' . (6 + $maxCellsRange);

        // set column's width and row's height
        $columns = ['B', 'C', 'D'];
        $excel->setMultipleColumnsWidth($columns, null);
        $excel->setColumnWidth('A', 7);
        $excel->setMultipleRowsHeight(['1' => 40, '5' => 30, $maxRowsData => 20]);

        $dataStyle = [ 
            'alignment' => [
                'vertical' => $excel->alignment::VERTICAL_CENTER,
            ],           
            'font' => [
                'name' => 'Arial',
                'size' => 10,
            ],
            'borders' => [
                'top' => ['borderStyle' => $excel->border::BORDER_THIN],
                'bottom' => ['borderStyle' => $excel->border::BORDER_THIN],
                'right' => ['borderStyle' => $excel->border::BORDER_THIN],
                'left' => ['borderStyle' => $excel->border::BORDER_THIN],
            ],
        ];

        $gradeAndLessonStyle = [
            'font' => $dataStyle['font'],
        ];

        $headerStyle = [
            'alignment' => [
                'horizontal' => $excel->alignment::HORIZONTAL_CENTER,
                'vertical' => $excel->alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => $excel->fill::FILL_SOLID,
                'color' => ['argb' => 'D9E1F2'],
            ],
            'font' => [
                'name' => 'Arial',
                'size' => 11,
                'bold' => true,
            ],
            'borders' => $dataStyle['borders']
        ];

        $cellTitleStyle = [
            'font' => [
                'name' => 'Arial',
                'size' => 12,
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => $excel->alignment::HORIZONTAL_CENTER,
                'vertical' => $excel->alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
        ];

        $numberStyle = [
            'alignment' => $headerStyle['alignment'],
            'borders' => $dataStyle['borders'],
            'font' => $dataStyle['font'],
        ];

        // apply styles        
        $excel->applyStyle($cellTitleStyle, 'A1:D1');
        $excel->applyStyle($gradeAndLessonStyle, 'A3:A4');
        $excel->applyStyle($headerStyle, 'A5:D5');
        $excel->applyStyle($dataStyle, 'A6:D' . (5 + $maxCellsRange));    
        $excel->applyStyle($numberStyle, 'A6:A' . (5 + $maxCellsRange));

        // set content type header and then save it to client's browser
        $this->response->setContentType(Mimes::guessTypeFromExtension('xlsx'));
        $excel->save("Nilai $scoreGrade.xlsx");
    }

    private function _getStudentScore($gradeID, $scoreID)
    {
        $classMember = $this->kelas->getClassMember($gradeID);
        $wrapper = [];
        foreach($classMember as $res)
        {
            $scores = $this->nilai->getStudentScore($scoreID, $res->student_id);
            if(count($scores) > 0)
            {
                $scores = $scores[0];
                $wrapper[] = [
                    'id'        => $res->student_id,
                    'student'   => $res->student_name,
                    'score'     => $scores->score,
                    'note'      => $scores->score_note
                ];
            }
            else
            {
                $wrapper[] = [
                    'id'        => $res->student_id,
                    'student'   => $res->student_name,
                    'score'     => '',
                    'note'      => '',
                ];
            }
        }

        return $wrapper;
    }
 
    /**
     * Validate request
     * Save them to database, or throw errors if fail
     * 
     * @param int|string $lesson
     * @param string
     * @param null|int
     * 
     * @return JSON
     */
    public function save($lesson, $lessonType, $id = null)
    {
        $validation = $this->validation(); // [0 => $rules, 1 => $messages]
        if(! $this->validate($validation[0], $validation[1]))
        {
            return $this->response->setJSON([
                'code' => '500',
                'msg' => $this->validation->getErrors(),
            ]);
        }
        else
        {
            $data = $this->formData();
            if($id === null) 
            {
                $this->nilai->insert($data, $lesson, $lessonType);
            }
            else
            {
                $this->nilai->update($data, $id);
            }
            
            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }

    public function deleteScore()
    {
        $id = $this->request->getPost('id');
        $this->nilai->delete($id);
        return $this->response->setJSON(['status' => 'OK']);
    }

    private function validation()
    {
        $form = $this->formData();
        $rules = [
            'score_category'    => 'required',
            'score_description' => 'required|min_length[5]',
        ];

        $messages = [
            'score_category' => [
                'required'      => lang('AdminNilai.nilai_category_required'),
            ],
            'score_description' => [
                'required'      => lang('AdminNilai.nilai_description_required'),
                'min_length'    => lang('AdminNilai.nilai_description_mininum'),
            ]
        ];
        
        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'score_category'    => $this->request->getPost('score_category'),
            'score_description' => $this->request->getPost('score_description'),
        ];
    }
    
}