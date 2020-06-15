<?php namespace Actudent\Guru\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GuruFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        if(session('email') === null || session('userLevel') !== '2')
        {
            return redirect()->to(base_url('guru/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}