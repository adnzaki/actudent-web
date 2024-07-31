<?php

namespace Actudent\Sync\Models;

use Actudent\Admin\Models\SiswaModel;
use Actudent\Admin\Models\OrtuModel;
use Actudent\Admin\Models\PegawaiModel;
use Actudent\Admin\Models\KelasModel;
use Actudent\Admin\Models\SharedModel;

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
		parent::__construct();
		$this->ot = new OrtuModel;
		$this->s = new SiswaModel;
		$this->p = new PegawaiModel;
		$this->r = new KelasModel;
	}

	public function deleteAllData()
	{
		$model = new SharedModel;
		$this->db->transStart();
		$model->QBRombel->emptyTable();
		$model->QBStudentParent->emptyTable();
		$this->s->QBStudent->emptytable();
		$this->r->QBKelas->emptytable();
		$this->p->QBStaff->emptytable();
		$this->ot->QBParent->emptytable();
		$this->p->QBUser->delete(['user_id !=' => 1]);
		$this->db->transComplete();
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			return false;
		} else {
			$this->db->transCommit();
			return true;
		}
	}

	public function getDefaultTeacher()
	{
		$teacher = $this->p->getStaff('teacher', 1, 0);
		if (count($teacher) > 0) {
			return $teacher[0];
		} else {
			return false;
		}
	}

	public function getRombelId($dapodikID)
	{
		$query = $this->r->QBKelas->getWhere(['rombel_dapodik_id' => $dapodikID]);

		return $query->getNumRows() > 0 ? $query->getResult()[0]->grade_id : false;
	}

	public function insertRombel($value)
	{
		return $this->r->insert($value);
	}

	public function rombelExists($dapodikID)
	{
		$query = $this->r->QBKelas->getWhere(['rombel_dapodik_id' => $dapodikID, 'deleted' => 0]);
		if ($query->getNumRows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function insertPegawai($value)
	{
		if ($this->accountExists($value['user_email'])) {
			$value['user_email'] = $value['user_email'] . rand(1, 1000);
		}

		return $this->p->insert($value);
	}

	public function pegawaiExists($nik, $ptkId)
	{
		$query = $this->p->QBStaff->where(['ptk_dapodik_id' => $ptkId, 'deleted' => 0]);
		$query->orWhere(['staff_nik' => $nik]);
		if ($query->get()->getNumRows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function insertPesertaDidik($value)
	{
		return $this->s->insert($value);
	}

	public function insertOrangTua($value)
	{
		if ($this->accountExists($value['user_email'])) {
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

		if ($query->getNumRows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	private function accountExists($userEmail)
	{
		$findUser = $this->ot->QBUser->getWhere(['user_email' => $userEmail]);

		if ($findUser->getNumRows() === 0) {
			return false;
		} else {
			return true;
		}
	}

	public function orangTuaExists($father, $mother, $phone)
	{
		$findParent = $this->ot->QBParent->getWhere([
			'parent_father_name' => $father,
			'parent_mother_name' => $mother,
			'parent_phone_number' => $phone,
			'deleted'			 => 0
		]);

		if ($findParent->getNumRows() === 0) {
			return false;
		} else {
			return $findParent->getResult()[0];
		}
	}
}
