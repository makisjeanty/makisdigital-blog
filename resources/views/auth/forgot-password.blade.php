<x-guest-layout>
    <div class="auth-header" style="text-align: center; margin-bottom: 2rem;">
        <h2 class="auth-title">Recuperar senha</h2>
        <p class="auth-subtitle">Esqueceu sua senha? Sem problemas. Enviaremos um link de recuperação para o seu e-mail.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Endereço de E-mail</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary">
                Enviar Link de Recuperação
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </button>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); text-align: center;">
            <a href="{{ route('login') }}" class="auth-link" style="font-size: 0.85rem;">
                &larr; Voltar para o login
            </a>
        </div>
    </form>
</x-guest-layout>
