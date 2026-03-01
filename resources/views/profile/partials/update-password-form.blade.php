<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="form-label">Senha Atual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password" placeholder="••••••••" />
            @if($errors->updatePassword->get('current_password'))
                @foreach($errors->updatePassword->get('current_password') as $message)
                    <p class="form-error">{{ $message }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="update_password_password" class="form-label">Nova Senha</label>
            <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            @if($errors->updatePassword->get('password'))
                @foreach($errors->updatePassword->get('password') as $message)
                    <p class="form-error">{{ $message }}</p>
                @endforeach
            @endif
        </div>

        <div class="form-group" style="margin-top: 1.5rem;">
            <label for="update_password_password_confirmation" class="form-label">Confirmar nova Senha</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" placeholder="Repita a nova senha" />
            @if($errors->updatePassword->get('password_confirmation'))
                @foreach($errors->updatePassword->get('password_confirmation') as $message)
                    <p class="form-error">{{ $message }}</p>
                @endforeach
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                {{ __('Atualizar Senha') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    style="font-size: 0.85rem; color: #34d399; font-weight: 500;"
                >
                    <svg style="width: 16px; height: 16px; display: inline; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    {{ __('Senha atualizada com sucesso!') }}
                </p>
            @endif
        </div>
    </form>
</section>
