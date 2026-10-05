<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        require_once APP_DIR . 'helpers/cors_helper.php';
        $this->api = $this->call->library('api');
        $this->call->database();

        // AUTH GOES HERE LATER:
        //$this->api->require_jwt();
    }

    // GET /api/products
    public function index()
    {
        $this->api->require_method('GET');
        $products = $this->db->table('products')->order_by('id', 'DESC')->get_all();
        return $this->api->respond($products);
    }

    // POST /api/products
    public function store()
    {
        $this->api->require_method('POST');
        $data = $this->clean($this->api->body());
        if (!$data) return;

        $this->db->table('products')->insert($data);
        return $this->api->respond(['message' => 'Product created'], 201);
    }

    // PUT /api/products/{id}
    public function update($id)
    {
        $this->api->require_method('PUT');
        $data = $this->clean($this->api->body());
        if (!$data) return;

        $this->db->table('products')->where('id', $id)->update($data);
        return $this->api->respond(['message' => 'Product updated']);
    }

    // DELETE /api/products/{id}
    public function delete($id)
    {
        $this->api->require_method('DELETE');
        $this->db->table('products')->where('id', $id)->delete();
        return $this->api->respond(['message' => 'Product deleted']);
    }

    private function clean($body)
    {
        $name  = trim($body['product_name'] ?? '');
        $price = $body['price'] ?? null;

        if ($name === '' || !is_numeric($price)) {
            $this->api->respond_error('product_name and a numeric price are required.', 422);
            return false;
        }

        return [
            'product_name' => $name,
            'description'  => trim($body['description'] ?? ''),
            'price'        => (float) $price,
            'quantity'     => (int) ($body['quantity'] ?? 0),
        ];
    }
}