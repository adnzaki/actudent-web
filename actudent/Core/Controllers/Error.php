<?php namespace Actudent\Core\Controllers;

class Error extends Actudent
{
    public function show404()
    {
        $data           = $this->common();
        $data['title']  = lang('Error.lost_title');
        
        $match = preg_match('/admin/', current_url());
        ($match === 1) ? $section = 'admin' : $section = 'guru';

        $data['homeURL'] = base_url("$section/home");
        echo $this->parser->setData($data)
            ->render('Actudent\Core\Views\error404');
    }    

    public function expiredPage()
    {
        // set default language
        $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';        
        $this->setLanguage($defaultLang);

        $data           = $this->common();
        $data['title']  = lang('Error.expired_title');

        return $this->parser->setData($data)->render('Actudent\Core\Views\expired-page');
    }
}