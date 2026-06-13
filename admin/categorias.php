<?php
session_start();

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

try {
    $stmt = $conn->prepare("SELECT * FROM categoria ORDER BY id DESC");
    $stmt->execute();
    $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar categorias: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <?php include 'header-admin.php'; ?>

    <div class="container my-5" style="max-width: 1000px;">
        
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
            <div>
                <span class="section-label mb-1">Configurações de Vitrine</span>
                <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
                    <i class="bi bi-tags-fill me-2" style="color: var(--gold);"></i>Categorias
                </h2>
            </div>
            
            <a href="categoria-formulario.php" class="btn btn-gold text-uppercase px-4 py-2.5 d-flex align-items-center gap-2" style="font-size: 0.8rem; letter-spacing: 0.05em;">
                <i class="bi bi-plus-circle-fill"></i> Nova Categoria
            </a>
        </div>

        <div class="glass-card p-0 overflow-hidden shadow-lg border-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr class="border-bottom border-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.08em;">
                            <th width="80" class="ps-4 py-3" style="color: var(--gold);">ID</th>
                            <th class="py-3" style="color: var(--gold);">Nome</th>
                            <th class="py-3" style="color: var(--gold);">Descrição</th>
                            <th width="120" class="text-center py-3" style="color: var(--gold);">Status</th>
                            <th width="140" class="text-center pe-4 py-3" style="color: var(--gold);">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($categorias) > 0): ?>
                            <?php foreach ($categorias as $c): ?>
                                <tr class="border-bottom border-dark">
                                    <td class="ps-4 text-white-50">#<?= $c['id']; ?></td>
                                    <td class="fw-semibold text-white"><?= htmlspecialchars($c['nome']); ?></td>
                                    
                                    <td class="text-white-50 small" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= htmlspecialchars($c['descricao'] ?? '-'); ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if (($c['status'] ?? 'Ativo') === 'Inativo'): ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 fw-normal px-2 py-1">Inativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 fw-normal px-2 py-1">Ativo</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center pe-4">
                                        <a href="categoria-formulario.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-outline-warning me-1 px-2.5 py-1" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="categoria-excluir.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-outline-danger px-2.5 py-1" title="Excluir" onclick="return confirm('Atenção: Ao deletar uma categoria, você pode afetar produtos vinculados a ela. Tem certeza?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-white-50 py-5">
                                    <i class="bi bi-folder-x display-6 mb-2 d-block text-secondary"></i>
                                    Nenhuma categoria cadastrada no momento.
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