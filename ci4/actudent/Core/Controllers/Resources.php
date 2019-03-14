<?php namespace Actudent\Core\Controllers;

use Actudent\Core\Controllers\Actudent;

class Resources extends \CodeIgniter\Controller
{

    private $actudent;

    public function __construct()
    {
        $this->actudent = new Actudent;
    }

    public function adminLocaleResource()
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
        
        $lang = require APPPATH . 'Language/' . $bahasa . '/Admin.php';
        echo json_encode($lang);
    }
}