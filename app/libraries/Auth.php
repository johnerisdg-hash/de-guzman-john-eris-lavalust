<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->database();
    }

    public function login($username, $password)
    {
        $user = $this->_lava->db->table('users')
            ->where('username', trim($username))
            ->get();

        if (empty($user) || (int) ($user['is_active'] ?? 1) !== 1
            || strtolower((string) ($user['role'] ?? '')) !== 'admin') {
            return false;
        }

        $stored_password = (string) ($user['password'] ?? '');
        $password_matches = password_verify($password, $stored_password)
            || hash_equals($stored_password, $password);

        if (!$password_matches) {
            return false;
        }

        if (!password_get_info($stored_password)['algo']) {
            $this->_lava->db->table('users')->where('id', $user['id'])->update([
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'admin';
        $_SESSION['logged_in'] = true;

        return true;
    }

    public function is_logged_in()
    {
        return !empty($_SESSION['logged_in']);
    }

    public function has_role($role)
    {
        return ($_SESSION['role'] ?? null) === $role;
    }

    public function is_admin()
    {
        return $this->is_logged_in() && $this->has_role('admin');
    }

    public function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}