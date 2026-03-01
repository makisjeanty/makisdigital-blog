@extends('layouts.blog')

@section('title', $course->title . ' - Makis Digital Academy')

@section('content')
    <article style="padding-top: 100px;">
        <!-- Course Header -->
        <header class="course-header-refined">
            <div class="container-ref">
                <div class="course-header-grid">
                    <div class="course-header-content animate-fade-in">
                        <div class="course-badges">
                            <span class="course-info-badge">
                                {{ ucfirst($course->level) }}
                            </span>
                            @if($course->duration)
                                <span class="course-info-badge-secondary">
                                    {{ $course->duration }}
                                </span>
                            @endif
                        </div>

                        <h1 class="course-title-refined">
                            {{ $course->title }}
                        </h1>

                        <p class="course-excerpt-refined">
                            {{ $course->excerpt }}
                        </p>

                        <div class="course-pricing-box">
                            <div class="price-display">
                                <span class="price-label">Investimento</span>
                                <span class="price-value">
                                    {{ $course->price == 0 ? 'Grátis' : 'R$ ' . number_format($course->price, 2, ',', '.') }}
                                </span>
                            </div>
                            @auth
                                @if(auth()->user()->courses()->where('course_id', $course->id)->exists())
                                    <a href="{{ route('dashboard') }}" class="btn-primary-ref" style="background: #10b981;">
                                        ✓ Já Matriculado — Acessar
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('mercadopago.checkout', $course) }}" class="btn-primary-ref"
                                        style="background: #00b1ea;">
                                        💳 Pagar com Pix / Mercado Pago
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-primary-ref">
                                    Fazer Login para Comprar
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="course-header-visual animate-fade-in animate-delay-1">
                        <div class="course-image-wrapper-refined">
                            @if($course->image_path)
                                <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}">
                            @else
                                <div class="course-placeholder-refined">🎓</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <div class="container-ref">
            <div class="course-content-layout animate-fade-in animate-delay-2">
                <div class="course-main-column">
                    <div class="glass-section">
                        <h2 class="section-subtitle-refined">O que você vai aprender</h2>
                        <div class="post-content">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>
                </div>

                <aside class="course-sidebar-column">
                    <div class="sticky-sidebar">
                        <div class="sidebar-feature-box">
                            <h3 class="sidebar-title">Vantagens Exclusivas</h3>
                            <ul class="feature-list">
                                <li>
                                    <span class="check-icon">✓</span>
                                    <div>
                                        <strong>Conteúdo 2026</strong>
                                        <p>Sempre atualizado com as últimas novidades.</p>
                                    </div>
                                </li>
                                <li>
                                    <span class="check-icon">✓</span>
                                    <div>
                                        <strong>Acesso Vitalício</strong>
                                        <p>Assista quando e onde quiser, para sempre.</p>
                                    </div>
                                </li>
                                <li>
                                    <span class="check-icon">✓</span>
                                    <div>
                                        <strong>Certificado Digital</strong>
                                        <p>Valide suas habilidades no LinkedIn.</p>
                                    </div>
                                </li>
                            </ul>

                            <div class="sidebar-footer">
                                <p>Dúvidas? Fale conosco!</p>
                                <a href="mailto:suporte@makis.digital">suporte@makis.digital</a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </article>

    <style>
        .course-header-refined {
            padding: 60px 0 100px;
            background: radial-gradient(circle at 80% 20%, rgba(108, 99, 255, 0.1) 0%, transparent 50%);
        }

        .course-header-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .course-badges {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .course-title-refined {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 2rem;
            letter-spacing: -0.04em;
        }

        .course-excerpt-refined {
            font-size: 1.25rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 3rem;
        }

        .course-pricing-box {
            display: flex;
            align-items: center;
            gap: 3rem;
            padding: 1.5rem;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            width: fit-content;
        }

        .price-display {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .price-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        .course-image-wrapper-refined {
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.6);
            aspect-ratio: 16/10;
        }

        .course-image-wrapper-refined img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-content-layout {
            display: grid;
            grid-template-columns: 1.8fr 1fr;
            gap: 5rem;
            margin-bottom: 8rem;
        }

        .glass-section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 4rem;
        }

        .section-subtitle-refined {
            font-size: 1.8rem;
            margin-bottom: 2.5rem;
            letter-spacing: -0.02em;
        }

        .sticky-sidebar {
            position: sticky;
            top: 120px;
        }

        .sidebar-feature-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
        }

        .sidebar-title {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .feature-list li {
            display: flex;
            gap: 1rem;
        }

        .check-icon {
            width: 24px;
            height: 24px;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 900;
            flex-shrink: 0;
        }

        .feature-list strong {
            display: block;
            font-size: 1rem;
            color: var(--text-primary);
            margin-bottom: 0.2rem;
        }

        .feature-list p {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .sidebar-footer {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .sidebar-footer p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .sidebar-footer a {
            color: var(--accent-primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .course-header-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .course-content-layout {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .glass-section {
                padding: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .course-pricing-box {
                flex-direction: column;
                width: 100%;
                gap: 1.5rem;
                align-items: stretch;
                text-align: center;
            }
        }
    </style>
@endsection
