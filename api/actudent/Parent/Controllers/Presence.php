<?php namespace Actudent\Parent\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Admin\Controllers\Absensi;

class Presence extends \Actudent
{
	public function getDetailPresence($month, $year)
	{
		if(is_parent()) {
			$absensi = new Absensi;
			$data = $absensi->_countPresence(get_student()->id, get_student()->gradeId, $month, $year);
			$presenceCategory = [
				get_lang('AdminAbsensi.absensi_alfa'),
				get_lang('AdminAbsensi.absensi_hadir'),
				get_lang('AdminAbsensi.absensi_izin'),
				get_lang('AdminAbsensi.absensi_sakit')
			];
			$formatted = [];

			foreach($data as $d) {
				$formatted[] = [
					'date' => $d['date'],
					'status' => $d['status'] !== '-' ? (int)$d['status'] : 4,
					'status_text' => $d['status'] !== '-' ? $presenceCategory[$d['status']] : get_lang('Parent.presence_not_available'),
					'date_long' => $d['date_long'],
					'detail' => $d['detail'] ?? []
				];
			}

			return $this->response->setJSON($formatted);
		}
	}
}
