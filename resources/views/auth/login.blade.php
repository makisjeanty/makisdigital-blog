<x-guest-layout>
    <div class="auth-header" style="text-align: center; margin-bottom: 2rem;">
        <h2 class="auth-title">Bem-vindo de volta</h2>
        <p class="auth-subtitle">Acesse sua conta para gerenciar seu ecossistema digital.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Endereço de E-mail</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <!-- Password -->
        <div class="form-group" style="margin-top: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <label for="password" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem;">Sua Senha</label>
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}" style="font-size: 0.75rem;">
                        Esqueceu a senha?
                    </a>
                @endif
            </div>
            <input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center" style="cursor: pointer;">
                <input id="remember_me" type="checkbox" style="width: 16px; height: 16px; accent-color: var(--accent-primary); border-radius: 4px; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color);" name="remember">
                <span class="ms-2 text-sm" style="color: var(--text-secondary);">Lembrar de mim</span>
            </label>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary">
                Entrar no Painel
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
            </button>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); text-align: center;">
            <p style="font-size: 0.85rem; color: var(--text-secondary);">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="auth-link">Criar conta agora</a>
            </p>
        </div>
    </form>
</x-guest-layout>
