<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function create(CourseModule $module)
    {
        return view('admin.lessons.create', compact('module'));
    }

    public function store(Request $request, CourseModule $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string',
        ]);

        CourseLesson::create([
            'course_module_id' => $module->id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'order' => $module->lessons()->count() + 1,
        ]);

        return redirect()->route('admin.courses.edit', $module->course->id)
            ->with('success', 'Aula adicionada com sucesso!');
    }

    public function edit(CourseLesson $lesson)
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, CourseLesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string',
        ]);

        $lesson->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'video_url' => $request->video_url,
            'duration' => $request->duration,
        ]);

        return redirect()->route('admin.courses.edit', $lesson->module->course->id)
            ->with('success', 'Aula atualizada!');
    }

    public function destroy(CourseLesson $lesson)
    {
        $courseId = $lesson->module->course->id;
        $lesson->delete();

        return redirect()->route('admin.courses.edit', $courseId)
            ->with('success', 'Aula removida.');
    }
}
