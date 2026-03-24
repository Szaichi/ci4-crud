<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'username',
        'email',
        'password',

        'student_id',
        'course',
        'year_level',
        'section',
        'phone',
        'address',

        'profile_image',

        'role_id',

        'created_at',
        'updated_at'

    ];

    public function updateProfile(int $userId, array $data): bool
    {
        return $this->update($userId, $data);
    }

    public function getUserWithRole($login)
    {
        return $this->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->groupStart()
                ->where('email', $login)
                ->orWhere('username', $login)
            ->groupEnd()
            ->first();
    }

}