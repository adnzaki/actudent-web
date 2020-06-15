<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Template extends Actudent
{
    public function icons()
    {
        if(ENVIRONMENT === 'development')
        {
            $data = $this->common();
            $data['title'] = 'Template Icons';
            return $this->parser->setData($data)
                    ->render('Actudent\Admin\Views\template\icons');
        }
        else
        {
            return redirect()->to(base_url('admin/home'));
        }
    }   
    
    public function buttons()
    {
        if(ENVIRONMENT === 'development')
        {
            $data = $this->common();
            $data['title'] = 'Template Buttons';
            return $this->parser->setData($data)
                    ->render('Actudent\Admin\Views\template\buttons');            
        }
        else 
        {
            return redirect()->to(base_url('admin/home'));
        }
    }
}