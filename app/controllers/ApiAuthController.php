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

        if (empty($user)
            || (int) ($user['is_active'] ?? 1) !== 1
            || !password_verify($password, (string) $user['password'])) {
            return $this->api->respond_error('Invalid username or password.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id'       => $user['id'],
            'username' => $user['username'],
            'role'     => $user['role'] ?? 'admin',
        ]);

        return $this->api->respond($tokens);
    }


    public function create()
{
    $this->api->rate_limit('create_' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'), 5, 300);
    $this->api->require_method('POST');

    $body      = $this->api->body();
    $firstname = trim($body['firstname'] ?? '');
    $lastname  = trim($body['lastname'] ?? '');
    $username  = trim($body['username'] ?? '');
    $email     = trim($body['email'] ?? '');
    $password  = $body['password'] ?? '';
    $role      = $body['role'] ?? 'user';

    if ($username === '' || $email === '' || $password === '') {
        return $this->api->respond_error('Username, email and password are required.', 400);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $this->api->respond_error('Invalid email address.', 400);
    }
    if (strlen($password) < 8) {
        return $this->api->respond_error('Password must be at least 8 characters.', 400);
    }
    if (!in_array($role, ['user', 'admin'], true)) {
        $role = 'user';
    }

    if ($this->db->table('users')->where('username', $username)->get()) {
        return $this->api->respond_error('Username already taken.', 409);
    }
    if ($this->db->table('users')->where('email', $email)->get()) {
        return $this->api->respond_error('Email already registered.', 409);
    }

    $this->db->table('users')->insert([
        'firstname' => $firstname,
        'lastname'  => $lastname,
        'email'     => $email,
        'username'  => $username,
        'password'  => password_hash($password, PASSWORD_DEFAULT),
        'role'      => $role,
    ]);

    $user = $this->db->table('users')->where('username', $username)->get();

    return $this->api->respond([
        'id'       => $user['id'],
        'username' => $user['username'],
        'email'    => $user['email'],
        'role'     => $user['role'],
    ], 201);
}

// POST /api/refresh
public function refresh()
{
    $this->api->require_method('POST');
    $token = $this->api->body()['refresh_token'] ?? '';

    if ($token === '') {
        return $this->api->respond_error('refresh_token is required.', 400);
    }
    $this->api->refresh_access_token($token); // responds with new tokens
}

// POST /api/logout
public function logout()
{
    $this->api->require_method('POST');
    $token = $this->api->body()['refresh_token'] ?? '';

    if ($token === '') {
        return $this->api->respond_error('refresh_token is required.', 400);
    }
    $this->api->revoke_refresh_token($token);
    return $this->api->respond(['message' => 'Logged out']);
}
}

