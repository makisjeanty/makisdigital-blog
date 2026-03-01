<x-guest-layout>
    <div class="auth-header" style="text-align: center; margin-bottom: 2rem;">
        <h2 class="auth-title">Junte-se a nós</h2>
        <p class="auth-subtitle">Crie sua conta para começar sua jornada digital.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Nome Completo</label>
            <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Como quer ser chamado?" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <!-- Email Address -->
        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="email" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Endereço de E-mail</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <!-- Password -->
        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="password" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Crie uma Senha</label>
            <input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="password_confirmation" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Confirme sua Senha</label>
            <input id="password_confirmation" class="form-input"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Repita a senha anterior" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary">
                Criar minha Conta
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            </button>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); text-align: center;">
            <p style="font-size: 0.85rem; color: var(--text-secondary);">
                Já possui uma conta?
                <a href="{{ route('login') }}" class="auth-link">Fazer login</a>
            </p>
        </div>
    </form>
</x-guest-layout>
