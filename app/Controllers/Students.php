<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Students extends BaseController
{
    public function index()
    {
        $model = new StudentModel();

        $data['students'] = $model->paginate(10);
        $data['pager'] = $model->pager;

        return view('students/index', $data);
    }

    public function create()
    {
        return view('students/create');
    }

    public function store()
    {
        $rules = [
            'full_name' => 'required|min_length[3]',
            'course' => 'required',
            'year_level' => 'required',
            'section' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new StudentModel();

        $last = $model->orderBy('id', 'DESC')->first();

        $number = 1;

        if ($last && isset($last['student_id'])) {
            $lastNumber = (int) substr($last['student_id'], -4);
            $number = $lastNumber + 1;
        }

        $student_id = 'STU-' . date('Y') . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $model->insert([
            'student_id' => $student_id,
            'full_name' => $this->request->getPost('full_name'),
            'course' => $this->request->getPost('course'),
            'year_level' => $this->request->getPost('year_level'),
            'section' => $this->request->getPost('section'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/students/create')->with('success', 'Student added successfully');
    }

    public function update($id)
    {
        $rules = [
            'full_name' => 'required|min_length[3]',
            'course' => 'required',
            'year_level' => 'required',
            'section' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new StudentModel();

        $model->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'course' => $this->request->getPost('course'),
            'year_level' => $this->request->getPost('year_level'),
            'section' => $this->request->getPost('section'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/students')->with('success', 'Student updated successfully');
    }

    public function delete($id)
    {
        $model = new StudentModel();
        $model->delete($id);

        return redirect()->to('/students')->with('success', 'Student deleted successfully');
    }
}