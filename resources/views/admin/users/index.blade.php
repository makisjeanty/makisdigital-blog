<x-app-layout>
    <x-slot name="header">Gerenciar Usuários</x-slot>

    <div class="admin-card">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; color: #fff;">
                <thead>
                    <tr style="border-bottom: 1px solid #334155; text-align: left;">
                        <th style="padding: 1rem;">Nome</th>
                        <th style="padding: 1rem;">E-mail</th>
                        <th style="padding: 1rem;">Cargo (Role)</th>
                        <th style="padding: 1rem;">Data Cadastro</th>
                        <th style="padding: 1rem;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr style="border-bottom: 1px solid #1e293b; transition: background 0.2s;"
                            onmouseover="this.style.background='#1e293b'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem;">{{ $user->name }}</td>
                            <td style="padding: 1rem; color: #94a3b8;">{{ $user->email }}</td>
                            <td style="padding: 1rem;">
                                <span
                                    style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600;
                                    {{ $user->role === 'admin' ? 'background: #3b82f6;' : ($user->role === 'aluno' ? 'background: #10b981;' : 'background: #64748b;') }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td style="padding: 1rem; color: #94a3b8;">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td style="padding: 1rem;">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    style="color: #3b82f6; margin-right: 1rem; text-decoration: none;">Editar</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; color: #ef4444; cursor: pointer;"
                                        onclick="return confirm('Excluir este usuário?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 1.5rem;">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>