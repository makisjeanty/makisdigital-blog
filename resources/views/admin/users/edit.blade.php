<x-app-layout>
    <x-slot name="header">Editar Usuário: {{ $user->name }}</x-slot>

    <div class="admin-card" style="max-width: 600px;">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">Nome</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    style="width: 100%; background: #1e293b; border: 1px solid #334155; color: #fff; padding: 0.75rem; border-radius: 0.5rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">E-mail</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    style="width: 100%; background: #1e293b; border: 1px solid #334155; color: #fff; padding: 0.75rem; border-radius: 0.5rem;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">Cargo (Role)</label>
                <select name="role"
                    style="width: 100%; background: #1e293b; border: 1px solid #334155; color: #fff; padding: 0.75rem; border-radius: 0.5rem;">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuário Comum</option>
                    <option value="aluno" {{ $user->role === 'aluno' ? 'selected' : '' }}>Aluno</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="topbar-btn" style="background: #3b82f6; border: none; cursor: pointer;">
                    Atualizar Usuário
                </button>
                <a href="{{ route('admin.users.index') }}" class="topbar-btn topbar-btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>