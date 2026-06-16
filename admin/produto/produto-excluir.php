<?php
session_start();

// Garante o bloqueio de acessos maliciosos sem login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    require_once __DIR__ . '/../../site/database/db.class.php';
    $db = new db();
    $conn = $db->connect();

    try {
        // Busca o produto no banco primeiro para saber se existe uma imagem atrelada a ele
        $stmt_busca = $conn->prepare("SELECT imagem FROM produto WHERE id = :id");
        $stmt_busca->execute(['id' => $id]);
        $produto = $stmt_busca->fetch();

        // Se houver uma foto salva na pasta de ativos, apaga o arquivo físico do servidor
        if ($produto && !empty($produto['imagem'])) {
            $caminho_foto = __DIR__ . '/../../site/assets/img/produtos/' . $produto['imagem'];
            if (file_exists($caminho_foto)) {
                unlink($caminho_foto); // Limpeza de disco do servidor
            }
        }

        // Remove o registro definitivo da tabela
        $stmt_deleta = $conn->prepare("DELETE FROM produto WHERE id = :id");
        $stmt_deleta->execute(['id' => $id]);

    } catch (PDOException $e) {
        die("Erro crítico ao excluir o produto: " . $e->getMessage());
    }
}

// Redireciona de forma silenciosa e instantânea de volta para o painel atualizado
header('Location: ProdutoList.php');
exit;
?>