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
                "Halo Sobat Actudent, saat ini kami sedang menyiapkan fitur Nilai. Progress
                pengembangan fitur ini bisa dilihat di Instagram resmi @wolestech."
            ],
            'english' => [
                "Hello Actudent Friends, we are currently working on Scores feature. Development
                progress of this feature can be seen at our official Instagram @wolestech."
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
        $$changelog = [
            'indonesia' => [
                "Halo Sobat Actudent, saat ini kami sedang menyiapkan fitur Nilai. Progress
                pengembangan fitur ini bisa dilihat di Instagram resmi @wolestech."
            ],
            'english' => [
                "Hello Actudent Friends, we are currently working on Scores feature. Development
                progress of this feature can be seen at our official Instagram @wolestech."
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