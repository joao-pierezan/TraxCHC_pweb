<?php
session_start();

// Proteção de acesso
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

// 1. BUSCA AS CATEGORIAS PARA EXIBIR NO DROPDOWN DO FORMULÁRIO
try {
    $stmt_cat = $conn->prepare("SELECT * FROM categoria ORDER BY id ASC");
    $stmt_cat->execute();
    $categorias = $stmt_cat->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar categorias: " . $e->getMessage());
}

// variaveis em branco pra um novo cadastro
$id = '';
$nome = '';
$preco = '';
$descricao = '';
$categoria_id = '';
$imagem_atual = '';

//se receber um id pela URL significa que temq editar um produto existente
if (isset($_GET['id']) && !empty($_GET['id'])) { //verifica se há um id na url para buscar as informações desse item
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM produto WHERE id = :id"); //busca os dados no banco
    $stmt->execute(['id' => $id]);
    $produto = $stmt->fetch();

    if ($produto) { //preenche as variaveis com o produto salvo
        $nome = $produto['nome'];
        $preco = $produto['preco'];
        $descricao = $produto['descricao'];
        $categoria_id = $produto['categoria_id'];
        $imagem_atual = $produto['imagem'];
    }
}

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $preco = str_replace(',', '.', $_POST['preco'] ?? '0'); 
    $descricao = $_POST['descricao'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? ''; 
    $imagem_salva = $_POST['imagem_atual'] ?? '';

    // LÓGICA DE UPLOAD DA IMAGEM
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $pasta_destino = __DIR__ . '/../site/assets/img/produtos/';
        
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0777, true);
        }

        $nome_imagem = time() . '_' . basename($_FILES['imagem']['name']);
        $caminho_completo = $pasta_destino . $nome_imagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_completo)) {
            $imagem_salva = $nome_imagem;
        }
    }

    //salva as informações no banco de dados e cria um novo id
    if (empty($id)) {
        // se o id estiver vazio significa que um produto novo tem que ser cadastrado
        $stmt = $conn->prepare("INSERT INTO produto (nome, preco, descricao, imagem, categoria_id) VALUES (:nome, :preco, :descricao, :imagem, :categoria_id)");
        $stmt->execute([
            'nome' => $nome,
            'preco' => $preco,
            'descricao' => $descricao,
            'imagem' => $imagem_salva,
            'categoria_id' => $categoria_id
        ]);
    } else {
        // Se o Id é existente significa que o produto em especifico deve ser editado
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

    header('Location: produtos.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Editar' : 'Novo'; ?> Produto - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../style.css">
</head>
<body class="pb-5">

    <?php include 'header-admin.php'; ?>

    <div class="container my-5" style="max-width: 750px;">
        
        <div class="mb-4">
            <span class="section-label mb-1">Gerenciamento de Ativos</span>
            <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
                <i class="bi bi-box-seam-fill me-2" style="color: var(--gold);"></i><?= $id ? 'Editar Produto' : 'Novo Produto'; ?>
            </h2>
        </div>

        <div class="glass-card p-4 shadow-lg border-0">
            
            <form action="produto-formulario.php" method="POST" enctype="multipart/form-data">
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
                                <?= htmlspecialchars($cat['id'] . ' - ' . ($cat['nome'] ?? $cat['descricao'] ?? 'Categoria')); ?>
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
                    <label class="form-label small fw-semibold mb-2 text-white-50">Descrição</label>
                    <textarea class="form-control bg-transparent text-white border-secondary" name="descricao" rows="4"><?= htmlspecialchars($descricao); ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold mb-2 text-white-50">Imagem do Produto</label>
                    <input type="file" class="form-control bg-transparent text-white border-secondary" name="imagem" accept="image/*">
                    
                    <?php if (!empty($imagem_atual)): ?>
                        <div class="mt-3 text-white-50" style="font-size: 0.85rem;">
                            Imagem atual vinculada: <br>
                            <img src="../site/assets/img/produtos/<?= $imagem_atual; ?>" alt="Atual" class="rounded border border-secondary mt-1" style="max-height: 100px; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2">
                    <a href="produtos.php" class="btn btn-transparente text-uppercase px-4 py-2" style="font-size: 0.8rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-gold text-uppercase px-4 py-2 d-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 700; letter-spacing: 0.05em;">
                        <i class="bi bi-check-circle-fill"></i> Salvar Produto
                    </button>
                </div>
            </form>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>