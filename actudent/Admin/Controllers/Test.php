<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Core\Libraries\Tcpdf\Pdf;
use Actudent\Core\Libraries\FpdfRunner;

class Test extends Actudent
{
    public function testPdf()
    {
        $pdf = new Pdf();
        $pdf->run();
        //echo 'Ini bukan pdf';
    }

    public function testMatch()
    {
        $match = 'PengaturanAplikasi';
        preg_match_all('/[A-Z]/', $match, $matches);
        $split = preg_split('/[A-Z]/', $match);
        if(count($matches[0]) > 0)
        {
            $str = '';
            for($i = 0; $i < count($matches[0]); $i++)
            {
                $strip = (count($matches[0]) - $i !== 1) ? '-' : '';
                $str .= strtolower($matches[0][$i]) . $split[$i+1] . $strip;
            }
        }
        echo $str;
    }

    public function testFunction()
    {
        $subs = new \Actudent\Core\Models\SubscriptionModel;
        $expired = $subs->hasExpired() ? 1 : 0;
        print_r($subs->getLimit());
    }

    public function resultToArray()
    {
        $jadwal = new \Actudent\Admin\Models\JadwalModel;
        $query = $jadwal->QBMapelKelas->select('lesson_id')->get()->getResultArray();
        //print_r($query);
        //return $this->response->setJSON($query);
        print_r($jadwal->searchLessons('ba', 2));
    }

    public function getAttPath()
    {
        $data = $this->testData();
        $data['tempat_lahir'] = 'Jakarta';
        print_r($data);
    }

    public function arrayEach()
    {
        $array = ['2-1', '3-5'];
        foreach($array as $arr)
        {
            echo '<' . $arr . '>';
        }
    }

    public function insertIDTest()
    {
        $model = new \Actudent\Admin\Models\AgendaModel;
        $data = [
            'agenda_name'           => 'Realisasi Sekolah Model',
            'agenda_start'          => '2019-06-26 11:00:00',
            'agenda_end'            => '2019-06-26 16:00:00',
            'agenda_description'    => 'Mohon dilaksanakan dengan sebaik-baiknya',
            'agenda_priority'       => 'high',
            'agenda_location'       => 'Sekolah',
        ];
        
        $model->insert($data);
    }

    public function testData()
    {
        // alokasi 1 jam pelajaran dalam menit
        $alokasi = 40;

        // waktu pelajaran dimulai setiap hari pukul 07.00
        $mulai = 7;

        // alokasi jam pelajaran hari Senin (misalnya)
        $mapel = [
            'mtk' => 2,
            'pkn' => 2,
            'istirahat1' => 20,
            'bindo' => 2,
            'pai' => 2,
            'istirahat2' => 60,
        ];

        $mapel = $this->exactDuration($mapel, $alokasi);

        // durasi sesungguhnya
        $durasiMapel = [];
        foreach($mapel as $key => $val)
        {
            $penambah = $val / 60;
            $selesai = $mulai + $penambah;
            $final = $this->convertToMinute($selesai);
            $printSelesai = floor($selesai) . '.' . $this->normalizeTime($final);

            if(gettype($mulai) !== 'integer')
            {
                $minute = $this->convertToMinute($mulai);
            }
            else
            {
                $minute = '0';
            }

            $durasiMapel[$key] =  [
                'durasi' => "$val menit",
                'mulai' => $this->normalizeTime(floor($mulai)) . '.' . $this->normalizeTime($minute),
                'selesai' => $this->normalizeTime($printSelesai),
            ];

            $mulai = $selesai;
        }

        return $this->response->setJSON($durasiMapel);
    }

    private function convertToMinute($decimalValue)
    {
        $floatToMinute = $decimalValue * 60;
        return $floatToMinute % 60;
    }

    private function normalizeTime($value)
    {
        return ($value < 10) ? '0' . $value : $value;
    }

    private function exactDuration($array, $alokasi)
    {
        $formatted = [];

        foreach($array as $key => $val)
        {
            if(substr($key, 0, strlen($key) - 1) === 'istirahat')
            {
                $formatted[$key] = $val;
            }
            else 
            {
                $formatted[$key] = $val * $alokasi;
            }
        }

        return $formatted;
    }

    public function hash($password)
    {
        echo password_hash($password, PASSWORD_BCRYPT);
    }

    public function validateLogin()
    {
        $username = 'firhanyp@wolestech.com';
        $password = 'guruku123';   
        // $username = 'danyprastio@wolestech.com';
        // $password = 'admin123';   
        // $username = 'admin@wolestech.com';
        // $password = 'admin123';  
        $auth = new \Actudent\Core\Models\AuthModel;
        if($auth->validasi($username, $password, '2'))
        {
            echo 'sukses<br>';
        }
        else 
        {
            echo 'gagal<br>';
        }

        // $cari = $auth->user->where(['user_email' => $username]);
        // $hasil = $cari->get()->getResult();
        // if(password_verify($password, $hasil[0]->user_password))
        // {
        //     echo 'ini kok berhasil';
        // }
        // else 
        // {
        //     echo 'ini kok gagal';
        // }    
    }

    public function testIsAdmin()
    {
        $auth = new \Actudent\Admin\Models\AuthModel;
        // $username = 'firhanyp@wolestech.com';
        // $password = 'firhan123';   
        $username = 'danyprastio@wolestech.com';
        $password = 'dany1234';   
        if($auth->isAdmin($username))
        {
            echo 'ini admin';
        }
        else 
        {
            echo 'ini bukan admin';
        }
    }
}