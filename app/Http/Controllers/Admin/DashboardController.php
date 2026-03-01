<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Message;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts_count' => Post::count(),
            'courses_count' => Course::count(),
            'messages_unread' => Message::where('is_read', false)->count(),
            'categories_count' => Category::count(),
            'subscribers_count' => \App\Models\Newsletter::count(),
            'latest_posts' => Post::latest()->take(5)->get(),
            'latest_messages' => Message::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
