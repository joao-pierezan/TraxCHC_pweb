<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contato | TraxCHC</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  
  <link rel="stylesheet" href="style.css">
</head>

<body>

<?php 
session_start(); 

// Inicia a conexão com o banco
require_once __DIR__ . '/site/database/db.class.php';

$alerta = '';

// Se o formulário foi enviado...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $assunto = $_POST['assunto'] ?? '';
    $texto = $_POST['texto'] ?? '';

    // Verifica os campos obrigatórios apenas no POST correto
    if (!empty($nome) && !empty($email) && !empty($texto)) {
        $db = new db();
        $conn = $db->connect();
        
        try {
            $stmt = $conn->prepare("INSERT INTO mensagem (nome, email, telefone, assunto, texto) VALUES (:nome, :email, :telefone, :assunto, :texto)");
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'assunto' => $assunto,
                'texto' => $texto
            ]);
            
            // 1. Pega o ID que o banco acabou de criar para esta mensagem
            $id_mensagem = $conn->lastInsertId();
            
            // 2. Cria uma permissão na sessão dizendo que este usuário pode editar ESTA mensagem
            $_SESSION['pode_editar_' . $id_mensagem] = true;
            
            // 3. Formata para ficar bonito (Ex: de "5" vira "0005")
            $protocolo = "#TX" . str_pad($id_mensagem, 4, '0', STR_PAD_LEFT);
            
            // 4. Mostra a mensagem de sucesso com o botão de Editar
            $alerta = "<div class='alert alert-success border-0 shadow-sm'>
                        Sua mensagem foi enviada com sucesso! <br>
                        <strong>Seu protocolo é: $protocolo</strong>. <br>
                        Retornaremos em até 24 horas.<br><br>
                        <a href='contato-editar.php?id=$id_mensagem' class='btn btn-sm btn-success fw-bold'>
                            <i class='bi bi-pencil'></i> Editar minha mensagem
                        </a>
                       </div>";
        } catch (PDOException $e) {
            $alerta = "<div class='alert alert-danger border-0 shadow-sm'>Erro ao enviar: " . $e->getMessage() . "</div>";
        }
    }
}
?>

  <?php include 'header.php'; ?>

  <main style="margin-top: 100px;">
    
    <section class="section section-dark text-center pb-0">
      <div class="container">
        <h1 class="section-title">Contato</h1>
        <p class="section-text mt-3">Estamos aqui para atender você com exclusividade e rapidez.</p>
      </div>
    </section>

    <section class="section section-dark">
      <div class="container">
        <div class="row g-5">
          
          <div class="col-lg-7">
            <div class="card bg-dark text-light border-secondary p-4 h-100 rounded-4">
              <h2 class="mb-3">Envie uma Mensagem</h2>
              <p class="text-muted mb-4">Responderemos em até 24 horas úteis</p>

              <?= $alerta; ?>

              <form id="contactForm" method="POST" action="contato.php">
                <div class="row g-3 mb-3">
                  <div class="col-md-6">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control bg-dark text-light border-secondary" id="nome" name="nome" placeholder="Seu nome" required>
                  </div>
                  <div class="col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control bg-dark text-light border-secondary" id="email" name="email" placeholder="seu@email.com" required>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label for="telefone" class="form-label">Telefone / WhatsApp</label>
                  <input type="tel" class="form-control bg-dark text-light border-secondary" id="telefone" name="telefone" placeholder="+55 (00) 00000-0000">
                </div>
                
                <div class="mb-3">
                  <label for="assunto" class="form-label">Assunto</label>
                  <select class="form-select bg-dark text-light border-secondary" id="assunto" name="assunto" required>
                    <option value="" disabled selected>Selecione o motivo do contato</option>
                    <option value="Dúvidas sobre Metais Preciosos">Dúvidas sobre Metais Preciosos</option>
                    <option value="Certificação de Pedras">Certificação de Pedras</option>
                    <option value="Status de Pedido">Status de Pedido</option>
                    <option value="Parceria Comercial">Parceria Comercial</option>
                    <option value="Outros">Outros</option>
                  </select>
                </div>
                
                <div class="mb-4">
                  <label for="texto" class="form-label">Mensagem</label>
                  <textarea class="form-control bg-dark text-light border-secondary" id="texto" name="texto" rows="4" placeholder="Descreva como podemos ajudá-lo..." required></textarea>
                </div>
                
                <button type="submit" class="btn btn-gold w-100">Enviar Mensagem <i class="bi bi-arrow-right ms-2"></i></button>
              </form>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="d-flex flex-column gap-4 h-100">
              
              <div class="card bg-dark text-light border-secondary p-4 rounded-4">
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-whatsapp fs-3 text-success me-3"></i>
                  <h4 class="mb-0">WhatsApp</h4>
                </div>
                <p class="section-text mb-0">+55 (49) 99168-5744<br><small class="text-muted">Atendimento imediato</small></p>
              </div>

              <div class="card bg-dark text-light border-secondary p-4 rounded-4">
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-envelope fs-3 text-warning me-3"></i>
                  <h4 class="mb-0">E-mail</h4>
                </div>
                <p class="section-text mb-0">contato@traxchc.com<br><small class="text-muted">Retorno em até 24h</small></p>
              </div>

              <div class="card bg-dark text-light border-secondary p-4 rounded-4">
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-geo-alt fs-3 text-primary me-3"></i>
                  <h4 class="mb-0">Endereço</h4>
                </div>
                <p class="section-text mb-0">Av. Faria Lima, 3400 - 15º Andar<br>São Paulo, SP</p>
              </div>

            </div>
          </div>
          
        </div>
        
        <div class="row mt-5">
          <div class="col-12">
            <div class="card border-secondary overflow-hidden rounded-4">
              <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.065481729063!2d-46.68903368440631!3d-23.58581788467027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDMzJzQ3LjEiUyA0NsKwMzknMTUuMSJX!5e0!3m2!1spt-BR!2sbr!4v1620000000000!5m2!1spt-BR!2sbr"
                width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy">
              </iframe>
            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  <?php include 'footer.php'; ?>
</body>
</html>