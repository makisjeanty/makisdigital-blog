<x-guest-layout>
    <div class="auth-header" style="text-align: center; margin-bottom: 2rem;">
        <h2 class="auth-title">Verifique seu e-mail</h2>
        <p class="auth-subtitle">Obrigado por se inscrever! Antes de começarmos, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você?</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div style="margin-bottom: 1.5rem; padding: 1rem; border-radius: 12px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; font-size: 0.85rem; text-align: center;">
            Um novo link de verificação foi enviado para o endereço de e-mail fornecido.
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 2rem;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">
                Reenviar E-mail de Verificação
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="text-align: center;">
            @csrf
            <button type="submit" class="auth-link" style="background: none; border: none; cursor: pointer; font-size: 0.85rem;">
                Sair da conta
            </button>
        </form>
    </div>
</x-guest-layout>
