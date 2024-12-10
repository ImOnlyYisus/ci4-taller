<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function __construct() {
        parent::__construct();
    }
    private function authenticate()
    {
        $token = $this->request->getHeaderLine('Authorization');
        $model = new UserModel();
        $user = $model->where('token', $token)->first();

        if (!$user) {
            return false;
        }

        return true;
    }

    public function index()
    {
        if (!$this->authenticate()) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $model = new ProductModel();
        $products = $model->findAll();

        foreach ($products as &$product) {
            $product['id'] = $this->encrypt($product['id']);
        }

        return $this->response->setJSON($products);
    }

    public function indexView()
    {
        $model = new ProductModel();
        $products = $model->findAll();

        foreach ($products as &$product) {
            $product['id'] = $this->encrypt($product['id']);
        }

        return view('products/index', ['products' => $products]);
    }

    public function create()
    {
        if (!$this->authenticate()) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $data = $this->request->getJSON();
        $model = new ProductModel();
        $id = $model->insert((array)$data);

        return $this->response->setJSON(['message' => 'Product created successfully', 'id' => $this->encrypt($id)]);
    }

    public function show($encryptedId)
    {
        if (!$this->authenticate()) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $id = $this->decrypt($encryptedId);
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid ID']);
        }

        $model = new ProductModel();
        $product = $model->find($id);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product not found']);
        }

        $product['id'] = $this->encrypt($product['id']);

        return $this->response->setJSON($product);
    }

    public function update($encryptedId)
    {
        if (!$this->authenticate()) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $id = $this->decrypt($encryptedId);
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid ID']);
        }

        $data = $this->request->getJSON();
        $model = new ProductModel();
        $model->update($id, (array)$data);

        return $this->response->setJSON(['message' => 'Product updated successfully']);
    }

    public function delete($encryptedId)
    {
        if (!$this->authenticate()) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $id = $this->decrypt($encryptedId);
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid ID']);
        }

        $model = new ProductModel();
        $model->delete($id);

        return $this->response->setJSON(['message' => 'Product deleted successfully']);
    }
}
