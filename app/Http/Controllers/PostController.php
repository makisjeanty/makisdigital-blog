<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /*
    |--------------------------------------------------------------------------
    | Página Pública
    |--------------------------------------------------------------------------
    */

    public function publicIndex(Request $request)
    {
        $version = (int) Cache::get('blog_cache_version', 1);
        $cacheKey = "blog_index_v{$version}_".md5(serialize($request->all()));

        $posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            return Post::latestPublished()
                ->with(['author:id,name', 'category:id,name,slug'])
                ->when($request->query('search'), function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('content', 'like', "%{$search}%")
                            ->orWhere('excerpt', 'like', "%{$search}%");
                    });
                })
                ->when($request->query('category'), function ($query, $category) {
                    return $query->whereHas('category', function ($q) use ($category) {
                        $q->where('slug', '=', $category);
                    });
                })
                ->paginate(9)
                ->withQueryString();
        });

        $categories = Category::withCount(['posts' => function ($q) {
            $q->published();
        }])->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(string $slug)
    {
        $version = (int) Cache::get('blog_cache_version', 1);

        /** @var Post $post */
        $post = Cache::remember("post_show_v{$version}_{$slug}", now()->addHour(), function () use ($slug) {
            return Post::published()
                ->with(['author:id,name', 'category:id,name,slug', 'tags:id,name,slug'])
                ->where('slug', '=', $slug)
                ->firstOrFail();
        });

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', '=', $post->category_id)
            ->latest('published_at')
            ->limit(3)
            ->get(['id', 'title', 'slug', 'image_path']);

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $posts = Auth::user()
            ->posts()
            ->with(['category:id,name'])
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $data = $validated;
        $data['image_path'] = $this->postService->handleImageUpload($request);
        $data['published_at'] = $request->boolean('published') ? now() : null;
        $data['status'] = $request->boolean('published') ? 'published' : 'draft';

        if ($request->filled('tags')) {
            $data['tags'] = $request->tags;
        }

        $this->postService->create($data, Auth::id());

        $this->invalidatePostCaches();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post criado com sucesso!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validated();

        $data = $validated;
        $data['image_path'] = $this->postService->handleImageUpload($request, $post);
        $data['published_at'] = $request->boolean('published')
            ? ($post->published_at ?? now())
            : null;
        $data['status'] = $request->boolean('published') ? 'published' : 'draft';

        if ($request->filled('tags')) {
            $data['tags'] = $request->tags;
        }

        $this->postService->update($post, $data);

        $this->invalidatePostCaches();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $this->postService->delete($post);

        $this->invalidatePostCaches();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post deletado com sucesso!');
    }

    private function invalidatePostCaches(): void
    {
        Cache::add('blog_cache_version', 1);
        Cache::increment('blog_cache_version');
    }
}
