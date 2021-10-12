<?php namespace Actudent\Sync\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Actudent\Sync\Models\SyncModel;

class Sync extends \Actudent\Core\Controllers\Actudent
{
    private $model;

    private $errorMessage = "Data sudah terisi, penarikan dari Dapodik hanya ditujukan untuk data yang masih kosong.
                             Silakan pilih opsi 'Peserta Didik Baru' jika anda hanya ingin memasukkkan siswa pada tingkat awal";

    public function __construct()
    {
        $this->model = new SyncModel;
    }

    public function pesertaDidik()
    {
        if(is_admin())
        {
            $data = $this->request->getPost('data');
            $option = $this->request->getPost('option');
            $response = '';
            $decoded = json_decode($data);
            if($option === 'semua')
            {
                if($this->model->pesertaDidikEmpty())
                {
                    $this->pushPesertaDidik($decoded);
                    $response = 'OK';
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
            }           
            
            return $this->response->setJSON(['msg' => $response]);
        }        
    }

    private function pushPesertaDidik($data)
    {
        foreach($data as $d)
        {
            if($d->nama_ayah !== null)
            {
                $userEmail = $this->createParentUserNameAccount($d->nama_ayah);
                $userName = $d->nama_ayah;
            }
            else
            {
                $userEmail = $this->createParentUserNameAccount($d->nama_ibu);
                $userName = $d->nama_ibu;
            }            

            $parentValues = [
                'parent_family_card'    => null,
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

    private function createParentUserNameAccount($name)
    {        
        $remove = ['.', ' ', "'"];
        $replace = ['', '.', ''];
        $clean = str_replace($remove, $replace, $name);

        return strtolower($clean);
    }
}