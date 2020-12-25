<?php namespace Actudent\Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Actudent\Core\Models\AuthModel;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $cookie = get_cookie('remember_login');
        $auth = new AuthModel();
        $userToken = $auth->getUserToken($cookie);
        if(session('email') === null || session('userLevel') !== '1')
        {
            if(! $userToken)
            {
                return redirect()->to(base_url('admin/login'));                
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

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}