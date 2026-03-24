<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        $messages = [
            'confirm_password' => [
                'matches' => 'Passwords do not match.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();

        $email = $this->request->getPost('email');
        $username = $this->request->getPost('username');

        if ($model->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('errors', [
                'email' => 'Email already exists'
            ]);
        }

        if ($model->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('errors', [
                'username' => 'Username already exists'
            ]);
        }

        $model->insert([
            'name' => $this->request->getPost('name'),
            'username' => $username,
            'email' => $email,
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_BCRYPT
            ),
            'role_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/login')
            ->with('success', 'Account successfully created! Please login.');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function authenticate()
    {
        $model = new UserModel();

        $login = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->getUserWithRole($login);

        if ($user && password_verify($password, $user['password'])) {

            session()->set([
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => strtolower($user['role_name'])
                ],
                'logged_in' => true
            ]);

            $role = strtolower($user['role_name']);

            if ($role === 'admin' || $role === 'teacher') {
                return redirect()->to('/dashboard');
            }

            if ($role === 'coordinator') {
                return redirect()->to('/dashboard');
            }

            if ($role === 'student') {
                return redirect()->to('/profile');
            }

            return redirect()->to('/login');
        }

        return redirect()->back()
            ->with('error', 'Invalid email/username or password');
    }

    public function unauthorized()
    {
        return view('errors/unauthorized');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}