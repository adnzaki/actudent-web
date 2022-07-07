<?php

/**
 * ACTUDENT - Attitude Control for Student
 * This is the core of Actudent web app version. Everything is set to make this source
 * code maintainable for long-time use.
 * Every controller must extend this class in order to make this app runs as expected
 * 
 * @copyright   Wolestech (c) 2021
 * @author      WolesDev Team
 * @version     1.1.0
 */

use Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Actudent\Core\Models\SekolahModel;
use Actudent\Core\Models\AuthModel;
use Actudent\Core\Controllers\Resources;
use Actudent\Admin\Models\PesanModel;

class Actudent extends \CodeIgniter\Controller
{
    /**
     * SekolahModel
     * 
     * @var object
     */
    protected $sekolah;

    /**
     * AuthModel
     * 
     * @var object
     */
    protected $auth;

    /**
     * Core resources 
     *  
     * @var object
     */    
    protected $resources;

    /**
     * PesanModel
     * 
     * @var object
     */
    protected $pesan;

    /**
     * @var \CodeIgniter\Validation\Validation
     */
    protected $validation;

    /**
     * HTTP Status
     * 
     * @var string
     */
    protected $status = [
        112 => 'Service expired',
        113 => 'Subscription valid',
        200 => 'Token validated.',
        500 => 'Internal Server Error',
        503 => 'Unauthorized Access'
    ];

    /**
     * Initialize any classes needed and core helper for this class
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // preload services
        $this->sekolah  = new SekolahModel;
        $this->auth     = new AuthModel;
        $this->resources= new Resources;
        $this->pesan    = new PesanModel;
        $this->validation = Services::validation();
        helper([
            'Actudent\Core\Helpers\ostium', 
            'Actudent\Core\Helpers\wolesdev',
        ]);
    }

    public function getLanguage()
    {
        return $this->loadSettings()->lang;
    }

    protected function loadSettings()
    {
        $path = PUBLICPATH . 'settings.json';
        $settings = file_get_contents($path);

        return json_decode($settings);
    }

    /**
     * Create Response for any request from user.
     * Each request will be validated here before the response sent.
     * There are 3 available validators for each request,
     * the default one is valid_token() to make it available
     * for both section: Admin and Teacher. Other validators are
     * is_admin() and is_teacher() that means the response only available
     * for admin or teacher
     * 
     * @param array $response
     * @param string $validator
     * 
     * @return JSON
     */
    protected function createResponse($response, $validator = 'valid_token')
    {
        if($validator())
        {
            return $this->response->setJSON($response);
        }
        else
        {
            return $this->response->setJSON($this->setStatus(503));
        }
    }

    /**
     * Set HTTP Status code
     * 
     * @param int $code
     * 
     * @return array
     */
    protected function setStatus($code)
    {
        return [
            'status'    => $code,
            'msg'       => $this->status[$code]
        ];
    }
    
    /**
     * Function that supplies global variables for the whole app
     * 
     * @return array
     */
    protected function common()
    {
        $data = [
            'base_url'              => base_url(),
            'assets'                => base_url() . '/assets/',
            'appAssets'             => base_url() . '/app-assets/',
            'css'                   => base_url() . '/css/',
            'fonts'                 => base_url() . '/fonts/',
            'images'                => base_url() . '/images/',
            'admin'                 => base_url() . '/admin/',  
            'guru'                  => base_url() . '/guru/',
            'newLogin'              => base_url() . '/admin-login/',
            'install'               => base_url() . '/install/',
        ];

        return $data;
    }

    public function reportStyle()
    {
        return view('Actudent\Core\Views\report\style');
    }

    /**
     * The PDF report header
     */
    public function reportHeader()
    {
        return view('Actudent\Core\Views\report\kop-sekolah');
    }

    /**
     * Headmaster sign for PDF Report
     */
    public function masterSign()
    {
        return view('Actudent\Core\Views\report\tanda-tangan-full');
    }

    /**
     * Headmaster sign for PDF Report
     */
    public function homeroomSign()
    {
        return view('Actudent\Core\Views\report\tanda-tangan-walikelas');
    }

    /**
     * Grade leader sign
     */
    public function gradeLeaderSign()
    {
        return view('Actudent\Core\Views\report\tanda-tangan');
    }

    /**
     * Get user's data who has been logged in
     * 
     * @return object
     */
    protected function getDataPengguna($token = '')
    {
        if(valid_token($token))
        {
            $inputToken = empty($token) ? bearer_token() : $token;
            $decodedToken = jwt_decode($inputToken);
            return $this->auth->getDataPengguna($decodedToken->email);
        }
    }
}