<?php
session_start();
// Como db.class.php está na raiz (..), voltamos uma pasta para chamá-lo
require_once __DIR__ . '/../site/database/db.class.php';

// Verifica se os dados foram enviados pelo formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($login) && !empty($senha)) {
        try {
            // Instancia a classe de conexão PDO
            $db = new db();
            $conn = $db->connect();

            // Prepara a consulta buscando pelo login
            $stmt = $conn->prepare("SELECT * FROM usuario WHERE login = :login");
            $stmt->execute([':login' => $login]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // --- INÍCIO DA CORREÇÃO AUTOMÁTICA ---
            // Se a senha no banco for aquele texto falso do SQL e você digitou 123...
            $hash_falso_do_sql = '$2y$10$uU8vYxN8K0bB6s4WbOaO0e6bL1d7N2X1W4E3r5T6y7U8i9O0p1a2s';
            if ($usuario && $usuario['senha'] === $hash_falso_do_sql && $senha === '123') {
                // O sistema gera uma criptografia real na hora e atualiza o banco sozinho!
                $hash_real = password_hash('123', PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE usuario SET senha = :hash WHERE id = :id");
                $update->execute([':hash' => $hash_real, ':id' => $usuario['id']]);
                
                // Atualiza a variável na memória para o login funcionar imediatamente
                $usuario['senha'] = $hash_real; 
            }
            // --- FIM DA CORREÇÃO AUTOMÁTICA ---

            // Agora a verificação padrão vai funcionar perfeitamente
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                
                // Autenticação realizada com sucesso!
                $_SESSION['usuario_logado'] = true;
                $_SESSION['id_usuario']     = $usuario['id'];
                $_SESSION['nome_usuario']   = $usuario['nome'];
                
                // Redireciona para o painel administrativo
                header('Location: index.php');
                exit;
            } else {
                // Usuário ou senha incorretos
                header('Location: login.php?erro=Usuário ou senha incorretos.');
                exit;
            }

        } catch (PDOException $e) {
            die('Erro no servidor: ' . $e->getMessage());
        }
    } else {
        header('Location: login.php?erro=Preencha todos os campos.');
        exit;
    }
} else {
    // Acesso direto ao arquivo sem passar pelo formulário, volta pro login
    header('Location: login.php');
    exit;
}
?>