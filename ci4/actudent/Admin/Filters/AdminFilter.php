<?php namespace Actudent\Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $session = Services::session();
        if($session->get('email') === null)
        {
            return redirect()->to(site_url('admin/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}