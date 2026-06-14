<?php
session_start();

// Proteção do painel
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

// Inicializa as variáveis vazias (para o caso de ser um Novo Produto)
$id = $_GET['id'] ?? '';
$produto = [
    'nome' => '',
    'preco' => '',
    'descricao' => '',
    'imagem' => ''
];
$titulo_pagina = "Novo Produto";

// Se tiver um ID na URL, é modo de Edição. Busca os dados no banco.
if (!empty($id)) {
    $titulo_pagina = "Editar Produto";
    try {
        $stmt = $conn->prepare("SELECT * FROM produto WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            $produto = $resultado;
        }
    } catch (PDOException $e) {
        die("Erro ao buscar produto: " . $e->getMessage());
    }
}

// Lógica de Salvamento (Ajuste caso vocês usem um arquivo separado para salvar)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $preco = str_replace(',', '.', $_POST['preco']); // Garante que o decimal vá certo pro banco
    $descricao = $_POST['descricao'];
    $id_post = $_POST['id'];

    // O código de upload da imagem e o INSERT/UPDATE no banco vão aqui
    // ...
    
    // Após salvar, redireciona para a lista
    // header('Location: ProdutoList.php');
    // exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo_pagina ?> - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="pb-5">
    
    <?php include 'header-admin.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="d-flex align-items-center mb-4 gap-3">
                    <a href="ProdutoList.php" class="btn btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Voltar">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
                        <?= $titulo_pagina ?>
                    </h2>
                </div>

                <div class="glass-card p-4 shadow-lg border-0 rounded-4" style="background-color: #1a1d20;">
                    
                    <!-- Formulário de Produto com REQUIRED adicionado -->
                    <form action="ProdutoForm.php" method="POST" enctype="multipart/form-data">
                        
                        <!-- Campo oculto para enviar o ID na hora de editar -->
                        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                        <div class="mb-3">
                            <label for="nome" class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Nome do Produto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="preco" class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Preço (R$) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control bg-dark text-white border-secondary" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Descrição <span class="text-danger">*</span></label>
                            <textarea class="form-control bg-dark text-white border-secondary" id="descricao" name="descricao" rows="4" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="imagem" class="form-label text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px;">Imagem do Produto</label>
                            <input type="file" class="form-control bg-dark text-white border-secondary" id="imagem" name="imagem" accept="image/*">
                            <?php if(!empty($produto['imagem'])): ?>
                                <div class="mt-2 text-white-50 small">
                                    Imagem atual: <?= htmlspecialchars($produto['imagem']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr class="border-secondary mb-4">

                        <div class="d-flex justify-content-end gap-2">
                            <!-- Link de Cancelar atualizado para o nome correto -->
                            <a href="ProdutoList.php" class="btn btn-outline-secondary px-4">Cancelar</a>
                            <button type="submit" class="btn btn-gold fw-bold px-4 text-uppercase">
                                <i class="bi bi-save2-fill me-2"></i>Salvar Produto
                            </button>
                        </div>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>