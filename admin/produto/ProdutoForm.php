<?php
// 1. Inicia a sessão antes de qualquer saída de texto ou HTML (Regra obrigatória do PHP)
session_start();

// 2. Proteção de segurança da página administrativa
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

// 3. Conexão direta com a classe de Banco de Dados do sistema
require_once __DIR__ . '/../../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

// ==========================================
// LÓGICA DE SALVAMENTO / PROCESSAMENTO (POST)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $preco = str_replace(',', '.', $_POST['preco'] ?? '0'); // Normaliza a vírgula flutuante
    $descricao = $_POST['descricao'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? ''; 
    $imagem_salva = $_POST['imagem_atual'] ?? '';

    // Upload seguro de Imagens de Ativos
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $pasta_destino = __DIR__ . '/../../site/assets/img/produtos/';
        
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0777, true);
        }

        $nome_imagem = time() . '_' . basename($_FILES['imagem']['name']); // Evita duplicidade de nome
        $caminho_completo = $pasta_destino . $nome_imagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_completo)) {
            // [Opcional] Apaga a foto antiga do servidor se uma nova for enviada (mantém o servidor limpo)
            if (!empty($imagem_salva) && file_exists($pasta_destino . $imagem_salva)) {
                unlink($pasta_destino . $imagem_salva);
            }
            $imagem_salva = $nome_imagem;
        }
    }

    if (empty($id)) {
        // Modo: Inserção de Novo Registro
        $stmt = $conn->prepare("INSERT INTO produto (nome, preco, descricao, imagem, categoria_id) VALUES (:nome, :preco, :descricao, :imagem, :categoria_id)");
        $stmt->execute([
            'nome' => $nome,
            'preco' => $preco,
            'descricao' => $descricao,
            'imagem' => $imagem_salva,
            'categoria_id' => $categoria_id
        ]);
    } else {
        // Modo: Edição de Registro Existente
        $stmt = $conn->prepare("UPDATE produto SET nome = :nome, preco = :preco, descricao = :descricao, imagem = :imagem, categoria_id = :categoria_id WHERE id = :id");
        $stmt->execute([
            'nome' => $nome,
            'preco' => $preco,
            'descricao' => $descricao,
            'imagem' => $imagem_salva,
            'categoria_id' => $categoria_id,
            'id' => $id
        ]);
    }

    header('Location: ProdutoList.php');
    exit;
}

// ==========================================
// LÓGICA DE CARREGAMENTO DE DADOS (GET)
// ==========================================
try {
    $stmt_cat = $conn->prepare("SELECT * FROM categoria ORDER BY nome ASC");
    $stmt_cat->execute();
    $categorias = $stmt_cat->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar categorias: " . $e->getMessage());
}

$id = '';
$nome = '';
$preco = '';
$descricao = '';
$categoria_id = '';
$imagem_atual = '';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM produto WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $produto = $stmt->fetch();

    if ($produto) {
        $nome = $produto['nome'];
        $preco = $produto['preco'];
        $descricao = $produto['descricao'];
        $categoria_id = $produto['categoria_id'];
        $imagem_atual = $produto['imagem'];
    }
}

// 4. Configura os caminhos relativos e invoca o Header Modularizado
$base_path = "../../"; 
include "../header-admin.php";
?>

<div class="container my-5" style="max-width: 750px;">
    <div class="mb-4">
        <span class="section-label mb-1">Gerenciamento de Ativos</span>
        <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
            <i class="bi bi-box-seam-fill me-2" style="color: var(--gold);"></i><?= $id ? 'Editar Produto' : 'Novo Produto'; ?>
        </h2>
    </div>

    <div class="glass-card p-4 shadow-lg border-0">
        <form action="ProdutoForm.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">
            <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($imagem_atual); ?>">

            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-white-50">Nome do Produto <span class="text-danger">*</span></label>
                <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="nome" value="<?= htmlspecialchars($nome); ?>" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-white-50">Categoria do Produto <span class="text-danger">*</span></label>
                <select class="form-select bg-transparent text-white border-secondary py-2" name="categoria_id" required style="color-scheme: dark;">
                    <option value="" class="bg-dark text-white">-- Selecione uma Categoria --</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $categoria_id ? 'selected' : ''; ?> class="bg-dark text-white">
                            <?= htmlspecialchars($cat['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-white-50">Preço (R$) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent text-white-50 border-secondary">R$</span>
                    <input class="form-control bg-transparent text-white border-secondary py-2" name="preco" value="<?= htmlspecialchars($preco); ?>" placeholder="Ex: 99.90" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-white-50">Descrição <span class="text-danger">*</span></label>
                <textarea class="form-control bg-transparent text-white border-secondary" name="descricao" rows="4" required><?= htmlspecialchars($descricao); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold mb-2 text-white-50">Imagem do Produto</label>
                <input type="file" class="form-control bg-transparent text-white border-secondary" name="imagem" accept="image/*">
                
                <?php if (!empty($imagem_atual)): ?>
                    <div class="mt-3 text-white-50" style="font-size: 0.85rem;">
                        Imagem atual vinculada: <br>
                        <img src="../../site/assets/img/produtos/<?= $imagem_atual; ?>" alt="Atual" class="rounded border border-secondary mt-1" style="max-height: 100px; object-fit: cover;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-2">
                <a href="ProdutoList.php" class="btn btn-outline-secondary text-uppercase px-4 py-2" style="font-size: 0.8rem; font-weight: 700; border-radius: 999px;">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-gold text-uppercase px-4 py-2 d-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 700;">
                    <i class="bi bi-check-circle-fill"></i> Salvar Produto
                </button>
            </div>
        </form>
    </div>
</div>

<?php 
// 5. Fecha as tags pendentes e inclui os scripts do Bootstrap
include "../footer-admin.php"; 
?>