<?php namespace Actudent\Core\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Actudent\Core\Models\SubscriptionModel;

class CoreFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $subscription = new SubscriptionModel();

        if($subscription->hasExpired())
        {
            return redirect()->to(base_url('service-expired'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}