<x-app-layout>
    <x-slot name="header">Configurações do Sistema</x-slot>

    <div class="admin-card">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h3 style="margin-bottom: 1.5rem; color: #fff;">Geral</h3>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">Nome do Site</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                            style="width: 100%; background: #1e293b; border: 1px solid #334155; color: #fff; padding: 0.75rem; border-radius: 0.5rem;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">Descrição (SEO)</label>
                        <textarea name="site_description" rows="3"
                            style="width: 100%; background: #1e293b; border: 1px solid #334155; color: #fff; padding: 0.75rem; border-radius: 0.5rem;">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>
                </div>

                <div>
                    <h3 style="margin-bottom: 1.5rem; color: #fff;">Contato & Redes</h3>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">E-mail de Contato</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}"
                            style="width: 100%; background: #1e293b; border: 1px solid #334155; color: #fff; padding: 0.75rem; border-radius: 0.5rem;">
                    </div>
                </div>
            </div>

            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #334155;">
                <button type="submit" class="topbar-btn" style="background: #3b82f6; border: none; cursor: pointer;">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</x-app-layout>