<?php
/** @var string|null $message */
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #020617;
            --bg-glow: rgba(78, 161, 255, 0.15);

            --card-bg: rgba(15, 23, 42, 0.6);
            --card-border: rgba(255, 255, 255, 0.08);

            --primary-main: #4ea1ff;
            --primary-hover: #3b82f6;

            --error-main: #ef4444;
            --error-bg: rgba(239, 68, 68, 0.1);

            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: var(--bg-base);
            background-image:
                    radial-gradient(circle at 50% 0%, var(--bg-glow) 0%, transparent 50%),
                    radial-gradient(circle at 50% 100%, rgba(15, 23, 42, 1) 0%, var(--bg-base) 100%);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 440px;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- Link Voltar --- */
        .back-link {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 24px;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary-main);
            transform: translateX(-4px);
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 48px 32px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-main), transparent);
            opacity: 0.6;
        }

        .icon-wrapper {
            width: 72px;
            height: 72px;
            background: rgba(78, 161, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            border: 1px solid rgba(78, 161, 255, 0.2);
            box-shadow: 0 0 30px rgba(78, 161, 255, 0.15);
            animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards;
            opacity: 0;
            transform: scale(0.5);
        }

        .icon-wrapper svg {
            width: 32px;
            height: 32px;
            color: var(--primary-main);
        }

        .header-text {
            text-align: center;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.025em;
            color: var(--text-main);
        }

        p.message {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .alert-error {
            background: var(--error-bg);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        .alert-error svg {
            color: var(--error-main);
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            margin-top: 2px;
        }

        .alert-error p {
            color: #fca5a5;
            font-size: 0.9rem;
            font-weight: 500;
            line-height: 1.4;
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--card-border);
            color: var(--text-main);
            font-size: 1rem;
            transition: all 0.2s ease;
            outline: none;
        }

        input[type="password"],
        .password-wrapper input[type="text"] {
            padding-right: 48px;
        }

        input::placeholder {
            color: rgba(148, 163, 184, 0.4);
        }

        input:focus {
            border-color: var(--primary-main);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 4px rgba(78, 161, 255, 0.15);
        }

        .btn-reveal {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
            border-radius: 8px;
        }

        .btn-reveal:hover {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-reveal svg {
            width: 20px;
            height: 20px;
        }

        .icon-eye-closed {
            display: none;
        }

        .btn-reveal.show .icon-eye-open { display: none; }
        .btn-reveal.show .icon-eye-closed { display: block; }


        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            cursor: pointer;
            margin-top: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-main), var(--primary-hover));
            color: #ffffff;
            box-shadow: 0 4px 14px 0 rgba(78, 161, 255, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(78, 161, 255, 0.35);
            filter: brightness(1.1);
        }

        footer {
            margin-top: 32px;
            font-size: 0.875rem;
            color: var(--text-muted);
            opacity: 0.7;
            text-align: center;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
    </style>
</head>
<body>

<main class="container">

    <a href="/" class="back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
        Voltar para Home
    </a>

    <div class="login-card">

        <header class="header-text">
            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            <h1>Bem-vindo</h1>
            <p class="message">Insira suas credenciais para acessar o painel de administração.</p>
        </header>

        <?php if (isset($message) && !empty($message)): ?>
            <div class="alert-error" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p><?= htmlspecialchars($message) ?></p>
            </div>
        <?php endif; ?>

        <form action="/auth/login" method="POST">
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="admin@seudominio.com" required autocomplete="email">
            </div>

            <div class="input-group">
                <div class="label-row">
                    <label for="password">Senha</label>
                </div>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">

                    <button type="button" class="btn-reveal" id="togglePassword" aria-label="Mostrar senha">
                        <svg class="icon-eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg class="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

    </div>

    <footer>
        &copy; 2026 • Dev Engine Admin
    </footer>
</main>

<script>
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePasswordBtn.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        this.classList.toggle('show');
    });
</script>

</body>
</html>