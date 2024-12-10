<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;


class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Authorization header missing']);
        }

        $userModel = new UserModel();
        $user = $userModel->where('token', $authHeader)->first();

        if (!$user) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Invalid or expired token']);
        }

        $request->user = $user;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
