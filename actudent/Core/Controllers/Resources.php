<?php namespace Actudent\Core\Controllers;

use Actudent\Core\Controllers\Actudent;

class Resources extends \CodeIgniter\Controller
{

    private $actudent;

    public function __construct()
    {
        $this->actudent = new Actudent;
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
            $bahasa = $this->actudent->getUserLanguage();
        }
        elseif(isset($_SESSION['actudent_lang']))
        {
            $bahasa = $_SESSION['actudent_lang'];
        }
        else 
        {
            $bahasa = 'indonesia';
        }
        
        $lang = require APPPATH . "Language/{$bahasa}/{$file}.php";
        echo json_encode($lang);
    }
}