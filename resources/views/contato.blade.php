@extends('layouts.blog')

@section('title', 'Entre em Contato - Makis Digital')

@section('content')
    <section class="blog-hero-refined">
        <div class="container-ref">
            <div class="hero-badge animate-fade-in">
                <span class="dot"></span>
                Suporte & Parcerias
            </div>
            <h1 class="hero-title animate-fade-in animate-delay-1">
                Vamos Iniciar uma <br>
                <span class="gradient-text">Conversa?</span>
            </h1>
            <p class="hero-subtitle animate-fade-in animate-delay-2">
                Seja para tirar dúvidas sobre cursos, propor parcerias ou apenas dizer um oi, estamos prontos para ouvir
                você.
            </p>
        </div>
    </section>

    <section class="posts-section" style="padding-top: 0;">
        <div class="container-ref">
            <div class="contact-grid-refined">
                <!-- Contact Info Sidebar -->
                <div class="contact-info-sidebar animate-fade-in animate-delay-3">
                    <div class="info-card-refined">
                        <h2 class="info-card-title">Canais Diretos</h2>
                        <p class="info-card-desc">Escolha a melhor forma de se conectar conosco.</p>

                        <div class="info-item-refined">
                            <div class="info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div class="info-text">
                                <strong>E-mail Geral</strong>
                                <a href="mailto:contato@makisdigital.com">contato@makisdigital.com</a>
                            </div>
                        </div>

                        <div class="info-item-refined">
                            <div class="info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="info-text">
                                <strong>Nossa Base</strong>
                                <span>São Paulo, Brasil <br>(Operação 100% Remota)</span>
                            </div>
                        </div>

                        <div class="social-links-refined">
                            <h4 class="social-title">Redes Sociais</h4>
                            <div class="social-icons-row">
                                <a href="#" class="social-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                    </svg></a>
                                <a href="#" class="social-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                    </svg></a>
                                <a href="#" class="social-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                        </path>
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-refined animate-fade-in animate-delay-4">
                    <div class="form-container-refined">
                        @if(session('success'))
                            <div class="success-alert animate-fade-in">
                                <div class="success-icon">✓</div>
                                <div class="success-content">
                                    <strong>Mensagem enviada!</strong>
                                    <p>{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('pages.contato.store') }}" method="POST" class="premium-form">
                            @csrf
                            <div class="form-row-refined">
                                <div class="input-group-refined">
                                    <label for="name">Nome Completo</label>
                                    <input type="text" id="name" name="name" placeholder="Como você se chama?" required
                                        value="{{ old('name') }}">
                                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                                </div>
                                <div class="input-group-refined">
                                    <label for="email">Seu Melhor E-mail</label>
                                    <input type="email" id="email" name="email" placeholder="exemplo@email.com" required
                                        value="{{ old('email') }}">
                                    @error('email') <span class="error-text">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group-refined">
                                <label for="subject">Assunto da Mensagem</label>
                                <select id="subject" name="subject">
                                    <option value="Sugestão de Conteúdo" {{ old('subject') == 'Sugestão de Conteúdo' ? 'selected' : '' }}>Sugestão de Conteúdo</option>
                                    <option value="Parceria Comercial" {{ old('subject') == 'Parceria Comercial' ? 'selected' : '' }}>Parceria Comercial</option>
                                    <option value="Dúvida sobre Cursos" {{ old('subject') == 'Dúvida sobre Cursos' ? 'selected' : '' }}>Dúvida sobre Cursos</option>
                                    <option value="Erro no Site" {{ old('subject') == 'Erro no Site' ? 'selected' : '' }}>Erro
                                        no Site</option>
                                    <option value="Outros" {{ old('subject') == 'Outros' ? 'selected' : '' }}>Outros</option>
                                </select>
                            </div>

                            <div class="input-group-refined">
                                <label for="message">Sua Mensagem</label>
                                <textarea id="message" name="message" rows="6"
                                    placeholder="Escreva aqui o que você deseja nos contar..."
                                    required>{{ old('message') }}</textarea>
                                @error('message') <span class="error-text">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn-primary-ref"
                                style="width: 100%; justify-content: center; padding: 1.25rem;">
                                Enviar Mensagem Agora
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .contact-grid-refined {
            display: grid;
            grid-template-columns: 1fr 1.6fr;
            gap: 4rem;
            margin-top: -20px;
        }

        .info-card-refined {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3.5rem 2.5rem;
            position: sticky;
            top: 120px;
        }

        .info-card-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .info-card-desc {
            color: var(--text-secondary);
            margin-bottom: 3rem;
            font-size: 1rem;
        }

        .info-item-refined {
            display: flex;
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .info-icon {
            width: 48px;
            height: 48px;
            background: rgba(108, 99, 255, 0.1);
            color: var(--accent-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            flex-shrink: 0;
        }

        .info-text strong {
            display: block;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 0.4rem;
        }

        .info-text a,
        .info-text span {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .info-text a:hover {
            color: var(--accent-primary);
        }

        .social-links-refined {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .social-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .social-icons-row {
            display: flex;
            gap: 1rem;
        }

        .social-btn {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .social-btn:hover {
            background: var(--accent-primary);
            color: white;
            transform: translateY(-3px);
        }

        .form-container-refined {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 30px;
            padding: 4rem;
        }

        .premium-form {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }

        .form-row-refined {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .input-group-refined {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .input-group-refined label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-left: 0.5rem;
        }

        .input-group-refined input,
        .input-group-refined select,
        .input-group-refined textarea {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group-refined input:focus,
        .input-group-refined select:focus,
        .input-group-refined textarea:focus {
            border-color: var(--accent-primary);
            background: rgba(108, 99, 255, 0.05);
            box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.1);
        }

        .error-text {
            font-size: 0.75rem;
            color: #f87171;
            margin-left: 0.5rem;
        }

        .success-alert {
            display: flex;
            gap: 1.5rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            align-items: center;
        }

        .success-icon {
            width: 48px;
            height: 48px;
            background: #10b981;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.5rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .success-content strong {
            display: block;
            color: #34d399;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }

        .success-content p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        @media (max-width: 992px) {
            .contact-grid-refined {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .info-card-refined {
                position: relative;
                top: 0;
            }

            .form-container-refined {
                padding: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .form-row-refined {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection