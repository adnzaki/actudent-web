<?php namespace Actudent\Core\Controllers;

class Resources extends Actudent
{
    /**
     * Get changelog
     * 
     * @param string $lang
     * 
     * @return array
     */
    public function getChangelog($lang = 'indonesia')
    {
        $result = [
            'changelog' => [],
            'countChangelog' => 0,
        ];

        if(isset($_SESSION['userLevel']))
        {
            if($_SESSION['userLevel'] === '1')
            {
                $changelog = $this->adminChangelog($lang);
            }
            elseif($_SESSION['userLevel'] === '2')
            {
                $changelog = $this->guruChangelog($lang);
            }

            $result =  [
                'changelog' => $changelog,
                'countChangelog' => $this->countChangelog($changelog),
            ];
        }

        return $result;
    }

    /**
     * Count the number of changelog
     * If no changelog detected, '!' sign will be provided
     * 
     * @param string $changelog
     * 
     * @return string|int
     */
    private function countChangelog($changelog)
    {
        if(strpos($changelog, '-') === false)
        {
            return '!';
        }
        else
        {
            return count(explode('-', $changelog)) - 1;
        }
    }

    /**
     * Admin changelog
     * 
     * @param string $lang
     * 
     * @return array
     */
    private function adminChangelog($lang)
    {
        $changelog = [
            'indonesia' => [
                "- Pembaruan latar belakang sistem Actudent
                - [Kehadiran] Memperbaiki urutan jadwal pada laporan absen harian
                - [Dashboard] Menambahkan informasi agenda dan linimasa terkini
                - [Pesan] Memperbaiki penghitung pesan belum dibaca di menu samping
                - [Pengguna] Mengembalikan menu tambah dan hapus pengguna
                - [Info] Pastikan anda menggunakan browser versi terbaru (tidak mendukung Internet Explorer)"
            ],
            'english' => [
                "- Actudent system background updates
                - [Presence] Fixed wrong schedule time order on daily presence report
                - [Dashboard] Added recent agenda and timeline information
                - [Message] Fixed wrong unread messages counter on side menu
                - [Users] Return add and delete user menu
                - [Info] Please ensure that you have the latest version of your browser (not supported in Internet Explorer)"
            ]
        ];

        return $changelog[$lang][0];
    }

    /**
     * Teacher changelog
     * 
     * @param string $lang
     * 
     * @return array
     */
    private function guruChangelog($lang)
    {
        $changelog = [
            'indonesia' => [
                "- Pembaruan latar belakang sistem Actudent
                - [Kehadiran] Memperbaiki urutan jadwal pada laporan absen harian
                - [Dashboard] Menambahkan informasi agenda dan linimasa terkini
                - [Pesan] Memperbaiki penghitung pesan belum dibaca di menu samping
                - [Info] Pastikan anda menggunakan browser versi terbaru (tidak mendukung Internet Explorer)"
            ],
            'english' => [
                "- Actudent system background updates
                - [Presence] Fixed wrong schedule time order on daily presence report
                - [Dashboard] Added recent agenda and timeline information
                - [Message] Fixed wrong unread messages counter on side menu
                - [Info] Please ensure that you have the latest version of your browser (not supported in Internet Explorer)"
            ]
        ];

        return $changelog[$lang][0];
    }

    /**
     * Admin locale resources
     * Provide set of files needed by the JS to be loaded
     * 
     * @param string $files
     * @return void
     */
    public function getLocaleResource($file)
    {
        if(isset($_SESSION['email']))
        {
            $bahasa = $this->getUserLanguage();
        }
        elseif(isset($_SESSION['actudent_lang']))
        {
            $bahasa = $_SESSION['actudent_lang'];
        }
        else 
        {
            $bahasa = 'indonesia';
        }

        if(isset($_SESSION['email']))
        {
            $file = $file;
        }
        else 
        {
            $file = 'AdminAuth';
        }
        
        $lang = require APPPATH . "Language/{$bahasa}/{$file}.php";
        return $this->response->setJSON($lang);
    }
}