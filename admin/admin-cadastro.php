<?php
session_start();



// Conexão com o Banco de Dados
require_once __DIR__ . '/../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

$erro = '';
$sucesso = '';

// 2. Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // Validações obrigatórias
    if (empty($nome) || empty($telefone) || empty($email) || empty($login) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif ($senha !== $confirmar_senha) {
        $erro = 'As senhas informadas não coincidem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } else {
        try {
            // Verifica se o Login ou Email já existem para evitar duplicidade
            $stmt_check = $conn->prepare("SELECT id FROM usuario WHERE login = :login OR email = :email");
            $stmt_check->execute(['login' => $login, 'email' => $email]);
            
            if ($stmt_check->rowCount() > 0) {
                $erro = 'Este Login ou E-mail já está cadastrado no sistema.';
            } else {
                
                // Criptografia da senha
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Inserção com os 5 campos exatos do trabalho
                $stmt_insert = $conn->prepare("INSERT INTO usuario (nome, telefone, email, login, senha) VALUES (:nome, :telefone, :email, :login, :senha)");
                $stmt_insert->execute([
                    'nome' => $nome,
                    'telefone' => $telefone,
                    'email' => $email,
                    'login' => $login,
                    'senha' => $senha_hash
                ]);

                $sucesso = 'Novo usuário administrador cadastrado com sucesso!';
                
                // Limpa as variáveis para resetar o formulário visualmente
                $nome = $telefone = $email = $login = '';
            }
        } catch (PDOException $e) {
            $erro = 'Erro no banco de dados: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../style.css">
</head>
<body class="pb-5">

    <?php include 'header-admin.php'; ?>

    <div class="container my-5" style="max-width: 650px;">
        
        <div class="mb-4">
            <span class="section-label mb-1">Equipe e Acessos</span>
            <h2 class="fw-bold m-0" style="letter-spacing: -0.5px; color: var(--text-main);">
                <i class="bi bi-person-plus-fill me-2" style="color: var(--gold);"></i>Cadastrar Usuário
            </h2>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger small mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $erro; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($sucesso)): ?>
            <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-20 text-success small mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $sucesso; ?>
            </div>
        <?php endif; ?>

        <div class="glass-card p-4 shadow-lg border-0">
            
            <form action="admin-cadastro.php" method="POST">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label small fw-semibold mb-2 text-white-50">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="nome" value="<?= htmlspecialchars($nome ?? ''); ?>" required placeholder="Ex: João da Silva">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold mb-2 text-white-50">Telefone / Celular <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="telefone" id="telefone" value="<?= htmlspecialchars($telefone ?? ''); ?>" required placeholder="(00) 00000-0000">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold mb-2 text-white-50">E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control bg-transparent text-white border-secondary py-2" name="email" value="<?= htmlspecialchars($email ?? ''); ?>" required placeholder="exemplo@email.com">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label small fw-semibold mb-2 text-white-50">Login de Acesso <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="login" value="<?= htmlspecialchars($login ?? ''); ?>" required autocomplete="off" placeholder="Ex: joao.admin">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold mb-2 text-white-50">Senha <span class="text-danger">*</span></label>
                        <input type="password" class="form-control bg-transparent text-white border-secondary py-2" name="senha" required placeholder="Mínimo 6 caracteres">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label small fw-semibold mb-2 text-white-50">Confirmar Senha <span class="text-danger">*</span></label>
                        <input type="password" class="form-control bg-transparent text-white border-secondary py-2" name="confirmar_senha" required placeholder="Repita a senha">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top border-secondary border-opacity-25 mt-2 pt-3">
                    <a href="index.php" class="btn btn-transparente text-uppercase px-4 py-2" style="font-size: 0.8rem; font-weight: 700; border-radius: 999px;">
                        Voltar
                    </a>
                    <button type="submit" class="btn btn-gold text-uppercase px-4 py-2 d-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 700;">
                        <i class="bi bi-floppy-fill"></i> Salvar Usuário
                    </button>
                </div>
            </form>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('telefone').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); 
            if (value.length > 11) value = value.slice(0, 11); 
            
            if (value.length > 2) {
                value = '(' + value.slice(0, 2) + ') ' + value.slice(2);
            }
            if (value.length > 9) {
                value = value.slice(0, 10) + '-' + value.slice(10);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>