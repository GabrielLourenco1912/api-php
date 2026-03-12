<?php
/** @var string|null $apiUrl */
$apiUrl = "https://api.seudominio.com/v1";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Gateway | Em Desenvolvimento</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #020617;
            --bg-glow: rgba(78, 161, 255, 0.12);
            --card-bg: rgba(15, 23, 42, 0.6);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary-main: #4ea1ff;
            --primary-hover: #3b82f6;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --code-bg: rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background-color: var(--bg-base);
            background-image:
                    radial-gradient(circle at 50% 0%, var(--bg-glow) 0%, transparent 50%),
                    radial-gradient(circle at 0% 100%, rgba(78, 161, 255, 0.05) 0%, transparent 40%);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 520px;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .api-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 28px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* Badge de Status */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(78, 161, 255, 0.1);
            border: 1px solid rgba(78, 161, 255, 0.2);
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary-main);
            text-transform: uppercase;
            margin-bottom: 24px;
            letter-spacing: 0.05em;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--primary-main);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary-main);
            animation: pulse 2s infinite;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 12px;
            background: linear-gradient(to bottom, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .description {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        /* Endpoint Display */
        .endpoint-container {
            background: var(--code-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        code {
            font-family: 'Fira Code', monospace;
            font-size: 0.9rem;
            color: var(--primary-main);
            word-break: break-all;
        }

        .btn-copy {
            background: rgba(255, 255, 255, 0.05);
            border: none;
            color: var(--text-muted);
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-copy:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .btn {
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary-main);
            color: #020617;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 161, 255, 0.3);
            background: #fff;
        }

        footer {
            margin-top: 32px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (min-width: 480px) {
            .actions { grid-template-columns: 1fr 1fr; }
        }
        /* Estilização do Toast Customizado */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px); /* Começa escondido embaixo */
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--primary-main);
            color: var(--text-main);
            padding: 12px 24px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            z-index: 9999;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast svg {
            color: var(--primary-main);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="api-card">
        <div class="status-badge">
            <span class="status-dot"></span>
            Ambiente de Desenvolvimento
        </div>

        <h1>API Gateway</h1>
        <p class="description">
            Você acessou o domínio base da nossa interface de programação.
            O serviço está ativo, mas as rotas exigem autenticação.
        </p>

        <div class="endpoint-container">
            <code><?= htmlspecialchars($apiUrl) ?></code>
            <button class="btn-copy" onclick="copyUrl()" title="Copiar URL">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
            </button>
        </div>

        <div class="actions">
            <a href="/docs" class="btn btn-primary">
                Ver Documentação
            </a>
            <a href="https://github.com/seu-repo" class="btn" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--card-border);">
                GitHub
            </a>
        </div>
    </div>

    <footer>
        &copy; <?= date('Y') ?> • Dev Engine v1.0.4-beta
    </footer>
</div>

<script>
    function copyUrl() {
        const url = '<?= $apiUrl ?>';

        navigator.clipboard.writeText(url).then(() => {
            const toast = document.getElementById('toast');

            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }).catch(err => {
            console.error('Erro ao copiar: ', err);
        });
    }
</script>

<div id="toast" class="toast">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"></path></svg>
    URL copiada com sucesso!
</div>

</body>
</html>