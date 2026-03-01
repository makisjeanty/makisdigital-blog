@use('App\Models\Post')
@use('App\Models\Message')
@use('App\Models\Newsletter')

<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #f8fafc; letter-spacing: -0.02em;">Olá,
            {{ explode(' ', Auth::user()->name)[0] }}! 👋
        </h2>
        <p style="color: #6b7280; font-size: 0.9rem; margin-top: 0.25rem;">Aqui está o que está acontecendo com a Makis
            Digital hoje.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(108, 99, 255, 0.1); color: #6c63ff;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="stat-value">{{ number_format($stats['posts_count']) }}</div>
            <div class="stat-label">Posts no Blog</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(167, 139, 250, 0.1); color: #a78bfa;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332 0.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253" />
                </svg>
            </div>
            <div class="stat-value">{{ number_format($stats['courses_count']) }}</div>
            <div class="stat-label">Cursos Ativos</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(52, 211, 153, 0.1); color: #34d399;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 00-2 2z" />
                </svg>
            </div>
            <div class="stat-value">{{ number_format($stats['subscribers_count'] ?? 0) }}</div>
            <div class="stat-label">Assinantes Newsletter</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(248, 113, 113, 0.1); color: #f87171;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4" />
                </svg>
            </div>
            <div class="stat-value">{{ number_format($stats['messages_unread']) }}</div>
            <div class="stat-label">Mensagens Pendentes</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-top: 2rem;">
        <!-- Posts Recentes -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">Últimos Posts</h3>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-secondary">Ver Todos</a>
            </div>
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['latest_posts'] as $post)
                            <tr>
                                <td style="font-weight: 500;">{{ $post->title }}</td>
                                <td style="color: #6b7280;">{{ $post->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($post->is_published)
                                        <span class="badge badge-success"><span class="badge-dot"></span> Público</span>
                                    @else
                                        <span class="badge badge-warning"><span class="badge-dot"></span> Rascunho</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 2rem; color: #6b7280;">Nenhum post
                                    encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mensagens Recentes -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">Mensagens Recentes</h3>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary">Ver Todas</a>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse($stats['latest_messages'] as $message)
                        <div
                            style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 1rem;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                <span
                                    style="font-weight: 600; font-size: 0.85rem; color: #e4e4e7;">{{ $message->name }}</span>
                                <span
                                    style="font-size: 0.7rem; color: #6b7280;">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                            <p
                                style="font-size: 0.8rem; color: #9ca3af; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $message->message }}
                            </p>
                        </div>
                    @empty
                        <p style="text-align: center; color: #6b7280; font-size: 0.85rem;">Sem mensagens novas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Inscritos Recentes -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Novos Inscritos na Newsletter</h3>
            <a href="{{ route('admin.newsletters.index') }}" class="btn btn-sm btn-secondary">Gerenciar Lista</a>
        </div>
        <div style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
                @php $latestSubs = \App\Models\Newsletter::latest()->take(6)->get(); @endphp
                @forelse($latestSubs as $sub)
                    <div
                        style="background: rgba(108,99,255,0.05); border: 1px solid rgba(108,99,255,0.1); border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                        <div
                            style="width: 32px; height: 32px; background: rgba(108,99,255,0.2); color: #a78bfa; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div
                                style="font-weight: 600; font-size: 0.85rem; color: #e4e4e7; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $sub->email }}</div>
                            <div style="font-size: 0.7rem; color: #6b7280;">{{ $sub->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <p style="grid-column: 1/-1; text-align: center; color: #6b7280; font-size: 0.85rem; padding: 1rem;">
                        Nenhum novo inscrito.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>