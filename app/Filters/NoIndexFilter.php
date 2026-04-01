<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NoIndexFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // No hacemos nada antes
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}