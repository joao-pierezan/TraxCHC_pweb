<?php
session_start();

// Proteção: Se não estiver logado, volta para o login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if (empty($nome) || empty($telefone) || empty($email) || empty($login) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif ($senha !== $confirmar_senha) {
        $erro = 'As senhas informadas não coincidem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } else {
        try {
            $stmt_check = $conn->prepare("SELECT id FROM usuario WHERE login = :login OR email = :email");
            $stmt_check->execute(['login' => $login, 'email' => $email]);
            
            if ($stmt_check->rowCount() > 0) {
                $erro = 'Este Login ou E-mail já está cadastrado no sistema.';
            } else {
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                $stmt_insert = $conn->prepare("INSERT INTO usuario (nome, telefone, email, login, senha) VALUES (:nome, :telefone, :email, :login, :senha)");
                $stmt_insert->execute([
                    'nome' => $nome,
                    'telefone' => $telefone,
                    'email' => $email,
                    'login' => $login,
                    'senha' => $senha_hash
                ]);

                $sucesso = 'Novo usuário administrador cadastrado com sucesso!';
                $nome = $telefone = $email = $login = '';
            }
        } catch (PDOException $e) {
            $erro = 'Erro no banco de dados: ' . $e->getMessage();
        }
    }
}

// Configura o caminho dinâmico antes de renderizar o cabeçalho
$base_path = "../../"; 
include "../header-admin.php";
?>

<div class="container my-5" style="max-width: 650px;">
    
    <div class="mb-4">
        <span class="section-label mb-1">Equipe e Acessos</span>
        <h2 class="fw-bold text-white m-0" style="letter-spacing: -0.5px;">
            <i class="bi bi-person-plus-fill me-2" style="color: var(--gold);"></i>Cadastrar Usuário
        </h2>
    </div>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-20 text-danger small mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $erro; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
        <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-20 text-success small mb-4">
            <i class="bi bi-check-circle-fill me-2"></i><?= $sucesso; ?>
        </div>
    <?php endif; ?>

    <div class="glass-card p-4 shadow-lg border-0">
        <form action="UsuarioForm.php" method="POST">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label small fw-semibold mb-2 text-white-50">Nome Completo *</label>
                    <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="nome" value="<?= htmlspecialchars($nome ?? ''); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold mb-2 text-white-50">Telefone / Celular *</label>
                    <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="telefone" id="telefone" value="<?= htmlspecialchars($telefone ?? ''); ?>" required placeholder="(00) 00000-0000">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold mb-2 text-white-50">E-mail *</label>
                    <input type="email" class="form-control bg-transparent text-white border-secondary py-2" name="email" value="<?= htmlspecialchars($email ?? ''); ?>" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label small fw-semibold mb-2 text-white-50">Login de Acesso *</label>
                    <input type="text" class="form-control bg-transparent text-white border-secondary py-2" name="login" value="<?= htmlspecialchars($login ?? ''); ?>" required autocomplete="off">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold mb-2 text-white-50">Senha *</label>
                    <input type="password" class="form-control bg-transparent text-white border-secondary py-2" name="senha" required placeholder="Mínimo 6 caracteres">
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label small fw-semibold mb-2 text-white-50">Confirmar Senha *</label>
                    <input type="password" class="form-control bg-transparent text-white border-secondary py-2" name="confirmar_senha" required>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3 border-top border-secondary border-opacity-25 mt-2">
                <a href="UsuarioList.php" class="btn btn-transparente text-uppercase px-4 py-2" style="font-size: 0.8rem; font-weight: 700; border-radius: 999px;">
                    Voltar
                </a>
                <button type="submit" class="btn btn-gold px-4 py-2 text-uppercase d-flex align-items-center gap-2" style="font-size: 0.8rem; font-weight: 700;">
                    <i class="bi bi-floppy-fill"></i> Salvar Usuário
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('telefone').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); 
        if (value.length > 11) value = value.slice(0, 11); 
        if (value.length > 2) value = '(' + value.slice(0, 2) + ') ' + value.slice(2);
        if (value.length > 9) value = value.slice(0, 10) + '-' + value.slice(10);
        e.target.value = value;
    });
</script>

<?php include "../footer-admin.php"; ?>