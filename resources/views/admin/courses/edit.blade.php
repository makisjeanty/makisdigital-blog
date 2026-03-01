<x-app-layout>
    <x-slot name="header">Editar Curso</x-slot>

    <div style="max-width: 860px;">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-admin.card title="Informações do Curso">
                <x-slot name="action">
                    <span style="font-size: 0.72rem; color: #6b7280;">
                        Criado em {{ $course->created_at->format('d/m/Y') }}
                    </span>
                </x-slot>

                <x-form.input name="title" label="Título" :value="$course->title" required
                    placeholder="Título do seu curso..." class="form-input-lg" />

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                    <x-form.select name="level" label="Nível" required>
                        <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>
                            Iniciante</option>
                        <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediário</option>
                        <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>
                            Avançado</option>
                    </x-form.select>

                    <x-form.input name="price" label="Preço (R$)" type="number" step="0.01" :value="$course->price"
                        required placeholder="0.00" />

                    <x-form.input name="duration" label="Duração" :value="$course->duration"
                        placeholder="Ex: 10h, 5 módulos" />
                </div>

                <x-form.textarea name="excerpt" label="Resumo" :value="$course->excerpt" rows="2"
                    placeholder="Um breve resumo do curso..." />

                <x-form.textarea name="description" label="Descrição Completa" required :value="$course->description"
                    rows="12" placeholder="Descreva o que os alunos vão aprender..." />
            </x-admin.card>

            {{-- Imagem --}}
            <x-admin.card title="Imagem de Capa">
                @if($course->image_path)
                    <div
                        style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px;">
                        <img src="{{ asset('storage/' . $course->image_path) }}"
                            style="height: 64px; border-radius: 8px; object-fit: cover;" alt="Imagem atual">
                        <div style="flex: 1;">
                            <p style="font-size: 0.85rem; color: #e4e4e7; font-weight: 500;">Imagem atual</p>
                            <label
                                style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.35rem; cursor: pointer;">
                                <input type="checkbox" name="remove_image" value="1" class="form-checkbox"
                                    style="width: 14px; height: 14px;">
                                <span style="font-size: 0.78rem; color: #f87171;">Remover imagem</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div class="file-upload-zone" onclick="document.getElementById('image').click()">
                    <svg style="width: 40px; height: 40px; margin: 0 auto 0.75rem; color: #4b5563;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p style="font-size: 0.9rem; color: #9ca3af;">
                        <span
                            style="color: #a78bfa; font-weight: 600;">{{ $course->image_path ? 'Substituir imagem' : 'Clique para escolher' }}</span>
                        ou arraste
                    </p>
                    <input id="image" name="image" type="file" style="display: none;" accept="image/*">
                </div>
                <div id="imagePreview" style="display: none; margin-top: 1rem;">
                    <div
                        style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: rgba(108,99,255,0.05); border: 1px solid rgba(108,99,255,0.15); border-radius: 10px;">
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
                    <input type="checkbox" name="published" id="published" value="1" class="form-checkbox" {{ old('published', $course->status === 'published') ? 'checked' : '' }}>
                    <div>
                        <label for="published"
                            style="font-size: 0.9rem; font-weight: 600; color: #e4e4e7; cursor: pointer;">
                            Publicado
                        </label>
                        <p style="font-size: 0.78rem; color: #6b7280; margin-top: 0.15rem;">
                            Disponível para visualização pública.
                        </p>
                    </div>
                </div>
            </x-admin.card>

            {{-- Botões --}}
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Atualizar Curso
                </button>
            </div>
        </form>

        <x-admin.card title="Conteúdo do Curso" style="margin-top: 3rem;">
            @foreach($course->modules as $module)
                <div
                    style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; margin-bottom: 2rem; overflow: hidden;">
                    <div
                        style="padding: 1.25rem; background: rgba(255,255,255,0.03); display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h3 style="color: #fff; font-size: 1rem; font-weight: 600;">{{ $module->title }}</h3>
                            <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">
                                {{ $module->lessons->count() }} aulas neste módulo</p>
                        </div>
                        <a href="{{ route('admin.modules.lessons.create', $module) }}" class="topbar-btn"
                            style="background: #3b82f6; border: none; font-size: 0.75rem; padding: 0.5rem 1rem;">
                            + Adicionar Aula
                        </a>
                    </div>

                    <div style="padding: 0.5rem;">
                        @forelse($module->lessons as $lesson)
                            <div
                                style="padding: 0.75rem 1rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.03);">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <svg style="width: 16px; height: 16px; color: #6366f1;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                        </path>
                                        <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span style="color: #e4e4e7; font-size: 0.875rem;">{{ $lesson->title }}</span>
                                    @if($lesson->duration)
                                        <span style="color: #71717a; font-size: 0.75rem;">({{ $lesson->duration }})</span>
                                    @endif
                                </div>
                                <div style="display: flex; gap: 0.75rem;">
                                    <a href="{{ route('admin.lessons.edit', $lesson) }}"
                                        style="color: #3b82f6; font-size: 0.75rem;">Editar</a>
                                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST"
                                        style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.75rem;"
                                            onclick="return confirm('Excluir aula?')">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p style="padding: 1rem; color: #6b7280; font-size: 0.85rem; text-align: center;">Nenhuma aula
                                cadastrada ainda.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </x-admin.card>
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