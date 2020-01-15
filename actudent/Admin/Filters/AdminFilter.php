<?php namespace Actudent\Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        if(session('email') === null || session('userLevel') !== '1')
        {
            return redirect()->to(base_url('admin/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}