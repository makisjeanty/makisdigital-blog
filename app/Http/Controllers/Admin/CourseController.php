<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Services\CourseService;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index()
    {
        $courses = Course::latest('created_at')->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();

        $data = $validated;
        $data['image_path'] = $this->courseService->handleImageUpload($request);
        $data['status'] = $request->boolean('published') ? 'published' : 'draft';

        $this->courseService->create($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Curso criado com sucesso!');
    }

    public function edit(Course $course)
    {
        $course->load('modules.lessons');

        return view('admin.courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validated = $request->validated();

        $data = $validated;
        $data['image_path'] = $this->courseService->handleImageUpload($request, $course);
        $data['status'] = $request->boolean('published') ? 'published' : 'draft';

        $this->courseService->update($course, $data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Course $course)
    {
        $this->courseService->delete($course);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Curso deletado com sucesso!');
    }
}
