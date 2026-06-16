<?php
session_start();

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

// Captura o termo de busca se o usuário preencheu o campo
$busca = $_GET['busca'] ?? '';

try {
    // Lógica de filtro obrigatória para a listagem (Regra do Professor)
    if (!empty($busca)) {
        $stmt = $conn->prepare("SELECT * FROM categoria WHERE nome LIKE :busca ORDER BY id DESC");
        $stmt->execute(['busca' => "%$busca%"]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM categoria ORDER BY id DESC");
        $stmt->execute();
    }
    $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar categorias: " . $e->getMessage());
}

// Define o recuo para localizar arquivos da raiz de estilos
$base_path = "../../"; 
include "../header-admin.php";
?>

<div class="container my-5" style="max-width: 1000px;">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <span class="section-label mb-1">Configurações de Vitrine</span>
            <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
                <i class="bi bi-tags-fill me-2" style="color: var(--gold);"></i>Categorias
            </h2>
        </div>
        
        <a href="CategoriaForm.php" class="btn btn-gold text-uppercase px-4 py-2.5 d-flex align-items-center gap-2" style="font-size: 0.8rem;">
            <i class="bi bi-plus-circle-fill"></i> Nova Categoria
        </a>
    </div>

    <div class="glass-card p-3 mb-4">
        <form action="CategoriaList.php" method="GET" class="d-flex gap-2">
            <input type="text" name="busca" class="form-control bg-transparent text-white border-secondary" placeholder="Pesquisar categoria por nome..." value="<?= htmlspecialchars($busca); ?>">
            <button type="submit" class="btn btn-gold text-uppercase" style="font-weight: 600;"><i class="bi bi-search"></i> Buscar</button>
            <?php if (!empty($busca)): ?>
                <a href="CategoriaList.php" class="btn btn-outline-secondary d-flex align-items-center" title="Limpar Busca"><i class="bi bi-x-circle"></i></a>
            <?php endif; ?>
        </form>
    </div>

    <div class="glass-card p-0 overflow-hidden shadow-lg border-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle" style="background: transparent;">
                <thead>
                    <tr class="border-bottom border-secondary text-uppercase" style="font-size: 0.75rem; background: rgba(255,255,255,0.02);">
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
                                    <a href="CategoriaForm.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-outline-warning me-1 px-2.5 py-1" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="categoria-excluir.php?id=<?= $c['id']; ?>" class="btn btn-sm btn-outline-danger px-2.5 py-1" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-white-50 py-5">
                                <i class="bi bi-folder-x display-6 mb-2 d-block text-secondary"></i>
                                Nenhuma categoria encontrada.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
include "../footer-admin.php"; 
?>