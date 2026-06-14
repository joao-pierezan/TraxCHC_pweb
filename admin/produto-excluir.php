<?php
session_start();

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
        $stmt_busca = $conn->prepare("SELECT imagem FROM produto WHERE id = :id"); //envia o comando pro banco achar o produto
        $stmt_busca->execute(['id' => $id]); //envia o comando pro banco achar o produto
        $produto = $stmt_busca->fetch();

        if ($produto && !empty($produto['imagem'])) {
            $caminho_foto = __DIR__ . '/../site/assets/img/produtos/' . $produto['imagem'];
            if (file_exists($caminho_foto)) {
                unlink($caminho_foto);
            }
        }

        // deleta o produto com o indice especifico
        $stmt_deleta = $conn->prepare("DELETE FROM produto WHERE id = :id");
        $stmt_deleta->execute(['id' => $id]);

    } catch (PDOException $e) {
        die("Erro ao excluir o produto: " . $e->getMessage());
    }
}

// Volta para a listagem
header('Location: produtos.php');
exit;