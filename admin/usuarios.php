<?php
session_start();

// 1. Proteção: Se não estiver logado, expulsa para o login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

// Conexão com o Banco de Dados
require_once __DIR__ . '/../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

$erro = '';
$sucesso = $_GET['sucesso'] ?? '';

// 2. Lógica para Excluir Usuário
if (isset($_GET['excluir'])) {
    $id_excluir = (int)$_GET['excluir'];
    
    // REGRA DE SEGURANÇA: Não deixa o admin se auto-excluir
    if ($id_excluir === (int)$_SESSION['id_usuario']) {
        $erro = "Ação negada! Você não pode excluir a sua própria conta enquanto estiver logado.";
    } else {
        try {
            $stmt_del = $conn->prepare("DELETE FROM usuario WHERE id = :id");
            $stmt_del->execute(['id' => $id_excluir]);
            
            // Recarrega a página limpando o GET e exibindo mensagem limpa
            header("Location: usuarios.php?sucesso=" . urlencode("Usuário administrador removido com sucesso!"));
            exit;
        } catch (PDOException $e) {
            $erro = "Erro ao excluir usuário: " . $e->getMessage();
        }
    }
}

// 3. Busca todos os usuários do banco (Apenas os campos necessários)
try {
    $stmt = $conn->query("SELECT id, nome, telefone, email, login FROM usuario ORDER BY nome ASC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar usuários: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../style.css">
</head>
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
                        <li class="nav-item"><a class="nav-link active fw-semibold" href="usuarios.php" style="color: var(--gold);">Usuários</a></li>
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

    <div class="container my-5">
        
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div>
                <span class="section-label mb-1">Controle de Acessos</span>
                <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
                    <i class="bi bi-people-fill me-2" style="color: var(--gold);"></i>Usuários Cadastrados
                </h2>
            </div>
            <div>
                <a href="admin-cadastro.php" class="btn btn-gold text-uppercase px-4 py-2 d-inline-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 700;">
                    <i class="bi bi-person-plus-fill fs-6"></i> Novo Usuário
                </a>
            </div>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger small mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $erro; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-20 text-success small mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($sucesso); ?>
            </div>
        <?php endif; ?>

        <div class="glass-card p-0 shadow-lg border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle m-0" style="background: transparent;">
                    <thead class="table-light text-uppercase small" style="--bs-table-bg: rgba(255,255,255,0.04); --bs-table-color: var(--gold); font-weight: 700; letter-spacing: 0.5px;">
                        <tr>
                            <th class="ps-4 py-3" style="width: 80px;">ID</th>
                            <th class="py-3">Nome</th>
                            <th class="py-3">Telefone</th>
                            <th class="py-3">E-mail</th>
                            <th class="py-3">Login</th>
                            <th class="pe-4 py-3 text-end" style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (count($usuarios) > 0): ?>
                            <?php foreach ($usuarios as $usr): ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td class="ps-4 text-white-50 fw-mono small">#<?= $usr['id']; ?></td>
                                    <td class="fw-medium text-white"><?= htmlspecialchars($usr['nome']); ?></td>
                                    <td class="text-white-50"><?= htmlspecialchars($usr['telefone']); ?></td>
                                    <td class="text-white-50"><?= htmlspecialchars($usr['email']); ?></td>
                                    <td><span class="badge bg-secondary bg-opacity-25 text-light px-2 py-1.5 fw-normal" style="font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.1);"><?= htmlspecialchars($usr['login']); ?></span></td>
                                    <td class="pe-4 text-end">
                                        <?php if ($usr['id'] === (int)$_SESSION['id_usuario']): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small px-2 py-1.5">
                                                <i class="bi bi-person-check-fill me-1"></i> Você
                                            </span>
                                        <?php else: ?>
                                            <a href="usuarios.php?excluir=<?= $usr['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-circle p-2 d-inline-flex align-items-center justify-content-center"
                                               onclick="return confirm('Tem certeza absoluta que deseja remover o acesso deste usuário administrador?');"
                                               title="Excluir Usuário"
                                               style="width: 32px; height: 32px;">
                                                <i class="bi bi-trash3-fill" style="font-size: 0.85rem;"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted small">
                                    <i class="bi bi-people text-white-50 fs-2 d-block mb-2"></i>
                                    Nenhum usuário cadastrado no sistema.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>