<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{

    public function show()
    {

        $userSession = session('user');

        if (!$userSession || !isset($userSession['id'])) {
            return redirect()->to('/login');
        }

        $userId = $userSession['id'];

        $db = \Config\Database::connect();

        $builder = $db->table('users');
        $builder->select('users.*');
        $builder->where('users.id', $userId);

        $user = $builder->get()->getRowArray();

        return view('profile/show', [
            'user' => $user
        ]);
    }

    public function edit()
    {
        $userModel = new UserModel();

        $userSession = session('user');

        if (!$userSession || !isset($userSession['id'])) {
            return redirect()->to('/login');
        }

        $userId = $userSession['id'];

        $user = $userModel->find($userId);

        return view('profile/edit', [
            'user' => $user
        ]);
    }

    public function update()
    {
        $userModel = new UserModel();

        $userSession = session('user');

        if (!$userSession || !isset($userSession['id'])) {
            return redirect()->to('/login');
        }

        $userId = $userSession['id'];

        $user = $userModel->find($userId);

        $file = $this->request->getFile('profile_image');
        $removeImage = $this->request->getPost('remove_image');

        $filename = $user['profile_image'] ?? null;

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $allowedMime = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];

            $ext = strtolower($file->getExtension());
            $mime = $file->getMimeType();

            if (!in_array($ext, $allowedExtensions) || !in_array($mime, $allowedMime)) {

                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'profile_image' => 'Only JPG, JPEG, PNG, and WEBP images are allowed.'
                    ]);
            }

            if ($file->getSize() > 2048000) {

                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'profile_image' => 'Image must not exceed 2MB.'
                    ]);
            }
        }

        if ($removeImage == 1) {

            if (!empty($user['profile_image'])) {

                $oldPath = FCPATH . 'uploads/profiles/' . $user['profile_image'];

                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $filename = null;
        }

        elseif ($file && $file->isValid() && !$file->hasMoved()) {

            if (!empty($user['profile_image'])) {

                $oldPath = FCPATH . 'uploads/profiles/' . $user['profile_image'];

                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $ext = $file->getExtension();
            $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;

            $file->move(FCPATH . 'uploads/profiles/', $filename);
        }

        $data = [

            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),

            'student_id' => $this->request->getPost('student_id'),
            'course' => $this->request->getPost('course'),
            'year_level' => $this->request->getPost('year_level'),
            'section' => $this->request->getPost('section'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),

            'profile_image' => $filename,
            'updated_at' => date('Y-m-d H:i:s')

        ];

        $userModel->updateProfile($userId, $data);

        session()->set('name', $data['name']);

        return redirect()->to('/profile')
            ->with('success', 'Profile Updated Successfully');
    }
}