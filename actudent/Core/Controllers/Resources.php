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

            return [
                'changelog' => $changelog,
                'countChangelog' => count(explode('-', $changelog)) - 1,
            ];
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
                "- [Login] Menambahkan gambar latar belakang di halaman login
                - [Beranda] Memperbaiki nilai maksimal pada chart
                - [Navbar] Menambahkan tombol tampilkan changelog di sebelah tombol akun"
            ],
            'english' => [
                "- [Login] Added background image in login page
                - [Dashboard] Fixed maximum value on chart
                - [Navbar] Added show changelog button beside account button"
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
                "- [Login] Menambahkan gambar latar belakang di halaman login
                - [Beranda] Memperbaiki nilai maksimal pada chart
                - [Menu] Menghapus menu pengguna
                - [Jadwal dan Kehadiran] Memperbaiki urutan jadwal
                - [Navbar] Menambahkan tombol tampilkan changelog di sebelah tombol akun"
            ],
            'english' => [
                "- [Login] Added background image in login page
                - [Dashboard] Fixed maximum value on chart
                - [Menu] Removed user menu
                - [Schedule and Presence] Fixed schedule order
                - [Navbar] Added show changelog button beside account button"
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