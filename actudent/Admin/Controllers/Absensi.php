<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AbsensiModel;

class Absensi extends Actudent
{
    /**
     * @var Actudent\Admin\Models\AbsensiModel
     */
    private $absensi;

    public function __construct()
    {
        $this->absensi = new AbsensiModel;
    }

    public function index()
	{
        $data = $this->common();
        $data['title'] = lang('AdminAbsensi.page_title');

        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\absensi\absensi-view');
    }

    /**
     * Get list of presence data
     * 
     * @param int $grade
     * @param int|string $journal
     * @param string $date
     */
    public function getListAbsensi($grade, $journal, $date)
    {
        // Get all member of a class group
        $student = $this->absensi->kelas->getClassMember($grade);

        // Presence data to be wrapped
        $presenceWrapper = [];

        // Presence status category
        // Absent|Absen, Present|Hadir, Permit|Izin, Sick|Sakit
        $presenceCategory = [
            lang('AdminAbsensi.absensi_alfa'),
            lang('AdminAbsensi.absensi_hadir'),
            lang('AdminAbsensi.absensi_izin'),
            lang('AdminAbsensi.absensi_sakit')
        ];

        foreach($student as $key)
        {            
            // Set default presence data to empty
            $presenceWrapper[] = [
                'name'      => $key->student_name,
                'status'    => '',
                'note'      => '',
            ];
            
            // Get presence of a student
            $presence = $this->absensi->getPresence($journal, $key->student_id, $date);

            if($presence !== null && $journal !== 'null')
            {

                $presenceWrapper[] = [
                    'name'      => $key->student_name,
                    'status'    => $presenceCategory[$presence->presence_status],
                    'note'      => $presence->presence_remark,
                ];
            }
        }

        return $this->response->setJSON($presenceWrapper);
    }

    public function getAnggotaRombel($grade)
    {
        $student = $this->absensi->kelas->getClassMember($grade);
        return $this->response->setJSON($student);
    }

    public function getJadwal($day, $grade)
    {
        $days = [
            'minggu', 'senin', 'selasa',
            'rabu', 'kamis', 'jumat', 'sabtu'
        ];

        $schedule = $this->absensi->getJadwal($days[$day], $grade);
        $formatter = [];
        foreach($schedule as $res)
        {
            $formatter[] = [
                'id' => $res->schedule_id,
                'text' => $res->lesson_name
            ];
        }

        return $this->response->setJSON($formatter);
    }

    public function checkJournal($scheduleID, $date)
    {
        $jurnal = $this->absensi->journalExists($scheduleID, $date);
        if(! $jurnal)
        {
            return $this->response->setJSON([
                'status'    => 'false',
                'id'        => null,
            ]);
        }
        else 
        {
            return $this->response->setJSON([
                'status'    => 'true',
                'id'        => $jurnal[0]->journal_id,
            ]);
        }
    }

    public function getRombel()
    {
        $data = $this->absensi->getRombel();
        $formatter = [];
        foreach($data as $res)
        {
            $formatter[] = [
                'id' => $res->grade_id,
                'text' => $res->grade_name
            ];
        }

        return $this->response->setJSON($formatter);
    }
}