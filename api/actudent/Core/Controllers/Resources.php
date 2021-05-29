<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Config\Services;

class Resources extends Actudent
{
    /**
     * Subscription check
     * 
     * @return mixed
     */
    public function checkSubscription()
    {
        $subscriber = new \Actudent\Core\Models\SubscriptionModel;
        if($subscriber->hasExpired())
        {
            $response = $this->setStatus(112);
        }
        else 
        {
            $response = $this->setStatus(113);
        }

        return $this->response->setJSON($response);
    }
    /**
     * Validate user token before they navigate to any routes
     * in Actudent user inteface
     * 
     * @param string $validator | is_admin, is_teacher, valid_token
     * 
     * @return mixed
     */
    public function validateToken($validator)
    {
        if($validator() !== true)
        {
            $status = $this->setStatus(503);
        }
        else
        {
            $status = $this->setStatus(200);
        }
        
        return $this->response->setJSON($status);
    }

    
    /**
     * Set language for User Interface
     * 
     * @return string
     */
    public function setUILanguage()
    {
        helper('Actudent\Core\Helpers\wolesdev');
        if(valid_token())
        {
            $decodedToken = jwt_decode(bearer_token());
            $auth = new \Actudent\Core\Models\AuthModel;
            $lang = $auth->getUserLanguage($decodedToken->email);
            \Config\Services::language($lang[0]->user_language);
        }
        else
        {
            return 'indonesia';
        }
    }

    /**
     * Get school data 
     * 
     * @return object
     */
    public function getSekolah()
    {
        if(valid_token())
        {
            $response = $this->sekolah->getDataSekolah()[0];
            return $this->createResponse($response);
        }
    }

    /**
     * Get user data based on token they have
     * 
     * @return JSON
     */
    public function getPengguna()
    {
        $response = $this->getDataPengguna();
        return $this->createResponse($response);
    }

    /**
     * Get locales for new user interface
     * 
     * @param string $lang
     * @param string $file | file to be loaded
     * 
     * @return mixed
     */
    public function getLocaleForUI($file)
    {
        if(valid_token())
        {
            // decode the token first using our magic auth helpers
            $decodedToken = jwt_decode(bearer_token());

            // get user language
            $auth = new \Actudent\Core\Models\AuthModel;
            $lang = $auth->getUserLanguage($decodedToken->email);

            // get the language file and throw the response
            $response = require APPPATH . "Language/{$lang[0]->user_language}/{$file}.php";
            return $this->createResponse($response);
        }
        else
        {
            return Services::response()->setJSON($this->setStatus(503));
        }
    }

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
            return count(explode('- ', $changelog)) - 1;
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
                "- [Pengaturan] Menambahkan tema baru: Soft Touch, sebagai alternatif dari tema Night Vision
                - [Pengguna] Menambahkan informasi pengelolaan pengguna 
                - [Autentikasi] Perbaikan bug error tidak bisa logout dari aplikasi
                - [Kehadiran] Perbaikan bug tidak bisa mengisi kehadiran
                - [Kehadiran] Perbaikan tata letak tombol-tombol menu 
                - [Dasbor] Memperbaiki urutan agenda terkini 
                - Memperbesar ukuran modal changelog"
            ],
            'english' => [
                "- [Settins] Added new theme: Soft Touch, as an alternative to Night Vision theme
                - [Users] Added user management information
                - [Auth] Fixed error unable to log out from the app
                - [Presence] Fixed bug unable to fill presence
                - [Presence] Fixed menu buttons layout
                - [Dashboard] Fixed recent agenda order
                - Enlarge changelog modal size"
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
                "- [Pengaturan] Menambahkan tema baru: Soft Touch, sebagai alternatif dari tema Night Vision
                - [Autentikasi] Perbaikan error tidak bisa logout dari aplikasi
                - [Kehadiran] Perbaikan bug tidak bisa mengisi kehadiran
                - [Kehadiran] Perbaikan tata letak tombol-tombol menu 
                - [Dasbor] Memperbaiki urutan agenda terkini
                - Memperbesar ukuran modal changelog"
            ],
            'english' => [
                "- [Settins] Added new theme: Soft Touch, as an alternative to Night Vision theme
                - [Auth] Fixed error unable to log out from the app
                - [Presence] Fixed bug unable to fill presence
                - [Presence] Fixed menu buttons layout
                - [Dashboard] Fixed recent agenda order
                - Enlarge changelog modal size"
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

        if(session('email') === null && session('actudent_lang') === null)
        {
            $file = 'AdminAuth';
        }
        
        $lang = require APPPATH . "Language/{$bahasa}/{$file}.php";
        return Services::response()->setJSON($lang);
    }
}