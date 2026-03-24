<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        $data['users'] = $model
            ->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->findAll();

        $data['roles'] = [
            1 => 'admin',
            2 => 'teacher',
            3 => 'student',
            4 => 'coordinator'
        ];

        return view('admin/users', $data);
    }

    public function assignRole($id)
    {
        $model = new UserModel();

        $role_id = $this->request->getPost('role_id');

        if (session('user')['id'] == $id) {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $model->update($id, [
            'role_id' => $role_id
        ]);

        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function delete($id)
    {
        $model = new UserModel();

        if (session('user')['id'] == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $model->delete($id);

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}