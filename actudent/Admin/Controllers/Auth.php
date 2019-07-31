<?php namespace Actudent\Admin\Controllers;

use Actudent\Core\Controllers\Actudent;
use Actudent\Admin\Models\AuthModel;

class Auth extends \CodeIgniter\Controller
{
    /**
     * @var Actudent\Core\Models\AuthModel
     */
    private $auth;

    /**
     * Auth class constructor
     * Call all classes needed in this controller 
     * 
     * @return void
     */
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

            // mengatur bahasa awal aplikasi ketika belum ada pilihan bahasa dari pengguna
            // atur bahasa awal ke bahasa Indonesia jika belum ada session 'actudent_lang
            $defaultLang = $_SESSION['actudent_lang'] ?? 'indonesia';

            // set bahasa aplikasi berdasarkan bahasa awal
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
        // simpan pilihan bahasa pengguna setelah dia logout dari aplikasi
        Actudent::setLanguage(Actudent::getUserLanguage());
        $this->auth->statusJaringan('offline', $_SESSION['email']);
        Actudent::$session->remove(['email', 'nama', 'userLevel', 'logged_in']);
        return redirect()->to(site_url('admin/login'));
    }
}