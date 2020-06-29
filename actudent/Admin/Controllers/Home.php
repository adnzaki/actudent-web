<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;

class Home extends Actudent
{
    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Actudent CI4 Home';
        $data['changelog'] = "- [Staff] Fixed bug on filtering data
        - [Timeline] Added edit post feature
        - [Timeline] Added remove post feature
        - [Timeline] Added read post view";
        return $this->parser->setData($data)
                ->render('Actudent\Admin\Views\dashboard\home');
    }

    public function goToHome()
    {
        return redirect()->to(base_url('admin/home'));
    }

    public function showQuery()
    {
        echo $this->auth->showPenggunaQuery('admin@wolestech.com');
    }
}