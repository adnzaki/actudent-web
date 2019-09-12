<?php namespace Actudent\Core\Controllers;

class Error extends Actudent
{
    public function show404()
    {
        $data = $this->common();
        $data['title'] = lang('Error.lost_title');
        echo $this->parser->setData($data)
            ->render('Actudent\Core\Views\error404');
    }    
}