<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function indexVideos()
    {
        $videos = Video::where('user_id', auth()->id())->get();
        return view('admin.teacher.videos.index', compact('videos'));
    }

    public function createVideo()
    {
        return view('admin.teacher.videos.create');
    }

    public function storeVideo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
        ]);

        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('teacher.videos.index')->with('success', 'Vídeo criado com sucesso.');
    }

    public function indexCourses()
    {
        $courses = Course::where('teacher_id', auth()->id())->get();
        return view('admin.teacher.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        return view('admin.teacher.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => auth()->id(),
        ]);

        return redirect()->route('teacher.courses.index')->with('success', 'Curso criado com sucesso.');
    }
}