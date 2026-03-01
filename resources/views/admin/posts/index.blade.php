<x-app-layout>
    <x-slot name="header">Meus Posts</x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-transition>
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span style="flex: 1;">{{ session('success') }}</span>
        <button @click="show = false" class="btn-icon" style="color: #34d399;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Stats Cards --}}
    @php
    $totalPosts = Auth::user()->posts()->count();
    $publishedPosts = Auth::user()->posts()->whereNotNull('published_at')->where('published_at', '<=', now())->count();
        $draftPosts = $totalPosts - $publishedPosts;
        @endphp

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(108, 99, 255, 0.1);">📝</div>
                <div class="stat-value">{{ $totalPosts }}</div>
                <div class="stat-label">Total de Posts</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1);">✅</div>
                <div class="stat-value">{{ $publishedPosts }}</div>
                <div class="stat-label">Publicados</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1);">📋</div>
                <div class="stat-value">{{ $draftPosts }}</div>
                <div class="stat-label">Rascunhos</div>
            </div>
        </div>

        {{-- Posts Table --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">Todos os Posts</div>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Novo Post
                </a>
            </div>

            @if($posts->count() > 0)
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th style="text-align: right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    @if($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt=""
                                        style="width: 48px; height: 48px; border-radius: 10px; object-fit: cover; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.06);">
                                    @else
                                    <div
                                        style="width: 48px; height: 48px; border-radius: 10px; background: rgba(108, 99, 255, 0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.25rem;">
                                        📝
                                    </div>
                                    @endif
                                    <div style="min-width: 0;">
                                        <div
                                            style="font-weight: 600; color: #e4e4e7; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px;">
                                            {{ $post->title }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.15rem;">
                                            /post/{{ $post->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($post->isPublished())
                                <span class="badge badge-success">
                                    <span class="badge-dot"></span>
                                    Publicado
                                </span>
                                @else
                                <span class="badge badge-warning">
                                    <span class="badge-dot"></span>
                                    Rascunho
                                </span>
                                @endif
                            </td>
                            <td style="color: #9ca3af; white-space: nowrap;">
                                {{ $post->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <div
                                    style="display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem;">
                                    @if($post->isPublished())
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn-icon"
                                        title="Ver post" style="color: #60a5fa;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn-icon" title="Editar"
                                        style="color: #a78bfa;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Tem certeza que deseja deletar este post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" title="Deletar" style="color: #f87171;">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($posts->hasPages())
            <div class="admin-pagination">
                {{ $posts->links() }}
            </div>
            @endif

            @else
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <h3>Nenhum post ainda</h3>
                <p>Comece criando seu primeiro post para o blog.</p>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Criar Primeiro Post
                </a>
            </div>
            @endif
        </div>
</x-app-layout>