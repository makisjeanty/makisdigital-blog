<x-app-layout>
    <x-slot name="header">Perfil</x-slot>

    <div style="max-width: 720px;">
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div class="admin-card-header">
                <div class="admin-card-title">Informações do Perfil</div>
            </div>
            <div style="padding: 1.5rem;">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div class="admin-card-header">
                <div class="admin-card-title">Alterar Senha</div>
            </div>
            <div style="padding: 1.5rem;">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div class="admin-card-header">
                <div class="admin-card-title" style="color: #f87171;">Zona de Perigo</div>
            </div>
            <div style="padding: 1.5rem;">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>