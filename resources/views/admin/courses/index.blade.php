<x-app-layout>
    <x-slot name="header">Gerenciar Cursos</x-slot>

    <div class="admin-card">
        <div class="admin-card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="admin-card-title">Todos os Cursos</div>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Novo Curso
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Nível</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $course->title }}</div>
                            <div style="font-size: 0.75rem; color: #6b7280;">{{ $course->duration }}</div>
                        </td>
                        <td>
                            <span style="font-size: 0.75rem; padding: 0.2rem 0.5rem; border-radius: 4px; background: rgba(255,255,255,0.05);">
                                {{ ucfirst($course->level) }}
                            </span>
                        </td>
                        <td>R$ {{ number_format($course->price, 2, ',', '.') }}</td>
                        <td>
                            @if($course->status === 'published')
                            <span class="status-badge status-published">Publicado</span>
                            @else
                            <span class="status-badge status-draft">Rascunho</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este curso?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" style="color: #f87171;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem; color: #6b7280;">Nenhum curso cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courses->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid var(--border-color);">
            {{ $courses->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
