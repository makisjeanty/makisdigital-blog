<section>
    <div style="padding: 1rem; background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1); border-radius: 12px; margin-bottom: 1.5rem;">
        <p style="font-size: 0.85rem; color: #9ca3af; line-height: 1.6;">
            {{ __('Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente removidos. Por favor, baixe qualquer dado que deseje manter antes de prosseguir.') }}
        </p>
    </div>

    <button
        class="btn btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        {{ __('Excluir Minha Conta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6" style="background: #16181d; border: 1px solid var(--border-color); border-radius: 16px;">
            @csrf
            @method('delete')

            <h2 style="font-size: 1.25rem; font-weight: 700; color: #f87171; margin-bottom: 1rem;">
                {{ __('Você tem certeza que deseja excluir sua conta?') }}
            </h2>

            <p style="font-size: 0.9rem; color: #9ca3af; margin-bottom: 2rem; line-height: 1.6;">
                {{ __('Esta ação não pode ser desfeita. Por favor, insira sua senha para confirmar que você deseja excluir permanentemente sua conta.') }}
            </p>

            <div class="form-group">
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-input"
                    placeholder="{{ __('Sua Senha') }}"
                    style="width: 100%;"
                />

                @if($errors->userDeletion->get('password'))
                    @foreach($errors->userDeletion->get('password') as $message)
                        <p class="form-error">{{ $message }}</p>
                    @endforeach
                @endif
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </button>

                <button type="submit" class="btn btn-danger">
                    {{ __('Confirmar Exclusão') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
