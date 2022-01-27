<?php namespace Actudent\Core\Controllers;

class Error extends \Actudent
{
    public function show404()
    {
        $data           = $this->common();
        $data['title']  = lang('Error.lost_title');

        $data['homeURL'] = $this->homeUrl();
        $data['host']   = get_host();
        echo parse('Actudent\Core\Views\error404', $data);
    }
    
    private function homeUrl()
    {
        if(ENVIRONMENT === 'production')
        {
            return get_host();
        }
        else 
        {
            return 'http://' . get_host() . '/actudent/app';
        }
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