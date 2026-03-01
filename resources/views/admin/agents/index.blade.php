<x-app-layout>
    <x-slot name="header">Agents</x-slot>

    @if(session('success'))
        <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-transition>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span style="flex: 1;">{{ session('success') }}</span>
            <button @click="show = false" class="btn-icon" style="color: #34d399;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert" style="background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.25);" x-data="{ show: true }" x-show="show" x-transition>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M3.055 11a9 9 0 1117.89 0 9 9 0 01-17.89 0z" />
            </svg>
            <span style="flex: 1;">{{ session('error') }}</span>
            <button @click="show = false" class="btn-icon" style="color: #f87171;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert" style="background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.25);">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M3.055 11a9 9 0 1117.89 0 9 9 0 01-17.89 0z" />
            </svg>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title">Executar Agente</div>
        </div>

        <form action="{{ route('admin.agents.run') }}" method="POST" style="padding: 1.5rem;">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: .5rem; color: #9ca3af; font-size: .85rem;">Agente</label>
                    <select name="agent_key" class="form-input" required>
                        <option value="">Selecione...</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent['key'] }}" @selected(old('agent_key') === $agent['key'])>
                                {{ $agent['label'] }} ({{ $agent['key'] }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: .5rem; color: #9ca3af; font-size: .85rem;">Payload JSON
                        (opcional)</label>
                    <textarea name="payload_json" rows="7" class="form-textarea" style="font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;"
                        placeholder='{"topic":"SEO para blog","audience":"iniciante"}'>{{ old('payload_json') }}</textarea>
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Executar
                </button>
            </div>
        </form>
    </div>

    <div class="stats-grid" style="margin-top: 1rem;">
        @foreach($agents as $agent)
            <div class="stat-card" style="text-align: left;">
                <div style="display: flex; justify-content: space-between; gap: .75rem; align-items: center;">
                    <div class="stat-label" style="font-size: .75rem;">{{ strtoupper($agent['key']) }}</div>
                    <span style="font-size: .72rem; color: #a78bfa;">{{ count($agent['skills']) }} skills</span>
                </div>
                <div style="font-weight: 700; color: #f8fafc; margin: .5rem 0 1rem;">{{ $agent['label'] }}</div>

                <div style="font-size: .8rem; color: #9ca3af;">
                    <strong style="color:#d1d5db;">Responsabilidades:</strong>
                    <ul style="margin-top: .5rem; padding-left: 1rem; display: grid; gap: .35rem;">
                        @foreach($agent['responsibilities'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <div class="admin-card" style="margin-top: 1.5rem;">
        <div class="admin-card-header">
            <div class="admin-card-title">Execuções Recentes</div>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Agente</th>
                        <th>Status</th>
                        <th>Origem</th>
                        <th>Usuário</th>
                        <th>Executado</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($runs as $run)
                        <tr>
                            <td>#{{ $run->id }}</td>
                            <td>{{ $run->agent_key }}</td>
                            <td>
                                @if($run->status === 'success')
                                    <span class="badge badge-success"><span class="badge-dot"></span>Sucesso</span>
                                @else
                                    <span class="badge badge-warning"><span class="badge-dot"></span>Falha</span>
                                @endif
                            </td>
                            <td>{{ $run->source }}</td>
                            <td>{{ $run->user?->name ?? 'Sistema/API key' }}</td>
                            <td>{{ $run->executed_at?->format('d/m/Y H:i:s') }}</td>
                            <td style="min-width: 320px;">
                                <details>
                                    <summary style="cursor: pointer; color: #a78bfa;">Ver payload/result</summary>
                                    <div style="margin-top: .5rem; display: grid; gap: .5rem;">
                                        <div>
                                            <div style="font-size: .75rem; color: #9ca3af;">Payload</div>
                                            <pre style="white-space: pre-wrap; background: rgba(0,0,0,.25); padding: .5rem; border-radius: 8px; font-size: .72rem; color: #d1d5db;">{{ json_encode($run->payload ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                        <div>
                                            <div style="font-size: .75rem; color: #9ca3af;">Resultado</div>
                                            <pre style="white-space: pre-wrap; background: rgba(0,0,0,.25); padding: .5rem; border-radius: 8px; font-size: .72rem; color: #d1d5db;">{{ json_encode($run->result ?? ['error' => $run->error_message], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>
                                </details>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #9ca3af;">Nenhuma execução ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($runs->hasPages())
            <div class="admin-pagination">
                {{ $runs->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
