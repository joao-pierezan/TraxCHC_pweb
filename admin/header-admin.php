<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin TraxCHC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_path; ?>style.css">
    
    <style>
        /* Estilos adicionais para harmonizar as tabelas e inputs com seu tema escuro */
        .admin-box {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(14px);
        }
        .custom-table {
            color: var(--text-main) !important;
        }
        .custom-table thead th {
            background-color: rgba(212, 175, 55, 0.12) !important;
            color: var(--gold) !important;
            border-bottom: 2px solid var(--border) !important;
            font-weight: 600;
        }
        .custom-table tbody td {
            background: transparent !important;
            color: var(--text-muted) !important;
            border-bottom: 1px solid var(--border) !important;
            vertical-align: middle;
        }
        .form-control-custom {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
            border-radius: 8px;
        }
        .form-control-custom:focus {
            border-color: var(--gold) !important;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
        }
    </style>
</head>
<body>

<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_path; ?>admin/index.php">
                <span style="color: var(--gold); font-weight: 700; font-size: 1.4rem; letter-spacing: 1px;">
                    <i class="fa-solid fa-shield-halved me-2"></i>Admin TraxCHC
                </span>
            </a>
            <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>admin/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>admin/categoria/CategoriaList.php">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>admin/produto/ProdutoList.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>admin/mensagem/MensagemList.php">Mensagens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_path; ?>admin/usuario/UsuarioList.php">Usuários</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small">Olá, <strong style="color: var(--gold);">Administrador</strong></span>
                    <a href="<?php echo $base_path; ?>admin/logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="fa-solid fa-right-from-bracket me-1"></i>Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="container my-5">