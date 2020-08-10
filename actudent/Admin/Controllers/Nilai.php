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

    public function getScores($gradeID, $scoreType)
    {
        $data = $this->nilai->getScores($gradeID, $scoreType);
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
    
}