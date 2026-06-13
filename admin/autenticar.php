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

            // CORREÇÃO: Usamos password_verify para comparar a senha digitada com a criptografada no banco
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                
                // Autenticação realizada com sucesso!
                $_SESSION['usuario_logado'] = true;
                $_SESSION['id_usuario']     = $usuario['id']; // Mantido exatamente como o seu original
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