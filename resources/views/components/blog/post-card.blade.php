@props(['post', 'delay' => 0])

<article {{ $attributes->merge(['class' => 'post-card animate-fade-in animate-delay-' . $delay]) }}>
    <div class="post-card-image-wrapper">
        @if($post->image_path)
        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="post-card-image">
        @else
        <div class="post-card-placeholder">
            <span>{{ strtoupper(substr($post->title, 0, 1)) }}</span>
        </div>
        @endif

        @if($post->category)
        <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="post-card-category">
            {{ $post->category->name }}
        </a>
        @endif
    </div>

    <div class="post-card-body">
        <div class="post-card-meta">
            @if($post->author)
            <div class="post-card-author">
                <span class="author-avatar-sm">{{ strtoupper(substr($post->author->name, 0, 1)) }}</span>
                <span>{{ $post->author->name }}</span>
            </div>
            @endif
            <span class="meta-dot"></span>
            <div class="post-card-date">
                {{ ($post->published_at ?? $post->created_at)->format('d M, Y') }}
            </div>
        </div>

        <h2 class="post-card-title">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h2>
        <p class="post-card-excerpt">{{ $post->short_excerpt }}</p>
    </div>

    <div class="post-card-footer">
        <a href="{{ route('blog.show', $post->slug) }}" class="read-more-link">
            Ler mais
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
        <span style="font-size: 0.75rem; color: var(--text-muted);">
            {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min leitura
        </span>
    </div>
</article>
