<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $role = session('user')['role'];

        if ($role === 'student') {
            return redirect()->to('/profile');
        }

        $model = new StudentModel();

        $data['students'] = $model
            ->orderBy('id', 'DESC')
            ->findAll();

        $data['role'] = $role;

        return view('dashboard/index', $data);
    }

}