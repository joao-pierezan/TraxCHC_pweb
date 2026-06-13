<?php
session_start();

// 1. Proteção: Se não estiver logado, expulsa para o login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

// 2. Conexão com o Banco de Dados
require_once __DIR__ . '/../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

try {
    // 3. Busca todos os produtos do banco
    $stmt = $conn->prepare("SELECT * FROM produto ORDER BY id DESC");
    $stmt->execute();
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include 'header-admin.php'; ?>

    <div class="container my-5">
        
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
            <div>
                <span class="section-label mb-1">Configurações de Vitrine</span>
                <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
                    <i class="bi bi-box-seam-fill me-2" style="color: var(--gold);"></i>Produtos
                </h2>
            </div>
            
            <a href="produto-formulario.php" class="btn btn-gold text-uppercase px-4 py-2.5 d-flex align-items-center gap-2" style="font-size: 0.8rem; letter-spacing: 0.05em;">
                <i class="bi bi-plus-circle-fill"></i> Novo Produto
            </a>
        </div>

        <div class="glass-card p-0 overflow-hidden shadow-lg border-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr class="border-bottom border-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.08em;">
                            <th width="90" class="ps-4 py-3" style="color: var(--gold);">ID</th>
                            <th width="100" class="py-3" style="color: var(--gold);">Foto</th>
                            <th class="py-3" style="color: var(--gold);">Nome</th>
                            <th class="py-3" style="color: var(--gold);">Preço</th>
                            <th class="py-3" style="color: var(--gold);">Descrição</th>
                            <th width="160" class="text-center pe-4 py-3" style="color: var(--gold);">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($produtos) > 0): ?>
                            <?php foreach ($produtos as $p): ?>
                                <tr class="border-bottom border-dark">
                                    <td class="ps-4 text-white-50">#<?= $p['id']; ?></td>
                                    <td>
                                        <?php if (!empty($p['imagem'])): ?>
                                            <img src="../site/assets/img/produtos/<?= $p['imagem']; ?>" alt="Foto" class="rounded border border-secondary" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-dark text-white-50 text-center rounded border border-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 9px;">Sem foto</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-semibold text-white"><?= htmlspecialchars($p['nome']); ?></td>
                                    <td class="fw-bold" style="color: var(--gold);">R$ <?= number_format($p['preco'], 2, ',', '.'); ?></td>
                                    <td class="text-white-50 text-truncate" style="max-width: 250px; font-size: 0.9rem;"><?= htmlspecialchars($p['descricao']); ?></td>
                                    <td class="text-center pe-4">
                                        <a href="produto-formulario.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-warning me-1 px-2.5 py-1" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="produto-excluir.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-danger px-2.5 py-1" title="Excluir" onclick="return confirm('Tem certeza que deseja apagar o produto: <?= htmlspecialchars($p['nome']); ?>?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-white-50 py-5">
                                    <i class="bi bi-box-open display-6 mb-2 d-block text-secondary"></i>
                                    Nenhum produto cadastrado no momento.
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