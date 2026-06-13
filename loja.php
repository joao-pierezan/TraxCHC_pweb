<?php
require_once __DIR__ . '/site/database/db.class.php';
$db = new db();
$conn = $db->connect();

// Pega todos os produtos cadastrados, do mais recente para o mais antigo
$stmt = $conn->query("SELECT * FROM produto ORDER BY id DESC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja | TraxCHC - Investimento e Elegância</title>

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

    <section class="section section-dark text-center">
      <div class="container">
        <h1 class="section-title">Nossa Coleção</h1>
        <p class="section-text mt-3">Peças exclusivas &nbsp;·&nbsp; Ativos reais &nbsp;·&nbsp; Patrimônio duradouro</p>
      </div>
    </section>

    <section class="section section-blue">
      <div class="container">

        <div class="row align-items-center g-5 mb-5 pb-5 border-bottom border-secondary">
          <div class="col-lg-6">
            <span class="badge bg-warning text-dark mb-3">✦ Destaque da Semana</span>
            <h2 class="section-title">Barra de Ouro 24k</h2>
            <p class="section-text text-warning fst-italic">pureza 999.9</p>
            <p class="section-text">
              Peça certificada e selada com QR Code de rastreamento. Ideal para proteção patrimonial de longo prazo.
            </p>
            <button class="btn btn-gold mt-3">
              Ver Detalhes
            </button>
          </div>
          <div class="col-lg-6 text-center">
            <img src="img/ouro_venda.webp" alt="Barra de Ouro" class="img-fluid rounded-4 w-75">
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-end mb-4">
          <div>
            <h2 class="section-title">Todas as Peças</h2>
          </div>
        </div>

        <div class="row g-4" id="productGrid">

          <?php if (empty($produtos)): ?>
              <p class="text-center text-muted py-4">Nenhum produto cadastrado no momento.</p>
          <?php else: ?>
              <?php foreach ($produtos as $p): ?>
                <div class="col-md-6 col-lg-3 d-flex">
                  <div class="card h-100 w-100 bg-dark text-light border-secondary">
                    <div class="position-relative">
                      <?php if (!empty($p['imagem'])): ?>
                          <img src="site/assets/img/produtos/<?= htmlspecialchars($p['imagem']); ?>" alt="<?= htmlspecialchars($p['nome']); ?>" class="card-img-top" style="height: 220px; object-fit: cover;">
                      <?php else: ?>
                          <img src="img/placeholder.webp" alt="Imagem Indisponível" class="card-img-top" style="height: 220px; object-fit: cover;">
                      <?php endif; ?>
                    </div>
                    <div class="card-body d-flex flex-column">
                      <p class="text-muted small mb-1"><?= htmlspecialchars($p['categoria'] ?? 'Investimento'); ?></p>
                      <h5 class="card-title"><?= htmlspecialchars($p['nome']); ?></h5>
                      <p class="text-warning mt-auto mb-3 fw-bold">R$ <?= number_format($p['preco'], 2, ',', '.'); ?></p>
                      <button class="btn btn-outline-light w-100">Adicionar</button>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
          <?php endif; ?>

        </div>
      </div>
    </section>
  </main>
  
  <?php include 'footer.php'; ?>
</body>
</html>