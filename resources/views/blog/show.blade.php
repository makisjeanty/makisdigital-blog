@extends('layouts.blog')

@section('title', ($post->meta_title ?? $post->title) . ' - Makis Digital')
@section('meta_description', $post->meta_description ?? ($post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 160)))
@if($post->image_path)
@section('og_image', asset('storage/' . $post->image_path))
@endif

@section('content')
<article style="padding-top: 72px;">
    <!-- Post Header -->
    <header class="post-header">
        <div style="display: flex; justify-content: center; gap: 0.5rem;">
            @if($post->category)
            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="post-header-badge">
                {{ $post->category->name }}
            </a>
            @endif
        </div>

        <div class="post-card-meta" style="justify-content: center; margin-bottom: 1.5rem;">
            <div class="post-card-author">
                <span class="author-avatar-sm" style="width: 32px; height: 32px; font-size: 0.8rem;">
                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                </span>
                <span style="font-size: 0.9rem; color: var(--text-secondary);">{{ $post->author->name }}</span>
            </div>
            <span class="meta-dot"></span>
            <div class="post-card-date" style="font-size: 0.9rem;">
                {{ $post->published_at->format('d \d\e F, Y') }}
            </div>
            <span class="meta-dot"></span>
            <span style="font-size: 0.8rem; color: var(--text-muted);">
                {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min de leitura
            </span>
        </div>

        <h1 class="hero-title animate-fade-in" style="font-size: clamp(2rem, 5vw, 3.5rem); margin-bottom: 1rem;">
            {{ $post->title }}
        </h1>

        @if($post->excerpt)
        <p class="hero-subtitle animate-fade-in animate-delay-1" style="font-size: 1.15rem; margin-bottom: 0;">
            {{ $post->excerpt }}
        </p>
        @endif
    </header>

    <!-- Post Image -->
    @if($post->image_path)
    <div class="post-featured-image-container animate-fade-in animate-delay-2">
        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="post-featured-image">
    </div>
    @endif

    <!-- Post Content -->
    <div class="post-body-container animate-fade-in animate-delay-3">
        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>

        @if($post->tags->count() > 0)
        <div class="post-tags">
            <svg style="width: 16px; height: 16px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
            @foreach($post->tags as $tag)
            <span class="post-tag">#{{ $tag->name }}</span>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Sharing Buttons -->
    <div style="max-width: 760px; margin: 0 auto 3rem; padding: 0 1.5rem; text-align: center;">
        <p style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Compartilhar este post</p>
        <div class="share-buttons">
            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="share-btn share-btn-wa">
               <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.411.001 12.045c0 2.121.54 4.192 1.564 6.04L0 24l6.105-1.602a11.832 11.832 0 005.937 1.598h.005c6.637 0 12.048-5.412 12.052-12.046a11.822 11.822 0 00-3.412-8.527"/></svg>
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" class="share-btn share-btn-li">
               <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
            </a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ url()->current() }}" target="_blank" class="share-btn share-btn-tw">
               <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
        </div>
    </div>

    <!-- Author Box -->
    <div style="max-width: 760px; margin: 0 auto 3rem; padding: 0 1.5rem;">
        <div class="author-box">
            <div class="author-avatar-sm" style="width: 64px; height: 64px; font-size: 1.5rem; flex-shrink: 0;">
                {{ strtoupper(substr($post->author->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $post->author->name }}</div>
                <div style="color: var(--text-muted); font-size: 0.9rem;">Autor no Makis Digital</div>
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
    <section class="posts-section" style="padding-top: 0;">
        <div class="section-header">
            <h2 class="section-title">📚 Posts Relacionados</h2>
        </div>
        <div class="posts-grid">
            @foreach($relatedPosts as $index => $related)
                <x-blog.post-card :post="$related" :delay="($index % 3) + 1" />
            @endforeach
        </div>
    </section>
    @endif

    <!-- Back Button -->
    <div style="text-align: center; padding-bottom: 4rem;">
        <a href="{{ route('blog.index') }}" class="read-more-link" style="font-size: 1rem; gap: 0.5rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(180deg);">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
            Voltar para o Blog
        </a>
    </div>
</article>
@endsection
