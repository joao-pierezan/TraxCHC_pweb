<?php
session_start();

// Se o usuário já estiver logado, manda direto pro painel administrativo
if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração TraxCHC</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../style.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="glass-card p-4 mx-3" style="width: 100%; max-width: 410px;">
        <div class="text-center mb-2">
            <h3 class="fw-bold " style="letter-spacing: 1.5px; color: var(--gold);">TraxCHC</h3>
            
            <div class="my-3">
                <img src="../img/img-painel.jpg" alt="Logo TraxCHC" class="img-fluid rounded-1" style="max-height: 150px; object-fit: contain;">
            </div>

            <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase;">Acesso Administrativo</p>
        </div>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-danger py-2 text-center small rounded-3 border-0 mb-3" role="alert" style="background-color: rgba(220, 53, 69, 0.15); color: #ea868f;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($_GET['erro']); ?>
            </div>
        <?php endif; ?>

        <form action="autenticar.php" method="POST">
            <div class="mb-3">
                <label for="login" class="form-label small fw-semibold mb-1" style="color: var(--text-muted);">Usuário</label>
                <div class="input-group">
                    <span class="input-group-text border-0" style="background-color: rgba(255,255,255,0.03); border-right: 1px solid var(--border) !important;"><i class="bi bi-person text-white-50"></i></span>
                    <input type="text" class="form-control text-light border-0" id="login" name="usuario" required placeholder="Digite seu usuário" style="background-color: rgba(255,255,255,0.03); box-shadow: none;">
                </div>
            </div>
            
            <div class="mb-4">
                <label for="senha" class="form-label small fw-semibold mb-1" style="color: var(--text-muted);">Senha</label>
                <div class="input-group">
                    <span class="input-group-text border-0" style="background-color: rgba(255,255,255,0.03); border-right: 1px solid var(--border) !important;"><i class="bi bi-lock text-white-50"></i></span>
                    <input type="password" class="form-control text-light border-0" id="senha" name="senha" required placeholder="Digite sua senha" style="background-color: rgba(255,255,255,0.03); box-shadow: none;">
                </div>
            </div>

            <button type="submit" class="btn btn-gold w-100 mb-3 py-2.5 shadow-sm text-uppercase" style="font-size: 0.9rem; letter-spacing: 0.05em;">
                Entrar <i class="bi bi-box-arrow-in-right ms-1"></i>
            </button>
            
            <a href="../index.php" class="btn btn-transparente btn-sm w-100 py-2.5 d-flex align-items-center justify-content-center text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.05em; border-radius: 999px;">
                <i class="bi bi-arrow-left me-2"></i> Voltar para a Loja
            </a>
        </form>
    </div>

    <style>
        .form-control::placeholder { color: rgba(255,255,255,0.25); font-size: 0.9rem; }
        .form-control:focus { background-color: rgba(255,255,255,0.06) !important; color: #fff; }
        .input-group { border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
    </style>

</body>
</html>