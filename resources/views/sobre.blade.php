@extends('layouts.blog')

@section('title', 'Sobre Nós - Makis Digital')

@section('content')
    <section class="blog-hero-refined">
        <div class="container-ref">
            <div class="hero-badge animate-fade-in">
                <span class="dot"></span>
                Nossa História
            </div>
            <h1 class="hero-title animate-fade-in animate-delay-1">
                Humanizando a <br>
                <span class="gradient-text">Era Digital</span>
            </h1>
            <p class="hero-subtitle animate-fade-in animate-delay-2">
                A Makis Digital nasceu da paixão por tecnologia e do desejo de tornar o conhecimento técnico acessível e
                estratégico para negócios reais.
            </p>
        </div>
    </section>

    <section class="posts-section" style="padding-top: 0;">
        <div class="container-ref">
            <!-- Main Story Section -->
            <div class="about-story-grid">
                <div class="story-image-box animate-fade-in animate-delay-3">
                    <div class="glass-image-container">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1200"
                            alt="Equipe Makis Digital">
                        <div class="image-experience-badge">
                            <strong>5+</strong>
                            <span>Anos de Inovação</span>
                        </div>
                    </div>
                </div>
                <div class="story-content-box animate-fade-in animate-delay-4">
                    <h2 class="section-subtitle-refined">Onde tudo começou</h2>
                    <div class="post-content">
                        <p>Em 2021, percebemos que havia um abismo entre o avanço tecnológico e a capacidade de
                            implementação das empresas. A tecnologia estava acelerando, mas o fator humano estava ficando
                            para trás.</p>
                        <p>Fundamos a <strong>Makis Digital</strong> não apenas como uma agência ou um blog, mas como um
                            ecossistema de aprendizado e performance. Nosso objetivo é fornecer as ferramentas e o
                            conhecimento necessários para que qualquer profissional ou empresa possa prosperar na economia
                            digital moderna.</p>
                        <blockquote>
                            "A tecnologia deve servir ao propósito humano, não o contrário. Nosso trabalho é construir essa
                            ponte."
                        </blockquote>
                    </div>
                </div>
            </div>

            <!-- Values Section -->
            <div class="about-values-section">
                <div class="section-header-row" style="justify-content: center; text-align: center;">
                    <div>
                        <h2 class="home-section-title">Nossos Valores</h2>
                        <p style="color: var(--text-secondary);">O que nos guia todos os dias em cada linha de código e
                            estratégia.</p>
                    </div>
                </div>

                <div class="expertise-grid" style="margin-top: 4rem;">
                    <div class="expertise-card">
                        <div class="expertise-icon-box"
                            style="background: rgba(108, 99, 255, 0.1); color: var(--accent-primary);">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.148l.83-4.742c.097-.553.637-.97 1.199-.925 1.27.106 2.546.145 3.826.145m6.143-5.241C19.009 11.201 20 14.483 20 18m-6-10c0-1.105.895-2 2-2s2 .895 2 2-2 2-2 2H6" />
                            </svg>
                        </div>
                        <h3>Transparência Radical</h3>
                        <p>Acreditamos em processos claros e resultados mensuráveis. Sem "caixas pretas" tecnológicas.</p>
                    </div>
                    <div class="expertise-card">
                        <div class="expertise-icon-box" style="background: rgba(6, 182, 212, 0.1); color: #06b6d4;">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 .517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.022.547l-2.387 2.387a2 2 0 102.828 2.828l3.182-3.182c.28-.28.66-.43 1.054-.42l3.415.086c.394.01.774-.14 1.054-.42l3.182-3.182a2 2 0 10-2.828-2.828l-2.387 2.387z" />
                            </svg>
                        </div>
                        <h3>Educação Contínua</h3>
                        <p>O mercado muda a cada segundo. Nosso compromisso é nunca parar de aprender e ensinar.</p>
                    </div>
                    <div class="expertise-card">
                        <div class="expertise-icon-box"
                            style="background: rgba(167, 139, 250, 0.1); color: var(--accent-secondary);">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3>Inovação Estratégica</h3>
                        <p>Não usamos tecnologia só porque é nova, mas porque resolve problemas reais de forma elegante.</p>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta-banner animate-fade-in" style="margin-top: 8rem;">
                <div class="cta-inner">
                    <h2 class="home-section-title" style="margin-bottom: 1rem;">Quer fazer parte da nossa jornada?</h2>
                    <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto 2.5rem;">
                        Seja como aluno, parceiro ou colaborador, estamos sempre em busca de mentes brilhantes.
                    </p>
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('pages.contato') }}" class="btn-primary-ref">Falar com a Equipe</a>
                        <a href="{{ route('blog.index') }}" class="btn-ghost-ref">Ver nosso Trabalho</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .about-story-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
            margin-bottom: 100px;
        }

        .glass-image-container {
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.6);
        }

        .glass-image-container img {
            width: 100%;
            height: 600px;
            object-fit: cover;
        }

        .image-experience-badge {
            position: absolute;
            bottom: 2rem;
            right: 2rem;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            border-radius: 20px;
            text-align: center;
            z-index: 10;
        }

        .image-experience-badge strong {
            display: block;
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .image-experience-badge span {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-secondary);
            font-weight: 700;
        }

        .about-values-section {
            padding: 100px 0;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 992px) {
            .about-story-grid {
                grid-template-columns: 1fr;
                gap: 4rem;
            }

            .glass-image-container img {
                height: 400px;
            }
        }
    </style>
@endsection