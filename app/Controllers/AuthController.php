<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        $model = new UserModel();
        $data = $this->request->getJSON();

        $user = $model->where('username', $data->username)->first();

        if (!$user || !password_verify($data->password, $user['password'])) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid credentials']);
        }

        $token = bin2hex(random_bytes(16));
        $model->update($user['id'], ['token' => $token]);

        return $this->response->setJSON(['token' => $token]);
    }
}
