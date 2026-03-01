<x-app-layout>
    <x-slot name="header">Visualizar Mensagem</x-slot>

    <div style="max-width: 800px;">
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title">{{ $message->subject ?? '(Sem assunto)' }}</div>
                <div style="font-size: 0.8rem; color: #6b7280;">{{ $message->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <div>
                        <div style="font-size: 0.7rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">De:</div>
                        <div style="font-weight: 600; color: #e4e4e7; font-size: 1.1rem;">{{ $message->name }}</div>
                        <div style="color: #a78bfa; font-size: 0.9rem;">{{ $message->email }}</div>
                    </div>
                </div>

                <div style="font-size: 0.7rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Mensagem:</div>
                <div style="background: rgba(15, 17, 23, 0.5); padding: 1.5rem; border-radius: 12px; color: #d1d5db; line-height: 1.8; white-space: pre-wrap;">{{ $message->message }}</div>
            </div>

            <div style="padding: 1.25rem 2rem; background: rgba(255,255,255,0.02); display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary btn-sm">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Voltar
                </a>

                <div style="display: flex; gap: 0.75rem;">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-primary btn-sm">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Responder por E-mail
                    </a>

                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Deletar esta mensagem?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
