<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AuthModel;

class Auth extends \CodeIgniter\Controller
{
    /**
     * @var Actudent\Core\Models\AuthModel
     */
    private $auth;

    public function __construct()
    {
        new Actudent;
        $this->auth = new AuthModel;
    }

    public function index()
    {
        if(isset($_SESSION['email']) && isset($_SESSION['userLevel']) === '1')
        {
            return redirect()->to(site_url('admin/home'));
        }
        else 
        {            
            $data = Actudent::common();

            // set default language when no there is no language option
            // default language will be set to Bahasa Indonesia if there is no session found
            $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';

            // set app language based on default language
            Actudent::setLanguage($defaultLang);
            $data['title'] = 'Autentikasi';
            return Actudent::$parser->setData($data)
                ->render('Actudent\Admin\Views\auth');
        }        
    }

    public function validasi()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        if($this->auth->validasi($username, $password))
        {
            $pengguna = $this->auth->getDataPengguna($username);
            $session = [
                'id'        => $pengguna->user_id,
                'email'     => $username,
                'nama'      => $pengguna->user_name,
                'userLevel' => $pengguna->user_level,
                'logged_in' => true
            ];
            Actudent::$session->set($session);
            $this->auth->statusJaringan('online', $username);
            echo 'valid';
        }
        else 
        {
            echo 'invalid';
        }
    }

    public function logout()
    {
        // save language option after user has been logged out from the app
        Actudent::setLanguage(Actudent::getUserLanguage());
        $this->auth->statusJaringan('offline', $_SESSION['email']);
        Actudent::$session->remove(['email', 'nama', 'userLevel', 'logged_in']);
        return redirect()->to(site_url('admin/login'));
    }
}