<?php namespace Actudent\Core\Controllers;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-type');

use Config\Services;

class Resources extends \Actudent
{
    /**
     * Notify user if active period has been 7 days left
     * 
     * @return JSON
     */
    public function showExpirationNotification()
    {
        $subs = new \Actudent\Core\Models\SubscriptionModel;
        $package = $subs->getPackageDetail();
        $diff = os_date()->diff($package->shortDate, os_date()->shortDate(), 'num-only');

        return $this->createResponse([
            'left'  => $diff,
            'date'  => $package->expiration,
            'text'  => lang('AdminLangganan.subs_active_left', [$diff]),
        ]);
    }

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

    public function getReportData()
    {
        $schoolModel = new \Actudent\Core\Models\SekolahModel;
        $sekolah = $schoolModel->getDataSekolah()[0];
        $letterhead = $this->getSchoolLetterHead();

        return [
            'namaSekolah'           => $sekolah->school_name ?? '',
            'alamatSekolah'         => $sekolah->school_address ?? '',
            'lokasiSekolah'         => $letterhead->city ?? '',
            'emailSekolah'          => $letterhead->email ?? '',
            'webSekolah'            => $letterhead->website ?? '',
            'telpSekolah'           => $sekolah->school_telephone ?? '',
            'domainSekolah'         => $sekolah->school_domain ?? '',
            'logoSekolah'           => $letterhead->school_logo ?? '',
            'logoOPD'               => $letterhead->opd_logo ?? '',
            'namaOPD'               => $letterhead->opd_name ?? '',
            'subOPD'                => $letterhead->sub_opd_name ?? '',
            'kepalaSekolah'         => $letterhead->headmaster ?? '',
            'wakaKurikulum'         => $letterhead->co_headmaster ?? '',
            'nipKepsek'             => $letterhead->headmaster_nip ?? '',
            'nipWakasek'            => $letterhead->co_headmaster_nip ?? '',
        ];
    }

    /**
     * Get school letterhead
     * 
     * @return object
     */
    public function getSchoolLetterHead()
    {
        if(valid_token())
        {
            $schoolModel = new \Actudent\Core\Models\SekolahModel;
            $sekolah = $schoolModel->getDataSekolah()[0];
            return json_decode($sekolah->school_letterhead);
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
     * Get locale for login page only that does not require authentication
     * 
     * @param string $file | file to be loaded
     * @param string $lang
     * 
     * @return JSON
     */
    public function getLocale($file, $lang)
    {
        $response = require APPPATH . "Language/{$lang}/{$file}.php";

        return Services::response()->setJSON($response);
    }
}