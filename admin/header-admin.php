<body class="pb-5">

    <header class="site-header">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php" style="color: var(--gold); letter-spacing: 1px;">
                    <i class="bi bi-shield-lock-fill me-2"></i>Admin TraxCHC
                </a>
                <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="adminNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="categorias.php">Categorias</a></li>
                        <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="mensagens.php">Mensagens</a></li>
                        <li class="nav-item"><a class="nav-link" href="usuarios.php";>Usuários</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <span class="navbar-text small text-light d-none d-sm-inline">
                            Olá, <strong style="color: var(--gold);"><?= htmlspecialchars($_SESSION['nome_usuario'] ?? 'Admin'); ?></strong>
                        </span>
                        <a href="logout.php" class="btn btn-sm btn-outline-danger px-3 rounded-pill" style="font-weight: 600; font-size: 0.85rem;">
                            <i class="bi bi-box-arrow-right me-1"></i> Sair
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>