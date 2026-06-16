<?php
session_start();

// Proteção de segurança do painel
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Sobe duas pastas para achar o arquivo de conexão do banco
    require_once __DIR__ . '/../../site/database/db.class.php';
    $db = new db();
    $conn = $db->connect();

    try {
        $stmt = $conn->prepare("DELETE FROM categoria WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        // Bloqueia a exclusão se houver produtos usando esta categoria (Estilizado com as cores da TraxCHC)
        die("
            <div style='font-family: \"Montserrat\", sans-serif; text-align: center; padding: 60px 20px; background: #050608; color: #f4f6f8; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center;'>
                <div style='background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 28px; padding: 40px; max-width: 550px; backdrop-filter: blur(14px); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);'>
                    <i class='bi bi-exclamation-octagon-fill' style='font-size: 3.5rem; color: #d4af37; margin-bottom: 20px; display: inline-block;'></i>
                    <h2 style='color: #f4f6f8; font-weight: 700; margin-bottom: 15px;'>Ação Bloqueada!</h2>
                    <p style='color: #b8c0cc; line-height: 1.8; font-size: 1rem; margin-bottom: 25px;'>
                        Você não pode excluir esta categoria porque existem produtos premium vinculados a ela na vitrine.
                    </p>
                    <p style='color: #b8c0cc; font-size: 0.9rem; margin-bottom: 30px; opacity: 0.8;'>
                        Por favor, remova ou altere a categoria dos produtos associados antes de prosseguir.
                    </p>
                    <a href='CategoriaList.php' style='display: inline-block; padding: 12px 30px; background: #d4af37; color: #111; font-weight: 700; text-decoration: none; border-radius: 999px; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em; transition: background 0.3s;'>
                        Voltar para a Listagem
                    </a>
                </div>
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css'>
                <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap' rel='stylesheet'>
            </div>
        ");
    }
}

// Redireciona de volta para a listagem em caso de sucesso
header('Location: CategoriaList.php');
exit;
?>