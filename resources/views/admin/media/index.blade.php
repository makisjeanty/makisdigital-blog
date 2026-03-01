<x-app-layout>
    <x-slot name="header">Biblioteca de Mídia</x-slot>

    <div class="admin-card">
        <div class="admin-card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="admin-card-title">Arquivos Enviados</div>
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="file" name="file" id="fileInput" style="display: none;"
                    onchange="document.getElementById('uploadForm').submit()">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M16 8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Fazer Upload
                </button>
            </form>
        </div>

        <div style="padding: 1.5rem;">
            @if(count($files) > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                    @foreach($files as $file)
                        <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; overflow: hidden; position: relative; transition: all 0.3s ease;"
                            class="media-item">
                            <div style="aspect-ratio: 16/10; overflow: hidden; background: #000;">
                                <img src="{{ $file['url'] }}"
                                    style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;"
                                    alt="{{ $file['name'] }}">
                            </div>

                            <div style="padding: 0.75rem;">
                                <p
                                    style="font-size: 0.8rem; font-weight: 600; color: #e4e4e7; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0.25rem;">
                                    {{ $file['name'] }}
                                </p>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 0.7rem; color: #6b7280;">{{ $file['size'] }}</span>
                                    <span style="font-size: 0.7rem; color: #4b5563;">{{ $file['directory'] }}</span>
                                </div>
                            </div>

                            <div class="media-actions"
                                style="position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; gap: 0.75rem; opacity: 0; transition: opacity 0.2s ease;">
                                <button onclick="copyToClipboard('{{ $file['url'] }}')" class="btn-icon" title="Copiar URL"
                                    style="background: rgba(255,255,255,0.1); color: white;">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                    </svg>
                                </button>

                                <form action="{{ route('admin.media.destroy', urlencode($file['path'])) }}" method="POST"
                                    onsubmit="return confirm('Excluir este arquivo permanentemente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon"
                                        style="background: rgba(239,68,68,0.2); color: #f87171;">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 4rem 0;">
                    <svg style="width: 48px; height: 48px; color: #374151; margin: 0 auto 1rem;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p style="color: #6b7280;">Nenhum arquivo encontrado na biblioteca.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .media-item:hover .media-actions {
            opacity: 1 !important;
        }

        .media-item:hover {
            transform: translateY(-4px);
            border-color: rgba(108, 99, 255, 0.3) !important;
        }
    </style>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('URL copiada para o clipboard!');
            });
        }
    </script>
</x-app-layout>