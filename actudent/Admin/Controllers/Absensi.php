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
     * 
     * @return JSON
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

    public function getJournal($journalID)
    {
        $jurnal = $this->absensi->getJournal($journalID);
        $formatter = [];

        if($jurnal['homework'] !== null)
        {
            foreach($jurnal['homework'] as $key)
            {
                $date = explode(' ', $key->due_date);
                $key->due_date = $date[0];
            }
        }

        return $this->response->setJSON($jurnal);
    }

    public function copyJournal($scheduleID, $date)
    {
        $hasCreated = $this->absensi->journalHasCreatedBefore($scheduleID, $date);
        $result = [];
        if($hasCreated !== false)
        {
            return $this->response->setJSON([
                'status'    => 'OK',
                'msg'       => lang('AdminAbsensi.absensi_salin_jurnal_sukses'),
                'id'        => $hasCreated,
            ]);
        }
        else 
        {
            return $this->response->setJSON([
                'status'    => 'ERROR',
                'msg'       => lang('AdminAbsensi.absensi_salin_jurnal_gagal'),
                'id'        => null
            ]);
        }
    }

    public function save($scheduleID, $date, $includeHomework)
    {
        if($includeHomework === 'true')
        {
            $includeHomework = true;
        }
        else 
        {
            $includeHomework = false;
        }

        $validation = $this->validation($includeHomework); // [0 => $rules, 1 => $messages]

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
            $saved;
            if($includeHomework) 
            {
                // save journal with homework
                $saved = $this->absensi->saveJournal($data, $scheduleID, $date, true);
            }
            else
            {
                // save journal without homework
                $saved = $this->absensi->saveJournal($data, $scheduleID, $date);
            }
            
            return $this->response->setJSON([
                'code' => '200',
                'data' => $saved,
            ]);
        }
    }

    private function validation($includeHomework)
    {
        $form = $this->formData();

        $rules = [
            'description'   => 'required',
        ];

        $messages = [
            'description' => [
                'required' => lang('AdminAbsensi.absensi_err_jurnal_required')
            ],
        ];

        if($includeHomework)
        {
            $homeworkRules = [
                'homework_title'        => 'required',
                'homework_description'  => 'required',
                'due_date'              => 'required|valid_date[Y-m-d]'
            ];

            $homeworkMessages = [
                'homework_title' => [
                    'required' => lang('AdminAbsensi.absensi_err_title_required')
                ],
                'homework_description' => [
                    'required' => lang('AdminAbsensi.absensi_err_desc_required')
                ],
                'due_date' => [
                    'required'      => lang('AdminAbsensi.absensi_err_duedate_required'),
                    'valid_date'    => lang('AdminAbsensi.absensi_err_duedate_format')
                ],
            ];

            foreach($homeworkRules as $rule => $val)
            {
                $rules[$rule] = $val;
            }

            foreach($homeworkMessages as $msg => $val)
            {
                $messages[$msg] = $val;
            }
        }

        return [$rules, $messages];
    }

    private function formData()
    {
        return [
            'description'           => $this->request->getPost('description'),
            'homework_title'        => $this->request->getPost('homework_title'),
            'homework_description'  => $this->request->getPost('homework_description'),
            'due_date'              => $this->request->getPost('due_date')
        ];
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
}