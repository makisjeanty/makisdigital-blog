<x-app-layout>
    <x-slot name="header">Gerenciar Tags</x-slot>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <div class="admin-card">
            <h3 style="color: #fff; margin-bottom: 1.5rem;">Nova Tag</h3>
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <x-form.input name="name" label="Nome da Tag" required />
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Criar</button>
            </form>
        </div>

        <div class="admin-card">
            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                @foreach($tags as $tag)
                    <div
                        style="background: #1e293b; border: 1px solid #334155; padding: 0.5rem 1rem; border-radius: 8px; display: flex; align-items: center; gap: 0.75rem;">
                        <span style="color: #fff;">{{ $tag->name }}</span>
                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.8rem;"
                                onclick="return confirm('Excluir?')">✕</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>