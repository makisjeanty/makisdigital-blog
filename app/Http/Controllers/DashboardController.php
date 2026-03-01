<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return app(AdminDashboardController::class)->index();
        }

        $enrolledCourses = $user->courses()
            ->orderByPivot('enrolled_at', 'desc')
            ->get();

        $recommendedCourses = Course::query()
            ->where('status', 'published')
            ->when($enrolledCourses->isNotEmpty(), function ($query) use ($enrolledCourses) {
                $query->whereNotIn('id', $enrolledCourses->modelKeys());
            })
            ->latest('published_at')
            ->limit(6)
            ->get();

        return view('student.dashboard', [
            'enrolledCourses' => $enrolledCourses,
            'recommendedCourses' => $recommendedCourses,
        ]);
    }
}
