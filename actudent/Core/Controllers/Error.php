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
        echo parse('Actudent\Core\Views\error404', $data);
    }    

    public function expiredPage()
    {
        $subscription = new \Actudent\Core\Models\SubscriptionModel();

        if(! $subscription->hasExpired())
        {
            return redirect()->to(base_url('admin/home'));
        }
        else
        {
            // set default language
            $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';        
            $this->setLanguage($defaultLang);
    
            $data           = $this->common();
            $data['title']  = lang('Error.expired_title');
    
            return parse('Actudent\Core\Views\expired-page', $data);
        }
    }
}