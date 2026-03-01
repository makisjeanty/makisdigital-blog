<x-guest-layout>
    <div class="auth-header" style="text-align: center; margin-bottom: 2rem;">
        <h2 class="auth-title">Nova senha</h2>
        <p class="auth-subtitle">Escolha uma senha forte para proteger seu acesso.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Endereço de E-mail</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <!-- Password -->
        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="password" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Nova Senha</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="password_confirmation" class="form-label" style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem; display: block;">Confirme a nova Senha</label>
            <input id="password_confirmation" class="form-input"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="Repita a nova senha" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: #f87171; font-size: 0.8rem;" />
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary">
                Redefinir Senha
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
