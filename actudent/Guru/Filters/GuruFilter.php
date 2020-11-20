<?php namespace Actudent\Guru\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Actudent\Core\Models\AuthModel;

class GuruFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $cookie = get_cookie('remember_login');
        $auth = new AuthModel();
        $userToken = $auth->getUserToken($cookie);
        if(session('email') === null || session('userLevel') !== '2')
        {
            if(! $userToken)
            {
                return redirect()->to(base_url('guru/login'));            
            }
            else
            {
                $decodeCookie = base64_decode($userToken);
                $userData = explode('-', $decodeCookie);
                $pengguna = $auth->getDataPengguna($userData[0]);
                $session = [
                    'id'        => $pengguna->user_id,
                    'email'     => $userData[0],
                    'nama'      => $pengguna->user_name,
                    'userLevel' => $pengguna->user_level,
                    'logged_in' => true
                ];
                session()->set($session);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}