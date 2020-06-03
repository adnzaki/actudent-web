<?php namespace Actudent\Guru\Controllers;

use Actudent\Core\Controllers\Actudent;

class Home extends Actudent
{
    public function index()
	{
        $data = $this->common();
        $data['title'] = 'Actudent CI4 Home';
        return $this->parser->setData($data)
                ->render('Actudent\Guru\Views\dashboard\home');
    }

    public function goToHome()
    {
        return redirect()->to(base_url('guru/home'));
    }

    public function showQuery()
    {
        echo $this->auth->showPenggunaQuery('admin@wolestech.com');
    }
}