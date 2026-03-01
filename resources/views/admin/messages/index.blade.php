<x-app-layout>
    <x-slot name="header">Mensagens de Contato</x-slot>

    @if(session('success'))
    <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-transition>
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span style="flex: 1;">{{ session('success') }}</span>
    </div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title">Todas as Mensagens</div>
        </div>

        @if($messages->count() > 0)
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Remetente</th>
                        <th>Assunto</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th style="text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                    <tr style="{{ !$message->is_read ? 'background: rgba(108, 99, 255, 0.03); font-weight: 600;' : '' }}">
                        <td>
                            <div>
                                <div style="color: #e4e4e7;">{{ $message->name }}</div>
                                <div style="font-size: 0.75rem; color: #6b7280;">{{ $message->email }}</div>
                            </div>
                        </td>
                        <td style="color: #e4e4e7;">{{ $message->subject ?? '(Sem assunto)' }}</td>
                        <td>
                            @if($message->is_read)
                            <span class="badge badge-success"><span class="badge-dot"></span> Lida</span>
                            @else
                            <span class="badge badge-warning"><span class="badge-dot"></span> Nova</span>
                            @endif
                        </td>
                        <td style="color: #9ca3af; white-space: nowrap;">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem;">
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn-icon" title="Ver mensagem" style="color: #60a5fa;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Deletar esta mensagem?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Deletar" style="color: #f87171;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

        @if($messages->hasPages())
        <div class="admin-pagination">
            {{ $messages->links() }}
        </div>
        @endif

        @else
        <div class="empty-state">
            <div class="empty-state-icon">✉️</div>
            <h3>Nenhuma mensagem</h3>
            <p>Você ainda não recebeu mensagens pelo formulário de contato.</p>
        </div>
        @endif
    </div>
</x-app-layout>
