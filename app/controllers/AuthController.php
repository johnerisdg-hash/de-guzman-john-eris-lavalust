<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth = $this->call->library('auth');
    }

    public function login()
    {
        
        if ($this->auth->is_logged_in() && $this->auth->has_role('admin')) {
            redirect('products');
            return;
        }

        $this->call->view('product_login');
    }

    public function authenticate()
    {
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($this->auth->login($username, $password)) {
            redirect('products');
            return;
        }

        $this->call->view('product_login', [
            'error' => 'Invalid admin username or password.',
            'username' => $username,
        ]);
    }

    public function logout()
    {
        $this->auth->logout();
        redirect('products/login');
        return;
    }

    
}