<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <x-form.input name="name" label="Nome" :value="old('name', $user->name)" required autofocus autocomplete="name" />

        <div style="margin-top: 1.5rem;">
            <x-form.input name="email" label="E-mail" type="email" :value="old('email', $user->email)" required autocomplete="username" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 0.75rem; padding: 1rem; background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 12px;">
                    <p style="font-size: 0.85rem; color: #fbbf24; margin-bottom: 0.5rem;">
                        {{ __('Seu endereço de e-mail não foi verificado.') }}
                    </p>

                    <button form="send-verification" class="btn btn-sm btn-secondary" style="font-size: 0.75rem;">
                        {{ __('Clique aqui para reenviar o link de verificação') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.75rem; font-size: 0.8rem; color: #34d399; font-weight: 500;">
                            {{ __('Um novo link de verificação foi enviado para seu e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">
                {{ __('Salvar Alterações') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    style="font-size: 0.85rem; color: #34d399; font-weight: 500;"
                >
                    <svg style="width: 16px; height: 16px; display: inline; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    {{ __('Alterações salvas com sucesso!') }}
                </p>
            @endif
        </div>
    </form>
</section>
