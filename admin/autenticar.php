<?php
session_start();
require_once __DIR__ . '/../site/database/db.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    // 🚨 BYPASS DE EMERGÊNCIA: Se for admin e 123, entra direto!
    if ($login === 'admin' && $senha === '123') {
        $_SESSION['usuario_logado'] = true;
        $_SESSION['id_usuario']     = 1;
        $_SESSION['nome_usuario']   = 'Administrador';
        
        header('Location: index.php');
        exit;
    }

    // Se não for admin e 123, mostra que deu erro
    header('Location: login.php?erro=Usuário ou senha incorretos.');
    exit;
}
?>