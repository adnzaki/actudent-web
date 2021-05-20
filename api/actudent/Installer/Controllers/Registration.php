<?php namespace Actudent\Installer\Controllers;

class Registration extends \Actudent\Core\Controllers\Actudent
{
    public function __construct()
    {
        // set app language based on default language
        $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';
        $this->setLanguage($defaultLang);
    }

    public function index()
    {
        if(ENVIRONMENT === 'development')
        {
            if(session('org_id') !== null)
            {
                $data                       = $this->common();
                $data['title']              = lang('Registration.register_title');    
                $data['organizationName']   = session('org_name');
        
                return parse('Actudent\Installer\Views\registrasi\registrasi-view', $data);
            }
            else
            {
                echo access_denied();
            }
        }
        else 
        {
            echo access_denied();
        }
    }
}