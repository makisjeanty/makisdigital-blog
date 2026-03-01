<x-app-layout>
    <x-slot name="header">Inscritos na Newsletter</x-slot>

    @if(session('success'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title">Lista de E-mails</div>
            <div style="font-size: 0.85rem; color: #6b7280;">Total: {{ $subscribers->total() }}</div>
        </div>

        @if($subscribers->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>E-mail</th>
                        <th>Data de Inscrição</th>
                        <th style="text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $sub)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #e4e4e7;">{{ $sub->email }}</div>
                            </td>
                            <td style="color: #9ca3af;">
                                {{ $sub->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div style="display: flex; justify-content: flex-end;">
                                    <form action="{{ route('admin.newsletters.destroy', $sub) }}" method="POST"
                                        onsubmit="return confirm('Remover este e-mail da lista?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" style="color: #f87171;" title="Remover">
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

            @if($subscribers->hasPages())
                <div class="admin-pagination">
                    {{ $subscribers->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📧</div>
                <h3>Nenhum inscrito ainda</h3>
                <p>Os e-mails capturados no rodapé aparecerão aqui.</p>
            </div>
        @endif
    </div>
</x-app-layout>