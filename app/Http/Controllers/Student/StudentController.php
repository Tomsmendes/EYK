<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function indexVideos()
    {
        $videos = Video::all();
        return view('admin.student.videos.index', compact('videos'));
    }

    public function indexCourses()
    {
        $courses = Course::all();
        return view('admin.student.courses.index', compact('courses'));
    }

    
}