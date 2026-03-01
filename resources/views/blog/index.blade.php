@extends('layouts.blog')

@section('title', 'Explorar Blog - Makis Digital')

@section('content')
    <!-- Blog Header -->
    <section class="blog-hero-refined">
        <div class="container-ref">
            <div class="hero-badge animate-fade-in">
                <span class="dot"></span>
                Insights & Tendências
            </div>
            <h1 class="hero-title animate-fade-in animate-delay-1">
                Mergulhe no <br>
                <span class="gradient-text">Conhecimento</span>
            </h1>
            <p class="hero-subtitle animate-fade-in animate-delay-2">
                Explore nossos artigos sobre inteligência artificial, desenvolvimento de software e estratégias digitais
                para 2026.
            </p>

            <!-- Search & Categories Bar -->
            <div class="blog-filters-container animate-fade-in animate-delay-3">
                <div class="categories-nav">
                    <a href="{{ route('blog.index') }}" class="category-pill {{ !request('category') ? 'active' : '' }}">
                        Todos
                    </a>
                    @foreach($categories as $cat)
                        @if($cat->posts_count > 0)
                            <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                                class="category-pill {{ request('category') == $cat->slug ? 'active' : '' }}">
                                {{ $cat->name }}
                                <span class="cat-count">{{ $cat->posts_count }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>

                <form action="{{ route('blog.index') }}" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar artigos..."
                            class="search-input">
                        <button type="submit" class="search-submit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="posts-section">
        <div class="container-ref">
            @if($posts->count() > 0)
                @if(!request('search') && !request('category') && $posts->currentPage() === 1)
                    @php $featured = $posts->first(); @endphp
                    <div class="featured-post-card animate-fade-in">
                        <div class="featured-image-side">
                            @if($featured->image_path)
                                <img src="{{ asset('storage/' . $featured->image_path) }}" alt="{{ $featured->title }}">
                            @else
                                <div class="post-card-placeholder">✨</div>
                            @endif
                        </div>
                        <div class="featured-content-side">
                            <div class="featured-badge">⭐ Artigo em Destaque</div>
                            <h2 class="featured-title">
                                <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                            </h2>
                            <p class="featured-excerpt">{{ $featured->short_excerpt }}</p>
                            <div class="featured-meta">
                                <div class="post-card-author">
                                    <span class="author-avatar">{{ strtoupper(substr($featured->author->name, 0, 1)) }}</span>
                                    <span>{{ $featured->author->name }}</span>
                                </div>
                                <span class="meta-dot"></span>
                                <span>{{ $featured->published_at->format('d M, Y') }}</span>
                                <span class="meta-dot"></span>
                                <span>{{ ceil(str_word_count(strip_tags($featured->content)) / 200) }} min leitura</span>
                            </div>
                            <a href="{{ route('blog.show', $featured->slug) }}" class="btn-primary-ref"
                                style="padding: 0.8rem 2rem; font-size: 0.9rem; margin-top: 1.5rem;">
                                Ler Artigo Completo
                            </a>
                        </div>
                    </div>
                @endif

                <div class="posts-grid" style="margin-top: 4rem;">
                    @foreach($posts as $index => $post)
                        @if(!(!request('search') && !request('category') && $posts->currentPage() === 1 && $index === 0))
                            <x-blog.post-card :post="$post" :delay="($index % 3) + 1" />
                        @endif
                    @endforeach
                </div>

                <div class="pagination-container animate-fade-in">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🔍</div>
                    <h3>Nenhum resultado encontrado</h3>
                    <p>Não encontramos o que você está procurando. Tente outros termos ou navegue pelas categorias.</p>
                    <a href="{{ route('blog.index') }}" class="btn-secondary-ref" style="margin-top: 2rem;">Ver todos os
                        posts</a>
                </div>
            @endif
        </div>
    </section>

    <style>
        .blog-hero-refined {
            padding: 120px 0 60px;
            text-align: center;
            background: radial-gradient(circle at 50% 0%, rgba(108, 99, 255, 0.1) 0%, transparent 70%);
        }

        .container-ref {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .featured-post-card {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 30px;
            overflow: hidden;
            margin-top: -20px;
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.5);
        }

        .featured-image-side {
            overflow: hidden;
        }

        .featured-image-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .featured-post-card:hover .featured-image-side img {
            transform: scale(1.05);
        }

        .featured-content-side {
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
        }

        .featured-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            background: rgba(108, 99, 255, 0.1);
            border: 1px solid rgba(108, 99, 255, 0.2);
            color: var(--accent-secondary);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 2rem;
            width: fit-content;
        }

        .featured-title {
            font-size: 2.25rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
        }

        .featured-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .featured-title a:hover {
            color: var(--accent-primary);
        }

        .featured-excerpt {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            line-clamp: 3;
            overflow: hidden;
        }

        .featured-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .pagination-container {
            margin-top: 5rem;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 992px) {
            .featured-post-card {
                grid-template-columns: 1fr;
            }

            .featured-content-side {
                padding: 2.5rem;
            }

            .featured-image-side {
                height: 300px;
            }
        }

        @media (max-width: 768px) {
            .featured-title {
                font-size: 1.75rem;
            }
        }
    </style>
@endsection