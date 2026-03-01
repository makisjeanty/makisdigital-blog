<x-app-layout>
    <x-slot name="header">Nova Aula — {{ $module->title }}</x-slot>

    <div style="max-width: 800px;">
        <form action="{{ route('admin.modules.lessons.store', $module) }}" method="POST">
            @csrf

            <x-admin.card title="Conteúdo da Aula">
                <x-form.input name="title" label="Título da Aula" required placeholder="Ex: Introdução ao AdSense" />

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <x-form.input name="video_url" label="URL do Vídeo (YouTube/Vimeo)"
                        placeholder="https://youtube.com/..." />
                    <x-form.input name="duration" label="Duração" placeholder="Ex: 15min" />
                </div>

                <x-form.textarea name="content" label="Conteúdo de Apoio (Texto)" rows="10"
                    placeholder="Informações adicionais para o aluno..." />
            </x-admin.card>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Salvar Aula</button>
                <a href="{{ route('admin.courses.edit', $module->course_id) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>