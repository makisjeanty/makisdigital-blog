<x-app-layout>
    <x-slot name="header">Novo Curso</x-slot>

    <div style="max-width: 860px;">
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-admin.card title="Informações do Curso">
                <x-form.input name="title" label="Título" required placeholder="Título do seu curso..." class="form-input-lg" />

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                    <x-form.select name="level" label="Nível" required>
                        <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Iniciante</option>
                        <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediário</option>
                        <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Avançado</option>
                    </x-form.select>

                    <x-form.input name="price" label="Preço (R$)" type="number" step="0.01" value="0.00" required placeholder="0.00" />

                    <x-form.input name="duration" label="Duração" placeholder="Ex: 10h, 5 módulos" />
                </div>

                <x-form.textarea name="excerpt" label="Resumo" rows="2" placeholder="Um breve resumo do curso..." />

                <x-form.textarea name="description" label="Descrição Completa" required rows="12" placeholder="Descreva o que os alunos vão aprender..." />
            </x-admin.card>

            {{-- Imagem --}}
            <x-admin.card title="Imagem de Capa">
                <div class="file-upload-zone" onclick="document.getElementById('image').click()">
                    <svg style="width: 40px; height: 40px; margin: 0 auto 0.75rem; color: #4b5563;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p style="font-size: 0.9rem; color: #9ca3af;">
                        <span style="color: #a78bfa; font-weight: 600;">Clique para escolher</span> ou arraste
                    </p>
                    <input id="image" name="image" type="file" style="display: none;" accept="image/*">
                </div>
                <div id="imagePreview" style="display: none; margin-top: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: rgba(108,99,255,0.05); border: 1px solid rgba(108,99,255,0.15); border-radius: 10px;">
                        <img id="previewImg" style="height: 64px; border-radius: 8px; object-fit: cover;" alt="Preview">
                    </div>
                </div>
                @error('image')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </x-admin.card>

            {{-- Publicação --}}
            <x-admin.card>
                <div class="form-checkbox-wrapper">
                    <input type="hidden" name="published" value="0">
                    <input type="checkbox" name="published" id="published" value="1" class="form-checkbox" {{ old('published') ? 'checked' : '' }}>
                    <div>
                        <label for="published" style="font-size: 0.9rem; font-weight: 600; color: #e4e4e7; cursor: pointer;">
                            Publicar
                        </label>
                        <p style="font-size: 0.78rem; color: #6b7280; margin-top: 0.15rem;">
                            Tornar este curso visível no site imediatamente.
                        </p>
                    </div>
                </div>
            </x-admin.card>

            {{-- Botões --}}
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Criar Curso
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('previewImg').src = event.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
