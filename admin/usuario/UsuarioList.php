<?php
session_start();

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

$erro = '';
$sucesso = $_GET['sucesso'] ?? '';

// Lógica de Exclusão Segura
if (isset($_GET['excluir'])) {
    $id_excluir = (int)$_GET['excluir'];
    
    if ($id_excluir === (int)$_SESSION['id_usuario']) {
        $erro = "Ação negada! Você não pode excluir a sua própria conta em uso.";
    } else {
        try {
            $stmt_del = $conn->prepare("DELETE FROM usuario WHERE id = :id");
            $stmt_del->execute(['id' => $id_excluir]);
            
            header("Location: UsuarioList.php?sucesso=" . urlencode("Usuário removido com sucesso!"));
            exit;
        } catch (PDOException $e) {
            $erro = "Erro ao excluir usuário: " . $e->getMessage();
        }
    }
}

// REGRA OBRIGATÓRIA: Filtro de Busca Funcional
$busca = trim($_GET['busca'] ?? '');
try {
    if (!empty($busca)) {
        $stmt = $conn->prepare("SELECT id, nome, telefone, email, login FROM usuario WHERE nome LIKE :busca OR email LIKE :busca ORDER BY nome ASC");
        $stmt->execute(['busca' => "%$busca%"]);
    } else {
        $stmt = $conn->query("SELECT id, nome, telefone, email, login FROM usuario ORDER BY nome ASC");
    }
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar usuários: " . $e->getMessage());
}

$base_path = "../../"; 
include "../header-admin.php";
?>

<div class="container my-5">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <span class="section-label mb-1">Controle de Acessos</span>
            <h2 class="fw-bold text-white m-0" style="letter-spacing: -0.5px;">
                <i class="bi bi-people-fill me-2" style="color: var(--gold);"></i>Usuários Cadastrados
            </h2>
        </div>
        <div>
            <a href="UsuarioForm.php" class="btn btn-gold text-uppercase px-4 py-2.5 d-inline-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 700;">
                <i class="bi bi-person-plus-fill fs-6"></i> Novo Usuário
            </a>
        </div>
    </div>

    <div class="glass-card p-3 mb-4">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="busca" class="form-control bg-transparent text-white border-secondary" placeholder="Buscar por nome ou e-mail..." value="<?= htmlspecialchars($busca); ?>">
            <button class="btn btn-gold text-uppercase" type="submit" style="font-weight: 600;"><i class="bi bi-search"></i> Buscar</button>
            <?php if (!empty($busca)): ?>
                <a href="UsuarioList.php" class="btn btn-outline-secondary d-flex align-items-center"><i class="bi bi-x-circle"></i></a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger small mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $erro; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-20 text-success small mb-4">
            <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($sucesso); ?>
        </div>
    <?php endif; ?>

    <div class="glass-card p-0 shadow-lg border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle m-0" style="background: transparent;">
                <thead class="border-bottom border-secondary text-uppercase" style="font-size: 0.75rem; background: rgba(255,255,255,0.02);">
                    <tr>
                        <th class="ps-4 py-3" style="width: 80px; color: var(--gold);">ID</th>
                        <th class="py-3" style="color: var(--gold);">Nome</th>
                        <th class="py-3" style="color: var(--gold);">Telefone</th>
                        <th class="py-3" style="color: var(--gold);">E-mail</th>
                        <th class="py-3" style="color: var(--gold);">Login</th>
                        <th class="pe-4 py-3 text-center" style="width: 120px; color: var(--gold);">Ações</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (count($usuarios) > 0): ?>
                        <?php foreach ($usuarios as $usr): ?>
                            <tr class="border-bottom border-dark">
                                <td class="ps-4 text-white-50 small">#<?= $usr['id']; ?></td>
                                <td class="fw-medium text-white"><?= htmlspecialchars($usr['nome']); ?></td>
                                <td class="text-white-50 small"><?= htmlspecialchars($usr['telefone']); ?></td>
                                <td class="text-white-50 small"><?= htmlspecialchars($usr['email']); ?></td>
                                <td><span class="badge bg-secondary bg-opacity-25 text-light px-2 py-1.5 fw-normal" style="font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.1);"><?= htmlspecialchars($usr['login']); ?></span></td>
                                <td class="pe-4 text-center">
                                    <?php if ($usr['id'] === (int)$_SESSION['id_usuario']): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small px-2 py-1.5">
                                            <i class="bi bi-person-check-fill me-1"></i> Você
                                        </span>
                                    <?php else: ?>
                                        <a href="UsuarioList.php?excluir=<?= $usr['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger px-2.5 py-1"
                                           onclick="return confirm('Tem certeza que deseja remover o acesso deste administrador?');"
                                           title="Excluir Administrador">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-white-50 small">
                                <i class="bi bi-people display-6 d-block mb-2 text-secondary"></i>
                                Nenhum usuário encontrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../footer-admin.php"; ?>