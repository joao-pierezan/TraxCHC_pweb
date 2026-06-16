<?php
session_start();

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

$id = '';
$nome = '';
$descricao = '';
$status = 'Ativo';

// LÓGICA DE CARREGAMENTO (GET)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM categoria WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $categoria = $stmt->fetch();

    if ($categoria) {
        $nome = $categoria['nome'];
        $descricao = $categoria['descricao'] ?? '';
        $status = $categoria['status'] ?? 'Ativo';
    }
}

// LÓGICA DE SALVAMENTO (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $status = $_POST['status'] ?? 'Ativo';

    if (empty($id)) {
        // Inserir nova categoria
        $stmt = $conn->prepare("INSERT INTO categoria (nome, descricao, status) VALUES (:nome, :descricao, :status)");
        $stmt->execute([
            'nome' => $nome,
            'descricao' => $descricao,
            'status' => $status
        ]);
    } else {
        // Atualizar categoria existente
        $stmt = $conn->prepare("UPDATE categoria SET nome = :nome, descricao = :descricao, status = :status WHERE id = :id");
        $stmt->execute([
            'nome' => $nome,
            'descricao' => $descricao,
            'status' => $status,
            'id' => $id
        ]);
    }

    header('Location: CategoriaList.php');
    exit;
}

// Configura o caminho dinâmico antes de renderizar o cabeçalho modular
$base_path = "../../"; 
include "../header-admin.php";
?>

<div class="container my-5" style="max-width: 650px;">
    <div class="mb-4">
        <span class="section-label mb-1">Gerenciamento de Ativos</span>
        <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
            <i class="bi bi-folder-plus me-2" style="color: var(--gold);"></i><?= $id ? 'Editar Categoria' : 'Nova Categoria'; ?>
        </h2>
    </div>

    <div class="glass-card shadow-lg border-0 p-4">
        <form action="CategoriaForm.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">

            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-white-50">
                    Nome da Categoria <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent text-white-50 border-secondary"><i class="bi bi-tag"></i></span>
                    <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="nome" value="<?= htmlspecialchars($nome); ?>" placeholder="Ex: Relógios, Colares..." required autocomplete="off">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-white-50">
                    Descrição <span class="text-muted fw-normal">(Opcional)</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent text-white-50 border-secondary align-items-start pt-2"><i class="bi bi-card-text"></i></span>
                    <textarea class="form-control bg-transparent text-white border-secondary py-2" name="descricao" rows="3" placeholder="Pequeno texto descritivo..."><?= htmlspecialchars($descricao); ?></textarea>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold mb-2 text-white-50">
                    Status <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent text-white-50 border-secondary"><i class="bi bi-toggle-on"></i></span>
                    <select class="form-select bg-dark text-white border-secondary py-2" name="status" required style="background-color: rgba(0,0,0,0.5); color-scheme: dark;">
                        <option value="Ativo" <?= $status === 'Ativo' ? 'selected' : ''; ?>>Ativo (Exibir no site)</option>
                        <option value="Inativo" <?= $status === 'Inativo' ? 'selected' : ''; ?>>Inativo (Ocultar do site)</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-secondary border-opacity-25 pt-3">
                <a href="CategoriaList.php" class="btn btn-transparente text-uppercase px-4 py-2" style="font-size: 0.8rem; font-weight: 700; border-radius: 999px;">Cancelar</a>
                <button type="submit" class="btn btn-gold text-uppercase px-4 py-2 d-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 700;">
                    <i class="bi bi-check-circle-fill"></i> Salvar Registro
                </button>
            </div>
        </form>
    </div>
</div>

<?php 
// Fecha as tags abertas estruturalmente e injeta os scripts do Bootstrap
include "../footer-admin.php"; 
?>