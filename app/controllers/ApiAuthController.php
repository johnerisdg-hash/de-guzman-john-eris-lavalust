<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiAuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
         require_once APP_DIR . 'helpers/cors_helper.php'; 
        $this->api = $this->call->library('api');
        $this->call->database();
    }

    public function login()
    {
        $this->api->require_method('POST');

        $body     = $this->api->body();
        $username = trim($body['username'] ?? '');
        $password = $body['password'] ?? '';

        $user = $this->db->table('users')->where('username', $username)->get();

        if (empty($user) || !password_verify($password, (string) $user['password'])) {
            return $this->api->respond_error('Invalid username or password.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id'       => $user['id'],
            'username' => $user['username'],
            'role'     => $user['role'] ?? 'admin',
        ]);

        return $this->api->respond($tokens);
    }
}