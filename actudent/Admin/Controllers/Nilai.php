<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\NilaiModel;
use Actudent\Admin\Models\KelasModel;

class Nilai extends Actudent
{
    /**
     * @var NilaiModel
     */
    private $nilai;

    /**
     * @var KelasModel
     */
    private $kelas;

    public function __construct()
    {
        $this->nilai = new NilaiModel;
        $this->kelas = new KelasModel;
    }

    public function index()
    {
        $data = $this->common();
        $data['title'] = lang('AdminNilai.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\nilai\nilai-view');
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

        return $this->response->setJSON($wrapper);
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