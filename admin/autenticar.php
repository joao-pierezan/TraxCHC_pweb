<?php
session_start();
require_once __DIR__ . '/../site/database/db.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    try {
        $db = new db();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM usuario WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // --- TELA DE DIAGNÓSTICO (RAIO-X) ---
        echo "<div style='background:#111; color:#0f0; padding:20px; font-family:monospace; font-size:16px; border:2px solid #0f0; margin: 20px;'>";
        echo "<h2 style='color:#0f0;'>=== RAIO-X DO LOGIN ===</h2>";
        echo "<strong>1. Usuário digitado:</strong> '$login'<br>";
        echo "<strong>2. Senha digitada:</strong> '$senha'<br><br>";

        if ($usuario) {
            echo "<strong>3. STATUS DO BANCO:</strong> Usuário encontrado!<br>";
            echo "&nbsp;&nbsp;&nbsp;- ID no Banco: " . $usuario['id'] . "<br>";
            echo "&nbsp;&nbsp;&nbsp;- Hash gravado: " . $usuario['senha'] . "<br><br>";
            
            if (password_verify($senha, $usuario['senha'])) {
                echo "<strong style='color: yellow;'>4. RESULTADO FINAL:</strong> A senha está CORRETA! O login deveria funcionar perfeitamente.";
            } else {
                echo "<strong style='color: red;'>4. RESULTADO FINAL:</strong> A senha digitada NÃO BATE com a criptografia (hash) do banco!<br>";
                echo "<em>(O hash que o sistema exige é diferente do hash gravado lá no phpMyAdmin)</em>";
            }
        } else {
            echo "<strong style='color: red;'>3. RESULTADO FINAL:</strong> O usuário '$login' NÃO EXISTE na tabela do banco de dados!";
        }
        echo "</div>";
        exit;
        // --- FIM DA TELA DE DIAGNÓSTICO ---

    } catch (PDOException $e) {
        die("ERRO DE CONEXÃO: " . $e->getMessage());
    }
}
?>