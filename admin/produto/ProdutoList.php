<?php
// 1. Configura a variavel de caminho relativo antes de qualquer include
$base_path = "../../"; 

// 2. Inicia a sessao para validacao de seguranca
session_start();

// 3. Protecao da pagina
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

// 4. Conexao com o banco de dados
require_once __DIR__ . '/../../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

$busca = $_GET['busca'] ?? '';

try {
    // Filtro de busca obrigatorio da atividade usando Prepared Statements
    if (!empty($busca)) {
        $stmt = $conn->prepare("SELECT * FROM produto WHERE nome LIKE :busca ORDER BY id DESC");
        $stmt->execute([':busca' => "%$busca%"]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM produto ORDER BY id DESC");
        $stmt->execute();
    }
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}

// 5. Inclui o cabeçalho modular que contem o <!DOCTYPE html>, <head> e a navbar
include "../header-admin.php";
?>

<div class="row mb-4 align-items-center">
    <div class="col-sm-6">
        <span class="section-label">Configurações de Vitrine</span>
        <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
            <i class="bi bi-box-seam-fill me-2" style="color: var(--gold);"></i>Produtos
        </h2>
    </div>
    <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
        <a href="ProdutoForm.php" class="btn btn-gold text-uppercase px-4" style="font-size: 0.8rem; letter-spacing: 0.05em;">
            <i class="bi bi-plus-circle-fill me-2"></i> Novo Produto
        </a>
    </div>
</div>

<div class="glass-card p-3 mb-4">
    <form action="ProdutoList.php" method="GET" class="d-flex">
        <input type="text" name="busca" class="form-control bg-transparent text-white border-secondary me-2" placeholder="Buscar por nome do produto..." value="<?= htmlspecialchars($busca) ?>">
        <button type="submit" class="btn btn-gold text-uppercase" style="font-weight: 600;">
            <i class="bi bi-search"></i> Buscar
        </button>
        <?php if(!empty($busca)): ?>
            <a href="ProdutoList.php" class="btn btn-outline-secondary ms-2 d-flex align-items-center">Limpar</a>
        <?php endif; ?>
    </form>
</div>

<div class="glass-card p-0 overflow-hidden shadow-lg border-0">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle" style="background: transparent;">
            <thead>
                <tr class="border-bottom border-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.08em; background: rgba(255,255,255,0.02);">
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
                                    <img src="../../site/assets/img/produtos/<?= $p['imagem']; ?>" alt="Foto" class="rounded border border-secondary" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-dark text-white-50 text-center rounded border border-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 9px;">Sem foto</div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold text-white"><?= htmlspecialchars($p['nome']); ?></td>
                            <td class="fw-bold" style="color: var(--gold);">R$ <?= number_format($p['preco'], 2, ',', '.'); ?></td>
                            <td class="text-white-50 text-truncate" style="max-width: 250px; font-size: 0.9rem;"><?= htmlspecialchars($p['descricao']); ?></td>
                            <td class="text-center pe-4">
                                <a href="ProdutoForm.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-warning me-1 px-2.5 py-1" title="Editar">
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
                            Nenhum produto encontrado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
// 6. Inclui o rodape comum que fecha as tags HTML abertas pelo header
include "../footer-admin.php"; 
?>