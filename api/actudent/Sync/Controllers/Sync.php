<?php namespace Actudent\Sync\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Sync\Models\SyncModel;

class Sync extends \Actudent\Core\Controllers\Actudent
{
    private $model;

    private $errorMessage = "Data sudah terisi! Penarikan dari Dapodik hanya ditujukan untuk data yang masih kosong.
                             Silakan pilih opsi 'Peserta Didik Baru' jika anda hanya ingin memasukkkan siswa pada tingkat awal";

    public function __construct()
    {
        $this->model = new SyncModel;
        helper('filesystem');
    }

    public function gtk()
    {
        if(is_admin())
        {
            $data = $this->request->getPost('data');
            $decoded = json_decode($data);
            $inserted = 0;
            $filePath = PUBLICPATH . 'extras/' . 'GtkTemp.json';
            write_file($filePath , '[');
            foreach($decoded as $d)
            {
                if($d->status_kepegawaian_id === 1)
                {
                    $staffNik = $d->nip;
                }
                else 
                {
                    if($d->nuptk === null)
                    {
                        $staffNik = $d->nik;
                    }
                    else
                    {
                        $staffNik = $d->nuptk;
                    }
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

            if($inserted === 0)
            {
                $note = 'Tidak ada pegawai baru yang ditambahkan';
            }
            else 
            {
                $note = "{$inserted} pegawai telah berhasil ditambahkan.";
            }
            
            return $this->response->setJSON(['msg' => 'OK', 'note' => $note]);
        }
    }

    public function pesertaDidik()
    {
        if(is_admin())
        {
            $data = $this->request->getPost('data');
            $option = $this->request->getPost('option');
            $response = '';
            $decoded = json_decode($data);
            $inserted = 0;
            if($option === 'semua')
            {
                if($this->model->pesertaDidikEmpty())
                {
                    $this->pushPesertaDidik($decoded);
                    $response = 'OK';
                    $inserted = count($decoded);
                }
                else
                {
                    $response = $this->errorMessage;
                }
            }
            else 
            {
                $firstGrade = array_filter($decoded, function($item) {
                    return $item->tingkat_pendidikan_id === '1';
                });

                $this->pushPesertaDidik($firstGrade);
                $response = 'OK';
                $inserted = count($firstGrade);
            }    
            
            if($response !== 'OK')
            {
                $note = 'Tidak ada data peserta didik yang ditambahkan.';
            }
            else 
            {
                $note = "{$inserted} peserta didik telah berhasil ditambahkan.";
            }
            
            return $this->response->setJSON(['msg' => $response, 'note' => $note]);
        }        
    }

    private function pushPesertaDidik($data)
    {
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

            $studentValues = [
                'student_nis'   => $d->nipd,
                'student_name'  => $d->nama,
                'parent_id'     => $parentID
            ];

            $this->model->insertPesertaDidik($studentValues);
        }
    }

    private function createUsername($name)
    {        
        $remove = ['.', ' ', "'"];
        $replace = ['', '.', ''];
        $clean = str_replace($remove, $replace, $name);

        return strtolower($clean);
    }
}