<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseService
{
    public function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (
            Course::query()
                ->where('slug', '=', $slug)
                ->when($ignoreId, function ($q) use ($ignoreId) {
                    return $q->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function handleImageUpload(Request $request, ?Course $course = null): ?string
    {
        $imagePath = $course->image_path ?? null;

        if ($request->hasFile('image')) {
            if ($course && $course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }

            return $request->file('image')->store('courses', 'public');
        }

        if ($request->boolean('remove_image') && $course && $course->image_path) {
            Storage::disk('public')->delete($course->image_path);

            return null;
        }

        return $imagePath;
    }

    public function create(array $data): Course
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        if ($course->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $course->id);
        }

        $course->update($data);

        return $course;
    }

    public function delete(Course $course): bool
    {
        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }

        return (bool) $course->delete();
    }
}
