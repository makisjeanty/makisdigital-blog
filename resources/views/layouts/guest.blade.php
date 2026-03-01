<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Makis Digital') }} - Autenticação</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for simple blade without build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/app.js') }}?v={{ time() }}" defer></script>

    <style>
        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --accent-primary: #6c63ff;
            --accent-secondary: #a78bfa;
            --text-primary: #f0f0f5;
            --text-secondary: #9ca3af;
            --border-color: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .auth-background {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: radial-gradient(circle at 50% -20%, rgba(108, 99, 255, 0.15) 0%, rgba(10, 10, 15, 0) 50%),
                radial-gradient(circle at 0% 100%, rgba(167, 139, 250, 0.05) 0%, rgba(10, 10, 15, 0) 40%);
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1.5rem;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: rgba(18, 18, 26, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-primary), transparent);
            opacity: 0.5;
        }

        .auth-logo {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .auth-logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6c63ff, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .auth-subtitle {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        /* Overriding Tailwind/Breeze default colors for inputs */
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid var(--border-color) !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 0.75rem 1rem !important;
            transition: all 0.3s ease !important;
        }

        input:focus {
            border-color: var(--accent-primary) !important;
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.15) !important;
            outline: none !important;
        }

        .btn-primary {
            width: 100%;
            background: var(--accent-primary);
            color: white;
            padding: 0.85rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: #5a52e0;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .auth-link {
            color: var(--accent-secondary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-link:hover {
            color: var(--accent-primary);
            text-underline-offset: 4px;
            text-decoration: underline;
        }

        .animate-fade-up {
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="antialiased">
    <div class="auth-background"></div>

    <div class="auth-container">
        <div class="animate-fade-up">
            <a href="/" class="auth-logo">
                <span class="auth-logo-text">MAKIS DIGITAL</span>
                <span
                    style="font-size: 0.7rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.2em; font-weight: 600;">Ecosystem</span>
            </a>

            <div class="auth-card">
                {{ $slot }}
            </div>

            <div class="auth-footer">
                &copy; {{ date('Y') }} Makis Digital. Todos os direitos reservados.
            </div>
        </div>
    </div>
</body>

</html>