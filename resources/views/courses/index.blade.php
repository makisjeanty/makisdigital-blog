@extends('layouts.blog')

@section('title', 'Cursos e Treinamentos - Makis Digital')

@section('content')
    <!-- Courses Header -->
    <section class="blog-hero-refined">
        <div class="container-ref">
            <div class="hero-badge animate-fade-in">
                <span class="dot"></span>
                Educação de Elite
            </div>
            <h1 class="hero-title animate-fade-in animate-delay-1">
                Domine o <br>
                <span class="gradient-text">Mercado Digital</span>
            </h1>
            <p class="hero-subtitle animate-fade-in animate-delay-2">
                Aprenda as tecnologias mais quentes do mercado com quem vive o digital todos os dias. Cursos práticos,
                intensos e focados em resultados.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="posts-section">
        <div class="container-ref">
            @if($courses->count() > 0)
                <div class="courses-grid-refined">
                    @foreach($courses as $index => $course)
                        <x-course.course-card :course="$course" :delay="($index % 3) + 1" />
                    @endforeach
                </div>

                <div class="pagination-container animate-fade-in">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🎓</div>
                    <h3>Academia em Construção</h3>
                    <p>Nossos especialistas estão gravando as melhores aulas para você. Em breve, novos treinamentos!</p>
                    <a href="{{ route('blog.index') }}" class="btn-secondary-ref" style="margin-top: 2rem;">Ler Artigos do
                        Blog</a>
                </div>
            @endif
        </div>
    </section>

    <style>
        .blog-hero-refined {
            padding: 120px 0 60px;
            text-align: center;
            background: radial-gradient(circle at 50% 0%, rgba(108, 99, 255, 0.1) 0%, transparent 70%);
        }

        .container-ref {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .courses-grid-refined {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
        }

        .pagination-container {
            margin-top: 5rem;
            display: flex;
            justify-content: center;
        }
    </style>
@endsection