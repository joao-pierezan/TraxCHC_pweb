<?php
session_start();

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    require_once __DIR__ . '/../site/database/db.class.php';
    $db = new db();
    $conn = $db->connect();

    try {
        $stmt = $conn->prepare("DELETE FROM categoria WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        // [CUIDADO] O banco de dados vai barrar a exclusão se houver algum produto usando esta categoria!
        die("
            <div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>
                <h2 style='color: red;'>Ação Bloqueada!</h2>
                <p>Você não pode excluir esta categoria porque existem produtos vinculados a ela.</p>
                <p>Por favor, apague ou altere a categoria dos produtos primeiro.</p>
                <a href='categorias.php' style='padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;'>Voltar</a>
            </div>
        ");
    }
}

header('Location: categorias.php');
exit;