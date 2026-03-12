<?php
/** @var string|null $apiUrl */
$apiUrl = "https://api.lourencogabriel.dev3/v1";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentação | API Gateway</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #020617;
            --bg-glow: rgba(78, 161, 255, 0.08);
            --card-bg: rgba(15, 23, 42, 0.6);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary-main: #4ea1ff;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #f59e0b; /* Cor de alerta/construção */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background-color: var(--bg-base);
            background-image: radial-gradient(circle at 50% -20%, var(--bg-glow) 0%, transparent 50%);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .docs-container {
            max-width: 800px;
            margin: 0 auto;
            animation: fadeIn 0.8s ease-out;
        }

        header {
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 24px;
            margin-bottom: 40px;
        }

        .dev-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            padding: 6px 12px;
            border-radius: 6px;
            color: var(--accent);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        h1 { font-size: 2.2rem; letter-spacing: -0.02em; margin-bottom: 8px; }
        .subtitle { color: var(--text-muted); font-size: 1.1rem; }

        .content-section {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .content-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 100%;
            background: var(--accent);
        }

        h2 { font-size: 1.3rem; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }

        .skeleton-line {
            height: 12px;
            background: rgba(255,255,255,0.05);
            border-radius: 4px;
            margin-bottom: 12px;
            position: relative;
            overflow: hidden;
        }

        .skeleton-line::after {
            content: "";
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.03), transparent);
            animation: skeleton-loading 1.5s infinite;
        }

        code {
            font-family: 'Fira Code', monospace;
            background: rgba(0,0,0,0.3);
            padding: 2px 6px;
            border-radius: 4px;
            color: var(--primary-main);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
            margin-bottom: 20px;
        }

        .btn-back:hover { color: var(--primary-main); }

        @keyframes skeleton-loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="docs-container">
    <a href="javascript:history.back()" class="btn-back">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Voltar ao Gateway
    </a>

    <header>
        <div class="dev-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            Under Development
        </div>
        <h1>Documentação Técnica</h1>
        <p class="subtitle">Guia de referência para integração com a API v1.0</p>
    </header>

    <main>
        <section class="content-section">
            <h2><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> Autenticação</h2>
            <p style="margin-bottom: 20px;">A API utiliza <code>Bearer Tokens (JWT)</code> para validar as requisições. O processo de documentação desta seção está sendo finalizado pela equipe de engenharia.</p>

            <div class="skeleton-line" style="width: 80%;"></div>
            <div class="skeleton-line" style="width: 60%;"></div>
            <div class="skeleton-line" style="width: 70%;"></div>
        </section>

        <section class="content-section" style="opacity: 0.7;">
            <h2><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg> Endpoints Disponíveis</h2>
            <p>Os contratos das rotas estão sendo mapeados via Swagger/OpenAPI. Em breve, os schemas estarão disponíveis para consulta nesta seção.</p>

            <div style="margin-top: 20px;">
                <div class="skeleton-line" style="width: 40%; height: 20px; background: rgba(78, 161, 255, 0.05);"></div>
                <div class="skeleton-line" style="width: 100%;"></div>
                <div class="skeleton-line" style="width: 90%;"></div>
            </div>
        </section>
    </main>

    <footer style="text-align: center; margin-top: 60px; color: var(--text-muted); font-size: 0.8rem;">
        Dev Engine v1.0-beta • Última atualização: <?= date('d/m/Y') ?>
    </footer>
</div>

</body>
</html>