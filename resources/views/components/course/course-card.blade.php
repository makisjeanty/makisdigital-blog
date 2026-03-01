@props(['course', 'delay' => 0])

<article {{ $attributes->merge(['class' => 'post-card animate-fade-in animate-delay-' . $delay]) }}>
    <div class="post-card-image-wrapper">
        @if($course->image_path)
        <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}" class="post-card-image">
        @else
        <div class="post-card-placeholder">
            <span>🎓</span>
        </div>
        @endif
        <div style="position: absolute; top: 1rem; right: 1rem; background: var(--accent-primary); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; z-index: 10;">
            {{ ucfirst($course->level) }}
        </div>
    </div>

    <div class="post-card-body">
        <div class="post-card-meta">
            <div class="post-card-date">
                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ $course->duration ?? 'Tempo flexível' }}
            </div>
        </div>

        <h2 class="post-card-title">
            <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
        </h2>
        <p class="post-card-excerpt">{{ $course->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($course->description), 120) }}</p>
    </div>

    <div class="post-card-footer">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            @if($course->price == 0)
            <span style="font-weight: 700; color: #10b981;">GRÁTIS</span>
            @else
            <span style="font-weight: 700; color: var(--text-primary);">R$ {{ number_format($course->price, 2, ',', '.') }}</span>
            @endif
        </div>
        <a href="{{ route('courses.show', $course->slug) }}" class="read-more-link">
            Detalhes
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
    </div>
</article>
