<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AuthModel;

class Home extends \CodeIgniter\Controller
{
    /**
     * @var Actudent\Admin\Models\AuthModel
     */
    private $auth;

    public function __construct()
    {
        new Actudent;
        $this->auth = new AuthModel;
    }

    public function index()
	{
        $data = Actudent::common();
        $data['title'] = 'Actudent CI4 Home';
        return Actudent::$parser->setData($data)
                ->render('Actudent\Admin\Views\dashboard\home');
    }

    public function goToHome()
    {
        return redirect()->to(site_url('admin/home'));
    }

    public function showQuery()
    {
        echo $this->auth->showPenggunaQuery('admin@wolestech.com');
    }
}