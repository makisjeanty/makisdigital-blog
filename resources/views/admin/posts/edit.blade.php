<x-app-layout>
    <x-slot name="header">Editar Post</x-slot>

    <div style="max-width: 860px;">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-admin.card title="Informações do Post">
                <x-slot name="action">
                    <span style="font-size: 0.72rem; color: #6b7280;">
                        Editado em {{ $post->updated_at->format('d/m/Y H:i') }}
                    </span>
                </x-slot>

                <x-form.input name="title" label="Título" :value="$post->title" required
                    placeholder="Título do seu post..." class="form-input-lg" />

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <x-form.select name="category_id" label="Categoria">
                        <option value="">Sem categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-form.select>

                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <div
                            style="display: flex; flex-wrap: wrap; gap: 0.5rem; background: rgba(0,0,0,0.2); padding: 0.75rem; border-radius: 8px; border: 1px solid var(--border-color);">
                            @foreach($tags as $tag)
                                <label
                                    style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.8rem; cursor: pointer; background: rgba(255,255,255,0.05); padding: 0.2rem 0.5rem; border-radius: 4px;">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) || $post->tags->contains($tag->id) ? 'checked' : '' }}>
                                    {{ $tag->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <x-form.textarea name="excerpt" label="Resumo" :value="$post->excerpt" rows="2"
                    placeholder="Um breve resumo do post..." />

                <x-form.textarea name="content" id="content" label="Conteúdo" required :value="$post->content" rows="18"
                    style="font-family: 'JetBrains Mono', 'Fira Code', monospace; font-size: 0.85rem; line-height: 1.8;"
                    placeholder="Escreva o conteúdo do seu post aqui..." />
            </x-admin.card>

            {{-- SEO --}}
            <x-admin.card style="margin-bottom: 1.5rem;">
                <x-slot name="title">
                    <div style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem;"
                        onclick="document.getElementById('seo-fields').classList.toggle('hidden')">
                        <span>SEO & Metadados</span>
                        <svg style="width: 16px; height: 16px; color: #6b7280;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </x-slot>

                <div id="seo-fields" class="{{ $post->meta_title || $post->meta_description ? '' : 'hidden' }}">
                    <x-form.input name="meta_title" label="Meta Title" :value="$post->meta_title"
                        placeholder="Título SEO personalizado..." />
                    <x-form.textarea name="meta_description" label="Meta Description" :value="$post->meta_description"
                        rows="2" placeholder="Descrição para motores de busca..." />
                </div>
            </x-admin.card>

            <style>
                .hidden {
                    display: none !important;
                }
            </style>

            {{-- Imagem --}}
            <x-admin.card title="Imagem de Capa">
                @if($post->image_path)
                    <div
                        style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px;">
                        <img src="{{ asset('storage/' . $post->image_path) }}"
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
                            style="color: #a78bfa; font-weight: 600;">{{ $post->image_path ? 'Substituir imagem' : 'Clique para escolher' }}</span>
                        ou arraste
                    </p>
                    <input id="image" name="image" type="file" style="display: none;" accept="image/*">
                </div>
                <div id="imagePreview" style="display: none; margin-top: 1rem;">
                    <div
                        style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: rgba(108,99,255,0.05); border: 1px solid rgba(108,99,255,0.15); border-radius: 10px;">
                        <img id="previewImg" style="height: 64px; border-radius: 8px; object-fit: cover;" alt="Preview">
                        <div style="flex: 1; min-width: 0;">
                            <p id="previewName" style="font-size: 0.85rem; color: #e4e4e7; font-weight: 500;"></p>
                            <p id="previewSize" style="font-size: 0.75rem; color: #6b7280;"></p>
                        </div>
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
                    <input type="checkbox" name="published" id="published" value="1" class="form-checkbox" {{ old('published', $post->isPublished()) ? 'checked' : '' }}>
                    <div>
                        <label for="published"
                            style="font-size: 0.9rem; font-weight: 600; color: #e4e4e7; cursor: pointer;">
                            Publicado
                        </label>
                        <p style="font-size: 0.78rem; color: #6b7280; margin-top: 0.15rem;">
                            @if($post->published_at)
                                Publicado em {{ $post->published_at->format('d/m/Y \à\s H:i') }}
                            @else
                                Marcar para publicar agora
                            @endif
                        </p>
                    </div>
                </div>
            </x-admin.card>

            {{-- Botões --}}
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Voltar
                </a>
                <div style="display: flex; gap: 0.75rem;">
                    @if($post->isPublished())
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-secondary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Ver Post
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Atualizar Post
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo'],
            })
            .catch(error => {
                console.error(error);
            });

        document.getElementById('image').addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('previewImg').src = event.target.result;
                    document.getElementById('previewName').textContent = file.name;
                    document.getElementById('previewSize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <style>
        .ck-editor__main {
            color: #333 !important;
        }

        .ck-content {
            min-height: 400px;
        }

        /* Dark mode overrides for CKEditor */
        .ck.ck-editor__main>.ck-editor__editable {
            background: #0f1117 !important;
            color: #e4e4e7 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .ck.ck-toolbar {
            background: #16181d !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .ck.ck-button {
            color: #9ca3af !important;
        }

        .ck.ck-button:hover {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .ck.ck-button.ck-on {
            background: rgba(108, 99, 255, 0.2) !important;
            color: #a78bfa !important;
        }
    </style>
</x-app-layout>