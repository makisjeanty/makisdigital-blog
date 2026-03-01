<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (
            Post::where(['slug' => $slug])
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

    public function handleImageUpload(Request $request, ?Post $post = null): ?string
    {
        $imagePath = $post->image_path ?? null;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post && $post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            $file = $request->file('image');
            $filename = Str::random(40).'.'.$file->getClientOriginalExtension();
            $path = 'posts/'.$filename;

            // Resize image using Intervention Image v3
            try {
                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver);
                $image = $manager->read($file);

                // Scale to 1200px width, keeping aspect ratio
                $image->scale(width: 1200);

                // Save to public disk
                Storage::disk('public')->put($path, (string) $image->encode());

                return $path;
            } catch (\Exception $e) {
                // Fallback to standard upload if resizing fails
                return $file->store('posts', 'public');
            }
        }

        if ($request->boolean('remove_image') && $post && $post->image_path) {
            Storage::disk('public')->delete($post->image_path);

            return null;
        }

        return $imagePath;
    }

    public function create(array $data, int $userId): Post
    {
        $data['user_id'] = $userId;
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        $post = Post::create($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    public function update(Post $post, array $data): Post
    {
        if ($post->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $post->id);
        }

        $post->update($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    public function delete(Post $post): bool
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        /** @var \Illuminate\Database\Eloquent\Model $post */
        return (bool) $post->delete();
    }
}
