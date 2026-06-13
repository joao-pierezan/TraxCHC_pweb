<?php
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona para a tela de login com mensagem de sucesso
header('Location: login.php?erro=Sessão encerrada com sucesso.');
exit;
?>