<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="@yield('meta_description', 'Makis Digital - Blog sobre tecnologia, desenvolvimento e inovação digital')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Makis Digital Blog')">
    <meta property="og:description"
        content="@yield('meta_description', 'Makis Digital - Blog sobre tecnologia, desenvolvimento e inovação digital')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Makis Digital Blog')">
    <meta property="twitter:description"
        content="@yield('meta_description', 'Makis Digital - Blog sobre tecnologia, desenvolvimento e inovação digital')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/og-image.jpg'))">

    <title>@yield('title', 'Makis Digital Blog')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS (CDN for simple blade without build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles and Scripts -->
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}?v={{ time() }}">
    <script src="{{ asset('js/blog.js') }}?v={{ time() }}" defer></script>
</head>

<body>
    <div class="bg-glow">
        <div class="glow-1"></div>
        <div class="glow-2"></div>
    </div>

    <!-- Navbar -->
    <nav class="blog-navbar" id="blogNavbar">
        <div class="navbar-inner">
            <a href="{{ route('home') }}" class="navbar-brand">Makis Digital</a>

            <div class="navbar-links">
                <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('courses.index') }}"
                    class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Cursos</a>
                <a href="{{ route('pages.sobre') }}"
                    class="{{ request()->routeIs('pages.sobre') ? 'active' : '' }}">Sobre</a>
                <a href="{{ route('pages.contato') }}"
                    class="{{ request()->routeIs('pages.contato') ? 'active' : '' }}">Contato</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn-login"
                        style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-color);">Painel</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-login"
                            style="background: transparent; border: 1px solid rgba(248, 113, 113, 0.2); color: #f87171;">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Entrar</a>
                @endauth
            </div>

            <button class="mobile-menu-btn" onclick="document.getElementById('mobileMenu').classList.toggle('active')"
                aria-label="Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ route('blog.index') }}">Blog</a>
        <a href="{{ route('courses.index') }}">Cursos</a>
        <a href="{{ route('pages.sobre') }}">Sobre</a>
        <a href="{{ route('pages.contato') }}">Contato</a>
        @auth
            <a href="{{ route('admin.posts.index') }}">Painel</a>
        @else
            <a href="{{ route('login') }}">Entrar</a>
        @endauth
    </div>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="blog-footer">
        <div class="footer-inner">
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; text-align: left; margin-bottom: 3rem;">
                <div>
                    <div class="footer-brand">Makis Digital</div>
                    <p class="footer-text" style="margin-bottom: 1.5rem;">Inovação, tecnologia e inteligência
                        artificial. O seu guia para o futuro digital em 2026.</p>
                    <div class="newsletter-form">
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" id="newsletterForm"
                            style="display: flex; gap: 0.5rem;">
                            @csrf
                            <input type="email" name="email" placeholder="Seu melhor e-mail" required
                                style="flex: 1; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; padding: 0.5rem 0.75rem; color: white; font-size: 0.8rem; outline: none;">
                            <button type="submit" class="btn-login"
                                style="padding: 0.5rem 1rem; font-size: 0.8rem;">Assinar</button>
                        </form>
                        <div id="newsletterStatus" style="font-size: 0.75rem; margin-top: 0.5rem; display: none;"></div>
                    </div>
                </div>
                <div>
                    <h4 style="font-size: 0.9rem; margin-bottom: 1.25rem; color: var(--text-primary);">Links Rápidos
                    </h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li><a href="{{ route('blog.index') }}"
                                style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Blog</a>
                        </li>
                        <li><a href="{{ route('pages.sobre') }}"
                                style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Sobre
                                Nós</a></li>
                        <li><a href="{{ route('pages.contato') }}"
                                style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Contato</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 style="font-size: 0.9rem; margin-bottom: 1.25rem; color: var(--text-primary);">Legal</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li><a href="{{ route('pages.privacidade') }}"
                                style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Política de
                                Privacidade</a></li>
                        <li><a href="#"
                                style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">Termos de
                                Uso</a></li>
                    </ul>
                </div>
            </div>
            <div
                style="border-top: 1px solid var(--border-color); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <p class="footer-text">&copy; {{ date('Y') }} Makis Digital. Todos os direitos reservados.</p>
                <div style="display: flex; gap: 1.5rem;">
                    <a href="#" style="color: var(--text-muted);"><svg width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg></a>
                    <a href="#" style="color: var(--text-muted);"><svg width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg></a>
                    <a href="#" style="color: var(--text-muted);"><svg width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                            </path>
                        </svg></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>