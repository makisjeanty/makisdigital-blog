@props(['title' => null, 'action' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'admin-card']) }}>
    @if($title || $action)
    <div class="admin-card-header">
        @if($title)
        <div class="admin-card-title">{{ $title }}</div>
        @endif

        @if($action)
        <div>{{ $action }}</div>
        @endif
    </div>
    @endif

    <div style="padding: 1.5rem;">
        {{ $slot }}
    </div>

    @if($footer)
    <div style="padding: 1rem 1.5rem; background: rgba(255,255,255,0.02); border-top: 1px solid var(--border-color);">
        {{ $footer }}
    </div>
    @endif
</div>
