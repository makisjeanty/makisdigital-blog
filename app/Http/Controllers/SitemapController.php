<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $posts = Post::published()->latest('updated_at')->get();
        $courses = \App\Models\Course::latest('updated_at')->get();

        $content = view('sitemap', compact('posts', 'courses'))->render();

        return response($content)->header('Content-Type', 'application/xml');
    }
}
