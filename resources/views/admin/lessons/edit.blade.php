<x-app-layout>
    <x-slot name="header">Editar Aula — {{ $lesson->title }}</x-slot>

    <div style="max-width: 800px;">
        <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST">
            @csrf
            @method('PUT')

            <x-admin.card title="Conteúdo da Aula">
                <x-form.input name="title" label="Título da Aula" :value="$lesson->title" required />

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <x-form.input name="video_url" label="URL do Vídeo" :value="$lesson->video_url" />
                    <x-form.input name="duration" label="Duração" :value="$lesson->duration" />
                </div>

                <x-form.textarea name="content" label="Conteúdo de Apoio" rows="10" :value="$lesson->content" />
            </x-admin.card>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Atualizar Aula</button>
                <a href="{{ route('admin.courses.edit', $lesson->module->course_id) }}"
                    class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>