<?php
session_start();
require_once __DIR__ . '/site/database/db.class.php';

$id = $_GET['id'] ?? $_POST['id'] ?? '';
$alerta = '';

// SEGURANÇA: Se a pessoa não tiver o ID ou não tiver a permissão na sessão, é expulsa para o contato
if (empty($id) || !isset($_SESSION['pode_editar_' . $id])) {
    header('Location: contato.php');
    exit;
}

$db = new db();
$conn = $db->connect();

// Se clicou em Salvar Alterações...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $assunto = $_POST['assunto'] ?? '';
    $texto = $_POST['texto'] ?? '';

    if (!empty($nome) && !empty($email) && !empty($texto)) {
        try {
            $stmt = $conn->prepare("UPDATE mensagem SET nome = :nome, email = :email, telefone = :telefone, assunto = :assunto, texto = :texto WHERE id = :id");
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'assunto' => $assunto,
                'texto' => $texto,
                'id' => $id
            ]);
            $alerta = "<div class='alert alert-success border-0 shadow-sm'>
                        Sua mensagem foi atualizada com sucesso! <br>
                        <a href='contato.php' class='btn btn-sm btn-outline-success mt-2'>Voltar para Contato</a>
                       </div>";
        } catch (PDOException $e) {
            $alerta = "<div class='alert alert-danger border-0 shadow-sm'>Erro ao atualizar: " . $e->getMessage() . "</div>";
        }
    }
}

// Busca os dados atuais da mensagem para preencher o formulário
$stmt = $conn->prepare("SELECT * FROM mensagem WHERE id = :id");
$stmt->execute(['id' => $id]);
$mensagem = $stmt->fetch();

if (!$mensagem) {
    header('Location: contato.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Mensagem | TraxCHC</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <?php include 'header.php'; ?>

  <main style="margin-top: 100px;">
    <section class="section section-dark text-center pb-0">
      <div class="container">
        <h1 class="section-title">Editar Mensagem</h1>
        <p class="section-text mt-3">Protocolo #TX<?= str_pad($mensagem['id'], 4, '0', STR_PAD_LEFT); ?></p>
      </div>
    </section>

    <section class="section section-dark">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card bg-dark text-light border-secondary p-4 rounded-4">
              
              <?= $alerta; ?>

              <form method="POST" action="contato-editar.php">
                <input type="hidden" name="id" value="<?= htmlspecialchars($mensagem['id']); ?>">
                
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" class="form-control bg-dark text-light border-secondary" name="nome" value="<?= htmlspecialchars($mensagem['nome']); ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">E-mail</label>
                    <input type="email" class="form-control bg-dark text-light border-secondary" name="email" value="<?= htmlspecialchars($mensagem['email']); ?>" required>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label class="form-label">Telefone / WhatsApp</label>
                  <input type="tel" class="form-control bg-dark text-light border-secondary" name="telefone" value="<?= htmlspecialchars($mensagem['telefone']); ?>">
                </div>
                
                <div class="mb-3">
                  <label class="form-label">Assunto</label>
                  <select class="form-select bg-dark text-light border-secondary" name="assunto" required>
                    <option value="Dúvidas sobre Metais Preciosos" <?= $mensagem['assunto'] == 'Dúvidas sobre Metais Preciosos' ? 'selected' : ''; ?>>Dúvidas sobre Metais Preciosos</option>
                    <option value="Certificação de Pedras" <?= $mensagem['assunto'] == 'Certificação de Pedras' ? 'selected' : ''; ?>>Certificação de Pedras</option>
                    <option value="Status de Pedido" <?= $mensagem['assunto'] == 'Status de Pedido' ? 'selected' : ''; ?>>Status de Pedido</option>
                    <option value="Parceria Comercial" <?= $mensagem['assunto'] == 'Parceria Comercial' ? 'selected' : ''; ?>>Parceria Comercial</option>
                    <option value="Outros" <?= $mensagem['assunto'] == 'Outros' ? 'selected' : ''; ?>>Outros</option>
                  </select>
                </div>
                
                <div class="mb-4">
                  <label class="form-label">Sua Mensagem</label>
                  <textarea class="form-control bg-dark text-light border-secondary" name="texto" rows="5" required><?= htmlspecialchars($mensagem['texto']); ?></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="contato.php" class="btn btn-outline-light">Cancelar</a>
                    <button type="submit" class="btn btn-gold">Salvar Alterações <i class="bi bi-check-circle ms-2"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>
</body>
</html>