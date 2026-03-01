@extends('layouts.blog')

@section('title', 'Política de Privacidade - Makis Digital')

@section('content')
    <section class="blog-hero-refined" style="padding: 100px 0 40px;">
        <div class="container-ref">
            <div class="hero-badge animate-fade-in">
                <span class="dot"></span>
                Legal & Ética
            </div>
            <h1 class="hero-title animate-fade-in animate-delay-1" style="font-size: clamp(2rem, 4vw, 3rem);">
                Política de <span class="gradient-text">Privacidade</span>
            </h1>
            <p class="hero-subtitle animate-fade-in animate-delay-2" style="max-width: 700px;">
                Sua privacidade é nossa prioridade. Entenda como protegemos e respeitamos seus dados de acordo com as leis
                de proteção de dados vigentes.
            </p>
        </div>
    </section>

    <section class="posts-section" style="padding-top: 0;">
        <div class="container-ref" style="max-width: 850px;">
            <div class="glass-section animate-fade-in animate-delay-3" style="padding: 4rem;">
                <div class="post-content">
                    <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 2.5rem;">Última atualização: 25 de
                        Fevereiro de 2026</p>

                    <h2>1. Introdução</h2>
                    <p>A Makis Digital respeita a sua privacidade e está empenhada em proteger os seus dados pessoais. Esta
                        política de privacidade irá informá-lo sobre como cuidamos dos seus dados pessoais quando visita o
                        nosso website e informá-lo-á sobre os seus direitos de privacidade e como a lei o protege.</p>

                    <h2>2. Os dados que recolhemos</h2>
                    <p>Dados pessoais significa qualquer informação sobre um indivíduo a partir da qual essa pessoa possa
                        ser identificada. Podemos recolher, usar, armazenar e transferir diferentes tipos de dados pessoais
                        sobre si, que agrupamos da seguinte forma:</p>
                    <ul>
                        <li><strong>Dados de Identidade:</strong> inclui nome, sobrenome, nome de usuário ou identificador
                            semelhante.</li>
                        <li><strong>Dados de Contato:</strong> inclui endereço de e-mail e números de telefone (quando
                            fornecidos em formulários).</li>
                        <li><strong>Dados Técnicos:</strong> inclui endereço IP, seus dados de login, tipo e versão do
                            navegador, configuração e localização do fuso horário.</li>
                        <li><strong>Dados de Utilização:</strong> inclui informações sobre como utiliza o nosso website,
                            produtos e serviços.</li>
                    </ul>

                    <h2>3. Como utilizamos os seus dados</h2>
                    <p>Apenas usaremos os seus dados pessoais quando a lei nos permitir. Mais comumente, usaremos os seus
                        dados pessoais nas seguintes circunstâncias:</p>
                    <ul>
                        <li>Para registrar você como um novo aluno ou assinante da newsletter.</li>
                        <li>Para processar e entregar seus cursos adquiridos.</li>
                        <li>Para gerir a nossa relação consigo (ex: notificar alterações).</li>
                        <li>Para administrar e proteger este website.</li>
                    </ul>

                    <h2>4. Segurança de Dados</h2>
                    <p>Implementamos medidas de segurança adequadas para evitar que os seus dados pessoais sejam
                        acidentalmente perdidos, utilizados ou acedidos de forma não autorizada, alterados ou divulgados.
                        Além disso, limitamos o acesso aos seus dados pessoais aos funcionários e parceiros que têm uma
                        necessidade comercial de os conhecer.</p>

                    <h2>5. Seus Direitos Legais</h2>
                    <p>Sob certas circunstâncias, você tem direitos sob as leis de proteção de dados em relação aos seus
                        dados pessoais, incluindo o direito de solicitar acesso, correção, apagamento, restrição,
                        transferência ou oposição ao processamento.</p>

                    <div
                        style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--border-color); text-align: center;">
                        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Tem dúvidas sobre nossa política
                            legal?</p>
                        <a href="{{ route('pages.contato') }}" class="btn-secondary-ref">Entrar em Contato</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .glass-section {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 30px;
        }
    </style>
@endsection