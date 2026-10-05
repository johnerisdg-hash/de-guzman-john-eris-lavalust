<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiUserController extends Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();
        require_once APP_DIR . 'helpers/cors_helper.php';
        $this->api = $this->call->library('api');
        $this->call->database();

        // ['sub' => user id, 'role' => role from the database, 'scopes' => [...]]
        $this->auth = $this->api->require_jwt();
    }

    // GET /api/users/me
    public function me()
    {
        $this->api->require_method('GET');

        $user = $this->db->table('users')->where('id', (int) $this->auth['sub'])->get();
        if (!$user) {
            return $this->api->respond_error('User not found.', 404);
        }
        return $this->api->respond($this->public_user($user));
    }

    // GET /api/users (admin only)
    public function index()
    {
        $this->api->require_method('GET');
        $this->require_admin();

        $users = $this->db->table('users')->order_by('id', 'DESC')->get_all() ?: [];
        return $this->api->respond(array_map([$this, 'public_user'], $users));
    }

    // PUT /api/users/{id} (admin, or the user editing their own account)
    public function update($id)
    {
        $this->api->require_method('PUT');
        $id = (int) $id;

        if (!$this->is_admin() && $id !== (int) $this->auth['sub']) {
            return $this->api->respond_error('Forbidden.', 403);
        }

        $existing = $this->db->table('users')->where('id', $id)->get();
        if (!$existing) {
            return $this->api->respond_error('User not found.', 404);
        }

        $body = $this->api->body();
        $data = [];
        $password_changed = false;

        foreach (['firstname', 'lastname'] as $field) {
            if (isset($body[$field])) {
                $data[$field] = trim($body[$field]);
            }
        }

        if (isset($body['username'])) {
            $username = trim($body['username']);
            if ($username === '') {
                return $this->api->respond_error('Username cannot be empty.', 422);
            }
            $dup = $this->db->table('users')->where('username', $username)->get();
            if ($dup && (int) $dup['id'] !== $id) {
                return $this->api->respond_error('Username already taken.', 409);
            }
            $data['username'] = $username;
        }

        if (isset($body['email'])) {
            $email = trim($body['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->api->respond_error('Invalid email address.', 422);
            }
            $dup = $this->db->table('users')->where('email', $email)->get();
            if ($dup && (int) $dup['id'] !== $id) {
                return $this->api->respond_error('Email already registered.', 409);
            }
            $data['email'] = $email;
        }

        if (!empty($body['password'])) {
            if (strlen($body['password']) < 8) {
                return $this->api->respond_error('Password must be at least 8 characters.', 422);
            }
            $data['password'] = password_hash($body['password'], PASSWORD_DEFAULT);
            $password_changed = true;
        }

        if (isset($body['role'])) {
            if (!$this->is_admin()) {
                return $this->api->respond_error('Only an admin can change roles.', 403);
            }
            if (!in_array($body['role'], ['user', 'editor', 'admin'], true)) {
                return $this->api->respond_error('Invalid role.', 422);
            }
            $data['role'] = $body['role'];
        }

        if (!$data) {
            return $this->api->respond_error('Nothing to update.', 400);
        }

        $this->db->table('users')->where('id', $id)->update($data);

        // A password change should log the user out everywhere.
        if ($password_changed) {
            $this->revoke_user_tokens($id);
        }

        return $this->api->respond(['message' => 'User updated']);
    }

    // DELETE /api/users/{id} (admin only)
    public function delete($id)
    {
        $this->api->require_method('DELETE');
        $this->require_admin();
        $id = (int) $id;

        if ($id === (int) $this->auth['sub']) {
            return $this->api->respond_error('You cannot delete your own account.', 400);
        }
        if (!$this->db->table('users')->where('id', $id)->get()) {
            return $this->api->respond_error('User not found.', 404);
        }

        $this->revoke_user_tokens($id);
        $this->db->table('users')->where('id', $id)->delete();

        return $this->api->respond(['message' => 'User deleted']);
    }

    // ---- helpers ----

    private function is_admin()
    {
        return ($this->auth['role'] ?? '') === 'admin';
    }

    private function require_admin()
    {
        if (!$this->is_admin()) {
            $this->api->respond_error('Forbidden.', 403);
        }
    }

    private function public_user($user)
    {
        unset($user['password']);
        return $user;
    }

    private function revoke_user_tokens($user_id)
    {
        $table = config_item('refresh_token_table') ?: 'refresh_tokens';
        $this->db->table($table)->where('user_id', $user_id)->delete();
    }
}