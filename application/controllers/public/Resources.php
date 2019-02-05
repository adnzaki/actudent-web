<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources extends Actudent
{
    public function language()
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
        
        require APPPATH . 'language/' . $bahasa . '/actudent_lang.php';
        echo json_encode($lang);
    }
}