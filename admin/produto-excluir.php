<?php
session_start();

// 1. Proteção de acesso: só admin logado entra aqui
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

// 2. Verifica se o ID do produto chegou pela URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    require_once __DIR__ . '/../site/database/db.class.php';
    $db = new db();
    $conn = $db->connect();

    try {
        // [DICA DE OURO] Antes de apagar do banco, vamos descobrir se o produto tinha foto
        $stmt_busca = $conn->prepare("SELECT imagem FROM produto WHERE id = :id");
        $stmt_busca->execute(['id' => $id]);
        $produto = $stmt_busca->fetch();

        if ($produto && !empty($produto['imagem'])) {
            $caminho_foto = __DIR__ . '/../site/assets/img/produtos/' . $produto['imagem'];
            
            // Se o arquivo da foto realmente existir na pasta do computador, nós apagamos ele (unlink)
            // Isso evita que seu servidor fique cheio de fotos "órfãs" de produtos que já foram deletados
            if (file_exists($caminho_foto)) {
                unlink($caminho_foto);
            }
        }

        // 3. Agora sim, deleta o produto do banco de dados de vez
        $stmt_deleta = $conn->prepare("DELETE FROM produto WHERE id = :id");
        $stmt_deleta->execute(['id' => $id]);

    } catch (PDOException $e) {
        die("Erro ao excluir o produto: " . $e->getMessage());
    }
}

// 4. Redireciona de volta para a listagem (que agora não terá mais o produto deletado)
header('Location: produtos.php');
exit;