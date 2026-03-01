@extends('layouts.blog')

@section('title', 'Makis Digital - Estratégias Digitais & Tecnologia')

@section('content')
    <!-- Hero Section -->
    <section class="home-hero-refined">
        <div class="hero-image-overlay" style="background-image: url('{{ asset('hero-bg.png') }}');"></div>
        <div class="hero-content-wrapper">
            <div class="hero-badge animate-fade-in">
                <span class="dot"></span>
                Futuro Digital 2026
            </div>
            <h1 class="home-hero-title animate-fade-in animate-delay-1">
                Impulsionamos seu <br>
                <span class="gradient-text">Sucesso Digital</span>
            </h1>
            <p class="home-hero-subtitle animate-fade-in animate-delay-2">
                Makis Digital é o seu hub para estratégias de alto nível, inteligência artificial e aprendizado contínuo.
                Transformamos complexidade em resultados.
            </p>
            <div class="hero-actions animate-fade-in animate-delay-3">
                <a href="{{ route('pages.contato') }}" class="btn-primary-ref">
                    Começar Jornada
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="{{ route('blog.index') }}" class="btn-secondary-ref">
                    Explorar Blog
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="stats-bar animate-fade-in">
        <div class="stat-item">
            <span class="stat-num">+100k</span>
            <span class="stat-desc">Acessos Mensais</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-num">50+</span>
            <span class="stat-desc">Cursos Online</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <span class="stat-num">24h</span>
            <span class="stat-desc">Inovação Diária</span>
        </div>
    </div>

    <!-- Services Section -->
    <section class="home-section" id="servicos">
        <div class="home-section-header">
            <h2 class="home-section-title">Nossa Expertise</h2>
            <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Oferecemos o que há de mais moderno
                em tecnologia e marketing para o seu negócio.</p>
        </div>

        <div class="expertise-grid">
            <div class="expertise-card animate-fade-in animate-delay-1">
                <div class="expertise-icon-box">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3>Alta Performance</h3>
                <p>Sistemas otimizados para velocidade extrema e conversão máxima.</p>
            </div>
            <div class="expertise-card animate-fade-in animate-delay-2">
                <div class="expertise-icon-box" style="background: rgba(108, 99, 255, 0.1); color: var(--accent-primary);">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3>Estratégia de IA</h3>
                <p>Implementação de agentes inteligentes para automatizar seu workflow.</p>
            </div>
            <div class="expertise-card animate-fade-in animate-delay-3">
                <div class="expertise-icon-box" style="background: rgba(6, 182, 212, 0.1); color: #06b6d4;">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332 0.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332 0.477-4.5 1.253" />
                    </svg>
                </div>
                <h3>Educação Digital</h3>
                <p>Treinamentos práticos focados nas demandas reais do mercado.</p>
            </div>
        </div>
    </section>

    <!-- Latest Content -->
    <section class="home-section light-bg">
        <div class="container-ref">
            <div class="section-header-row">
                <div>
                    <h2 class="home-section-title" style="text-align: left;">Conteúdo Fresh</h2>
                    <p style="color: var(--text-secondary);">Mantenha-se atualizado com nossas últimas publicações.</p>
                </div>
                <a href="{{ route('blog.index') }}" class="btn-ghost-ref">
                    Ver tudo
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="posts-grid">
                @foreach($latestPosts as $index => $post)
                    <x-blog.post-card :post="$post" :delay="($index % 3) + 1" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Courses Showcase -->
    @if($featuredCourses->count() > 0)
        <section class="home-section">
            <div class="container-ref">
                <div class="section-header-row">
                    <div>
                        <h2 class="home-section-title" style="text-align: left;">Domine o Agora</h2>
                        <p style="color: var(--text-secondary);">Cursos desenhados para acelerar sua carreira.</p>
                    </div>
                    <a href="{{ route('courses.index') }}" class="btn-ghost-ref">
                        Explorar Cursos
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="courses-grid-refined">
                    @foreach($featuredCourses as $index => $course)
                        <x-course.course-card :course="$course" :delay="($index % 3) + 1" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Newsletter Section -->
    <section class="home-section" style="padding-top: 0; padding-bottom: 8rem;">
        <div class="container-ref">
            <div class="home-newsletter-card animate-fade-in">
                <div class="newsletter-icon-circle">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <div class="newsletter-info">
                    <h3>Fique por dentro do futuro</h3>
                    <p>Receba semanalmente insights sobre IA, desenvolvimento e o mercado digital de 2026.</p>
                </div>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" id="homeNewsletterForm"
                    class="home-newsletter-form">
                    @csrf
                    <div class="input-glow-group">
                        <input type="email" name="email" placeholder="Seu melhor e-mail" required>
                        <button type="submit" class="btn-primary-ref">Fazer parte da lista</button>
                    </div>
                </form>
            </div>
            <div id="homeNewsletterStatus"
                style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; display: none;"></div>
        </div>
    </section>

    <!-- Large CTA Section -->
    <section class="home-section" style="padding-top: 0;">
        <div class="cta-banner animate-fade-in">
            <div class="cta-inner">
                <h2 class="home-section-title" style="margin-bottom: 1rem;">Pronto para sua evolução?</h2>
                <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto 2.5rem;">
                    Junte-se a centenas de empresas e profissionais que já transformaram seus resultados conosco.
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('pages.contato') }}" class="btn-primary-ref">Falar com Consultor</a>
                    <a href="{{ route('register') }}" class="btn-secondary-ref">Criar Conta Grátis</a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .home-hero-refined {
            min-height: 90vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            padding: 0 1.5rem;
        }

        .hero-image-overlay {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            z-index: -1;
        }

        .hero-content-wrapper {
            max-width: 900px;
            z-index: 1;
        }

        .hero-actions {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-top: 2.5rem;
        }

        .btn-primary-ref {
            background: var(--gradient-1);
            color: white !important;
            padding: 1.1rem 2.8rem;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(108, 99, 255, 0.3);
        }

        .btn-primary-ref:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(108, 99, 255, 0.5);
        }

        .btn-secondary-ref {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            padding: 1.1rem 2.8rem;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
        }

        .btn-secondary-ref:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .stats-bar {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            max-width: 900px;
            margin: -80px auto 40px;
            display: flex;
            justify-content: space-around;
            padding: 2.5rem;
            z-index: 10;
            position: relative;
        }

        .stat-item {
            text-align: center;
        }

        .stat-num {
            display: block;
            font-size: 2.5rem;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        .stat-desc {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-divider {
            width: 1px;
            background: var(--border-color);
        }

        .expertise-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .expertise-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem;
            transition: all 0.4s ease;
        }

        .expertise-card:hover {
            border-color: var(--accent-primary);
            background: var(--bg-card-hover);
            transform: translateY(-5px);
        }

        .expertise-icon-box {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: rgba(167, 139, 250, 0.1);
            color: var(--accent-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .expertise-card h3 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .expertise-card p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .section-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3.5rem;
        }

        .btn-ghost-ref {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent-secondary);
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-ghost-ref:hover {
            gap: 0.8rem;
            color: white;
        }

        .cta-banner {
            background: radial-gradient(circle at 100% 0%, rgba(108, 99, 255, 0.2) 0%, transparent 100%),
                radial-gradient(circle at 0% 100%, rgba(6, 182, 212, 0.1) 0%, transparent 100%);
            background-color: var(--bg-secondary);
            border-radius: 40px;
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            border: 1px solid var(--border-color);
            text-align: center;
        }

        .light-bg {
            background: rgba(255, 255, 255, 0.015);
        }

        .container-ref {
            max-width: 1200px;
            margin: 0 auto;
        }

        .courses-grid-refined {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .home-newsletter-card {
            background: linear-gradient(135deg, rgba(108, 99, 255, 0.1), rgba(6, 182, 212, 0.05));
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 35px;
            padding: 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 3rem;
            position: relative;
            overflow: hidden;
        }

        .home-newsletter-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(108, 99, 255, 0.05) 0%, transparent 60%);
            z-index: 0;
            pointer-events: none;
        }

        .newsletter-icon-circle {
            width: 80px;
            height: 80px;
            background: var(--gradient-1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 20px 40px rgba(108, 99, 255, 0.3);
            z-index: 1;
        }

        .newsletter-info {
            flex: 1;
            z-index: 1;
        }

        .newsletter-info h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .newsletter-info p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .home-newsletter-form {
            flex: 1.2;
            z-index: 1;
        }

        .input-glow-group {
            display: flex;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border-color);
            padding: 0.5rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .input-glow-group:focus-within {
            border-color: var(--accent-primary);
            box-shadow: 0 0 20px rgba(108, 99, 255, 0.15);
        }

        .input-glow-group input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 0 1.5rem;
            color: white;
            outline: none;
            font-size: 1rem;
        }

        @media (max-width: 992px) {
            .home-newsletter-card {
                flex-direction: column;
                text-align: center;
                padding: 3rem 2rem;
                gap: 2rem;
            }

            .input-glow-group {
                flex-direction: column;
                gap: 1rem;
                background: transparent;
                border: none;
                padding: 0;
            }

            .input-glow-group input {
                background: var(--bg-secondary);
                border: 1px solid var(--border-color);
                padding: 1.25rem;
                border-radius: 15px;
            }
        }

        @media (max-width: 768px) {
            .hero-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .stats-bar {
                flex-direction: column;
                gap: 2rem;
                margin-top: -40px;
                padding: 2rem;
            }

            .stat-divider {
                height: 1px;
                width: 100%;
            }

            .section-header-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }
        }
    </style>
@endsection