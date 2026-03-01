@extends('layouts.blog')

@section('title', 'Minha Área - Makis Digital')

@section('content')
    <section style="padding-top: 110px; padding-bottom: 70px;">
        <div class="container-ref">
            <header style="margin-bottom: 2rem;">
                <h1 style="font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem;">Minha Área do Aluno</h1>
                <p style="color: var(--text-secondary);">
                    Acompanhe seus cursos e continue de onde parou.
                </p>
            </header>

            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 1rem;">Meus Cursos</h2>

                @if($enrolledCourses->isEmpty())
                    <div class="glass-section">
                        <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                            Você ainda não está matriculado em nenhum curso.
                        </p>
                        <a href="{{ route('courses.index') }}" class="btn-primary-ref" style="display: inline-flex;">
                            Ver cursos disponíveis
                        </a>
                    </div>
                @else
                    <div class="courses-grid-refined">
                        @foreach($enrolledCourses as $course)
                            <article class="course-card-refined">
                                <div class="course-card-content">
                                    <h3 class="course-card-title">{{ $course->title }}</h3>
                                    <p class="course-card-excerpt">{{ $course->excerpt ?: 'Curso adquirido com sucesso.' }}</p>
                                    <a href="{{ route('courses.show', $course->slug) }}" class="course-card-link">
                                        Acessar curso
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($recommendedCourses->isNotEmpty())
                <div>
                    <h2 style="font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 1rem;">Recomendados para Você</h2>
                    <div class="courses-grid-refined">
                        @foreach($recommendedCourses as $course)
                            <article class="course-card-refined">
                                <div class="course-card-content">
                                    <h3 class="course-card-title">{{ $course->title }}</h3>
                                    <p class="course-card-excerpt">{{ $course->excerpt ?: 'Conheça este curso.' }}</p>
                                    <a href="{{ route('courses.show', $course->slug) }}" class="course-card-link">
                                        Ver detalhes
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
