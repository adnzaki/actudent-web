<?php namespace Actudent\Sync\Models;

use Actudent\Admin\Models\SiswaModel;
use Actudent\Admin\Models\OrtuModel;
use Actudent\Admin\Models\PegawaiModel;
use Actudent\Admin\Models\KelasModel;

class DapodikModel extends \Actudent\Core\Models\Connector
{
    // orang tua
    private $ot;

    // siswa
    private $s;

    // pegawai
    private $p;

    // kelas
    public $r;

    public function __construct()
    {
        parent:: __construct();
        $this->ot = new OrtuModel;
        $this->s = new SiswaModel;
        $this->p = new PegawaiModel;
        $this->r = new KelasModel;
    }

    public function getRombelId($dapodikID)
    {
        $query = $this->r->QBKelas->getWhere(['rombel_dapodik_id' => $dapodikID]);

        return $query->getResult()[0]->grade_id;
    }

    public function insertRombel($value)
    {
        return $this->r->insert($value);
    }

    public function rombelExists($dapodikID)
    {
        $query = $this->r->QBKelas->getWhere(['rombel_dapodik_id' => $dapodikID]);
        if($query->getNumRows() > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function insertPegawai($value)
    {
        if($this->accountExists($value['user_email']))
        {
            $value['user_email'] = $value['user_email'] . rand(1, 1000);
        }

        return $this->p->insert($value);
    }

    public function pegawaiExists($nik)
    {
        $query = $this->p->QBStaff->getWhere(['staff_nik' => $nik]);
        if($query->getNumRows() > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function insertPesertaDidik($value)
    {
        return $this->s->insert($value);
    }

    public function insertOrangTua($value)
    {
        if($this->accountExists($value['user_email']))
        {
            $value['user_email'] = $value['user_email'] . rand(1, 1000);
        }

        return $this->ot->insert($value);
    }

    public function pesertaDidikExists($nis, $nama)
    {
        $query = $this->s->QBStudent->getWhere([
            'student_nis'   => $nis,
            'student_name'  => $nama,
            'deleted'       => '0'
        ]);

        if($query->getNumRows() > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    private function accountExists($userEmail)
    {
        $fullEmail = $userEmail . '@' . $this->ot->getSchoolDomain();
        $findUser = $this->ot->QBUser->getWhere(['user_email' => $fullEmail]);

        if($findUser->getNumRows() === 0)
        {
            return false;
        }
        else 
        {
            return true;
        }
    }

    public function orangTuaExists($father, $mother, $phone)
    {
        $findParent = $this->ot->QBParent->getWhere([
            'parent_father_name' => $father,
            'parent_mother_name' => $mother,
            'parent_phone_number'=> $phone
        ]);

        if($findParent->getNumRows() === 0)
        {
            return false;
        }
        else 
        {
            return $findParent->getResult()[0];
        }
    }
}