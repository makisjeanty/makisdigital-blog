<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $blogVersion = (int) Cache::get('blog_cache_version', 1);

        $latestPosts = Cache::remember("home_latest_posts_v{$blogVersion}", now()->addMinutes(30), function () {
            return Post::published()
                ->with(['author:id,name', 'category:id,name,slug'])
                ->latest('published_at')
                ->limit(3)
                ->get();
        });

        $featuredCourses = Cache::remember('home_featured_courses', now()->addMinutes(60), function () {
            return Course::published()
                ->latest('created_at')
                ->limit(3)
                ->get();
        });

        return view('home', compact('latestPosts', 'featuredCourses'));
    }
}
