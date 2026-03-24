<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';

    protected $allowedFields = [
        'student_id',
        'full_name',
        'course',
        'year_level',
        'section',
        'created_at',
        'updated_at'
    ];
}
