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
                'countChangelog' => $this->countChangelog($changelog),
            ];
        }
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
                "- [PDF] Memperbaiki bug tidak bisa menampilkan PDF di browser
                - [PDF] Menambahkan logo sekolah dan unit organisasi di hasil cetak laporan
                - [Login] Mengganti tampilan baru untuk halaman login
                - [Login] Memperbaiki bug error di server saat memasukkan username yang tidak terdaftar"
            ],
            'english' => [
                "- [PDF] Fixed bug cannot display PDF on browser
                - [PDF] Added school and organization unit on report result
                - [Login] Changed new look for login page
                - [Login] Fixed bug server error when providing unregistered username"
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
                "- [PDF] Memperbaiki bug tidak bisa menampilkan PDF di browser
                - [PDF] Menambahkan logo sekolah dan unit organisasi di hasil cetak laporan
                - [Login] Memperbaiki bug error di server saat memasukkan username yang tidak terdaftar"
            ],
            'english' => [
                "- [PDF] Fixed bug cannot display PDF on browser
                - [PDF] Added school and organization unit on report result
                - [Login] Fixed bug server error when providing unregistered username"
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