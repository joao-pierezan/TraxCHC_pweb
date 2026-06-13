<?php
session_start();

// 1. Proteção: Garante que apenas o administrador logado pode apagar mensagens
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

// 2. Verifica se o ID da mensagem chegou certinho pela URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // 3. Conecta ao banco de dados
    require_once __DIR__ . '/../site/database/db.class.php';
    $db = new db();
    $conn = $db->connect();

    try {
        // 4. Dá a ordem para deletar a mensagem específica pelo ID
        $stmt = $conn->prepare("DELETE FROM mensagem WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        // Se der algum erro muito incomum no banco, ele mostra aqui
        die("Erro ao excluir a mensagem: " . $e->getMessage());
    }
}

// 5. Missão cumprida! Redireciona de volta para a página de mensagens
header('Location: mensagens.php');
exit;