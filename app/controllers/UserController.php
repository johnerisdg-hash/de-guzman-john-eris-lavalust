<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UserController
 * 
 * Automatically generated via CLI.
 */
class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function ShowUsers()
    {
       $this->call->database();
       $this->call->model('UserModel');
       $data['users'] = $this->UserModel->all();
       $this->call->view('users', $data);

       
    }


    public function createUser()
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($password) < 6 || $password !== $password_confirmation) {
            $this->call->view('user_creation', [
                'error' => 'Enter a valid email and matching password of at least 6 characters.',
                'username' => $username,
                'email' => $email,
            ]);
            return;
        }

        $this->call->database();
        $this->call->model('UserModel');

        if ($this->UserModel->exists(['username' => $username])) {
            $this->call->view('user_creation', [
                'error' => 'That username is already in use.',
                'username' => $username,
                'email' => $email,
            ]);
            return;
        }

        $this->UserModel->insert([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
            'is_active' => 1,
        ]);

        redirect('users');
    }

}