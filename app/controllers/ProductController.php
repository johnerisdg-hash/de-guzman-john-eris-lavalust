<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('ProductModel');
    }

    public function index()
    {
        $data['products'] = $this->ProductModel->all();
        $this->call->view('products', $data);
    }

    public function create()
    {
        $this->call->view('product_create');
    }

    public function store()
    {
        $data = $this->product_data();
        if (!$this->valid_product_data($data)) {
            redirect('products/create');
        }

        $data['price'] = (float) $data['price'];
        $data['quantity'] = (int) $data['quantity'];
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->ProductModel->insert($data);
        redirect('products');
    }

    public function edit($id)
    {
        $product = $this->ProductModel->find((int) $id);
        if (empty($product)) {
            redirect('products');
        }

        $this->call->view('product_edit', ['product' => $product]);
    }

    public function update($id)
    {
        $data = $this->product_data();
        if (!$this->valid_product_data($data)) {
            redirect('products/edit/' . (int) $id);
        }

        $data['price'] = (float) $data['price'];
        $data['quantity'] = (int) $data['quantity'];
        $this->ProductModel->update((int) $id, $data);
        redirect('products');
    }

    public function delete($id)
    {
        $this->ProductModel->delete((int) $id);
        redirect('products');
    }

    private function product_data()
    {
        return [
            'product_name' => trim($_POST['product_name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => $_POST['price'] ?? '',
            'quantity' => $_POST['quantity'] ?? '',
        ];
    }

    private function valid_product_data($data)
    {
        return $data['product_name'] !== ''
            && is_numeric($data['price'])
            && $data['price'] >= 0
            && filter_var($data['quantity'], FILTER_VALIDATE_INT) !== false
            && $data['quantity'] >= 0;
    }
}