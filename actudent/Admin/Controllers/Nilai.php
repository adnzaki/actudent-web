<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\NilaiModel;

class Nilai extends Actudent
{
    /**
     * @var NilaiModel
     */
    private $nilai;

    public function __construct()
    {
        $this->nilai = new NilaiModel;
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
                //$this->jadwal->update($data, $id);
            }
            
            return $this->response->setJSON([
                'code' => '200',
            ]);
        }
    }

    public function delete()
    {

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