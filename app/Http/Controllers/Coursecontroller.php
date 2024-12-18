<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.teacher.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->save();

        return redirect()->route('admin.teacher.courses.index')->with('success', 'Curso criado com sucesso.');
    }
}
