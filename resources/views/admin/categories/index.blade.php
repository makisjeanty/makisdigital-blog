<x-app-layout>
    <x-slot name="header">Gerenciar Categorias</x-slot>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        {{-- Criar --}}
        <div class="admin-card">
            <h3 style="color: #fff; margin-bottom: 1.5rem;">Nova Categoria</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <x-form.input name="name" label="Nome da Categoria" required />
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Criar</button>
            </form>
        </div>

        {{-- Listagem --}}
        <div class="admin-card">
            <table style="width: 100%; border-collapse: collapse; color: #fff;">
                <thead>
                    <tr style="border-bottom: 1px solid #334155; text-align: left;">
                        <th style="padding: 1rem;">Nome</th>
                        <th style="padding: 1rem;">Posts</th>
                        <th style="padding: 1rem;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr style="border-bottom: 1px solid #1e293b;">
                            <td style="padding: 1rem;">{{ $category->name }}</td>
                            <td style="padding: 1rem; color: #94a3b8;">{{ $category->posts_count }}</td>
                            <td style="padding: 1rem;">
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; color: #ef4444; cursor: pointer;"
                                        onclick="return confirm('Excluir?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>