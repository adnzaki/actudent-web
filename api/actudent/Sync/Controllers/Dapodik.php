<?php namespace Actudent\Sync\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Sync\Models\DapodikModel;

class Dapodik extends \Actudent
{
    private $model;

    public function __construct()
    {
        $this->model = new DapodikModel;
        helper('filesystem');
    }

    public function setAnggotaRombel()
    {
        if(is_admin())
        {
            $studentTemp = PUBLICPATH . 'extras/' . 'PdTemp.json';
            $studentTemp = file_get_contents($studentTemp);
            $studentToArray = json_decode($studentTemp);
            $inserted = 0;
            foreach($studentToArray as $key)
            {
                $rombelId = $this->model->getRombelId($key->rombel_id);
                $studentId = $key->student_id;

				if($key->anggota_rombel_id !== 'Belum masuk ke dalam rombongan belajar') {
					// use rombel setter from Kelas Model that initiated as "$this->r" in DapodikModel
					$this->model->r->addMember($studentId, $rombelId);
					$inserted++;
				}
            }

			if($inserted > 0) {
				$note = "$inserted peserta didik berhasil ditambahkan ke rombel";
			} else {
				$note = 'Tidak ada peserta didik yang ditambahkan ke rombel';
			}

            return $this->response->setJSON(['msg' => 'OK', 'note' => $note]);
        }
    }

    public function rombonganBelajar()
    {
        if(is_admin())
        {
            $data = $this->request->getPost('data');
            $decoded = json_decode($data);
            $inserted = 0;
			$skippedRombel = 0;
            $filePath = PUBLICPATH . 'extras/' . 'RombelTemp.json';
            $gtkFile = PUBLICPATH . 'extras/' . 'GtkTemp.json';
            write_file($filePath , '[');

            foreach($decoded as $d)
            {
                if(! $this->model->rombelExists($d->rombongan_belajar_id))
                {
                    $ptkTemp = file_get_contents($gtkFile);
                    $ptkArray = json_decode($ptkTemp, true);
                    if(count($ptkArray) > 0)
                    {
                        $filteredPtk = array_filter($ptkArray, function($item) use ($d) {
                            return $item['ptk_id'] === $d->ptk_id;
                        });

                        $ptkKey = array_search($d->ptk_id, array_column($ptkArray, 'ptk_id'));
                        $waliKelas = $filteredPtk[$ptkKey]['staff_id'];
                    }
                    else
                    {
                        $teacher = $this->model->getDefaultTeacher();
						$waliKelas = $teacher !== false ? $teacher->staff_id : null;
                    }

					if($waliKelas !== null) {
						$values = [
							'grade_name'        => $d->nama,
							'teacher_id'        => $waliKelas,
							'rombel_dapodik_id' => $d->rombongan_belajar_id
						];

						$gradeID = $this->model->insertRombel($values);

						$rombelTemp = '{"grade_id": ' . '"' . $gradeID . '"' .
								', "rombel_id": ' . '"' . $d->rombongan_belajar_id . '"' .
								', "nama": ' . '"' . $d->nama . '"' . '},';
						write_file($filePath, $rombelTemp, 'a');

						$inserted++;
					} else {
						$skippedRombel++;
					}

                }
            }

            write_file($filePath, ']', 'a');

            // remove trailing comma
            $rombelFile = file_get_contents($filePath);
            $rombelFile = str_replace(',]', ']', $rombelFile);
            file_put_contents($filePath, $rombelFile);

            if($inserted === 0)
            {
				if($skippedRombel === 0) {
					$note = 'Tidak ada rombel baru yang ditambahkan';
				} else {
					$note = "$skippedRombel rombel tidak dapat diimpor karena data guru masih kosong.";
				}
            }
            else
            {
                $note = "{$inserted} rombel telah berhasil ditambahkan.";
            }

            return $this->response->setJSON(['msg' => 'OK', 'note' => $note]);
        }
    }

    public function gtk()
    {
        if(is_admin())
        {
            $data = $this->request->getPost('data');
			$imporPtk = $this->request->getPost('ptk');
			$inserted = 0;
			if($imporPtk === 'yes') {
				$decoded = json_decode($data);
				$filePath = PUBLICPATH . 'extras/' . 'GtkTemp.json';
				write_file($filePath , '[');
				foreach($decoded as $d)
				{
					if($d->status_kepegawaian_id === 1 || $d->status_kepegawaian_id === 11)
					{
						$staffNik = $d->nip;
					}
					else
					{
                        $staffNik = $d->nik;
					}

					if($d->jenis_ptk_id !== '3' && $d->jenis_ptk_id !== '4')
					{
						$staffType = 'staff';
					}
					else
					{
						$staffType = 'teacher';
					}

					$username = $this->createUsername($d->nama);

					// insert only if employee is not exist
					if(! $this->model->pegawaiExists($staffNik))
					{
						$values = [
							'staff_nik'             => $staffNik,
							'staff_name'            => $d->nama,
							'staff_phone'           => null,
							'staff_type'            => $staffType,
							'staff_title'           => $d->jenis_ptk_id_str,
							'user_name'             => $d->nama,
							'user_email'            => $username,
							'user_password'         => '@Pegawai123',
							'featured_image'        => null,
							'current_image'         => null,
						];

						$staffID = $this->model->insertPegawai($values);

						$ptkId = '{"staff_id": ' . '"' . $staffID . '"' .
								', "ptk_id": ' . '"' . $d->ptk_id . '"' .
								', "nama": ' . '"' . $d->nama . '"' . '},';
						write_file($filePath, $ptkId, 'a');

						$inserted++;
					}
				}

				write_file($filePath, ']', 'a');

				// remove trailing comma
				$ptkFile = file_get_contents($filePath);
				$ptkFile = str_replace(',]', ']', $ptkFile);
				file_put_contents($filePath, $ptkFile);
			}

            if($inserted === 0)
            {
                $note = 'Tidak ada pegawai baru yang ditambahkan';
            }
            else
            {
                $note = "{$inserted} pegawai telah berhasil ditambahkan.";
            }

            return $this->response->setJSON(['msg' => 'OK', 'note' => $note, 'import' => $imporPtk]);
        }
    }

    public function pesertaDidik()
    {
        if(is_admin())
        {
            $data = $this->request->getPost('data');
            $option = $this->request->getPost('option');
			$level = $this->request->getPost('tingkat');
            $decoded = json_decode($data);
            $inserted = 0;
            if($option !== 'pdBaru')
            {
                $inserted = $this->pushPesertaDidik($decoded);
            }
            else
            {

                $firstGrade = array_filter($decoded, function($item) use ($level) {
                    return $item->tingkat_pendidikan_id === $level;
                });

                $inserted = $this->pushPesertaDidik($firstGrade);
            }

            if($inserted === 0)
            {
                $note = 'Tidak ada data peserta didik yang ditambahkan.';
            }
            else
            {
                $note = "{$inserted} peserta didik telah berhasil ditambahkan.";
            }

            return $this->response->setJSON(['msg' => 'OK', 'note' => $note]);
        }
    }

    private function pushPesertaDidik($data)
    {
        $filePath = PUBLICPATH . 'extras/' . 'PdTemp.json';
        write_file($filePath , '[');
        $inserted = 0;
        foreach($data as $d)
        {
            if($d->nama_ayah !== null)
            {
                $userEmail = $this->createUsername($d->nama_ayah);
                $userName = $d->nama_ayah;
            }
            else
            {
                $userEmail = $this->createUsername($d->nama_ibu);
                $userName = $d->nama_ibu;
            }

            $parentValues = [
                'parent_family_card'    => $d->nik,
                'parent_father_name'    => $d->nama_ayah,
                'parent_mother_name'    => $d->nama_ibu,
                'parent_phone_number'   => $d->nomor_telepon_seluler,
                'user_name'             => $userName,
                'user_email'            => $userEmail,
                'user_password'         => '@ortuku123',
            ];

            $checkOrangTua = $this->model->orangTuaExists($d->nama_ayah, $d->nama_ibu, $d->nomor_telepon_seluler);
            if($checkOrangTua === false)
            {
                $parentID = $this->model->insertOrangTua($parentValues);
            }
            else
            {
                $parentID = $checkOrangTua->parent_id;
            }

            if(! $this->model->pesertaDidikExists($d->nipd, $d->nama))
            {
                $studentValues = [
                    'student_nis'   => $d->nipd,
                    'student_name'  => $d->nama,
                    'parent_id'     => $parentID
                ];

                $studentID = $this->model->insertPesertaDidik($studentValues);

                $pesdik = '{"student_id": ' . '"' . $studentID . '"' .
                        ', "pd_id": ' . '"' . $d->peserta_didik_id . '"' .
                        ', "rombel_id": ' . '"' . $d->rombongan_belajar_id . '"' .
						', "anggota_rombel_id": ' . '"' . $d->anggota_rombel_id . '"' .
                        ', "nama": ' . '"' . $d->nama . '"' . '},';
                write_file($filePath, $pesdik, 'a');

                $inserted++;
            }

        }

        write_file($filePath, ']', 'a');

        // remove trailing comma
        $pdFile = file_get_contents($filePath);
        $pdFile = str_replace(',]', ']', $pdFile);
        file_put_contents($filePath, $pdFile);

        return $inserted;
    }

    private function createUsername($name)
    {
        $remove = ['.', ' ', "'"];
        $replace = ['', '.', ''];
        $clean = str_replace($remove, $replace, $name);

        return strtolower($clean);
    }
}
