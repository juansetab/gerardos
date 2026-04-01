<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RateLimitFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        $ip        = $request->getIPAddress();
        $sessionId = session_id() ?? 'nosession';
        $path      = $request->getPath();

        $key = 'rate_' . md5($ip . $sessionId . $path);

        $limit = 5;      // intentos
        $window = 60;     // segundos

        $data = cache($key);

        if (!$data) {
            cache()->save($key, [
                'count' => 1,
                'start' => time()
            ], $window);
            return;
        }

        if (time() - $data['start'] > $window) {
            cache()->save($key, [
                'count' => 1,
                'start' => time()
            ], $window);
            return;
        }

        if ($data['count'] >= $limit) {
            return service('response')
                ->setStatusCode(429)
                ->setJSON([
                    'error' => 'Demasiados intentos, espera un momento'
                ]);
        }

        $data['count']++;
        cache()->save($key, $data, $window);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
