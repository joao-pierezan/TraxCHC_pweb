<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TraxCHC</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"> 

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.html">
          <img src="img/logo_traxchc.png" alt="TraxCHC" class="brand-logo">
        </a>

        <a class="navbar-toggler" type="a" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
          <span class="navbar-toggler-icon"></span>
        </a>

        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
          <ul class="navbar-nav gap-lg-4">
            <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
            <li class="nav-item"><a class="nav-link" href="sobre.php">QUEM SOMOS?</a></li>
            <li class="nav-item"><a class="nav-link" href="loja.php">COMPRAR</a></li>
            <li class="nav-item"><a class="nav-link" href="contato.php">CONTATE-NOS</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <a id="toggleSidebar" class="btn btn-outline-light position-fixed" 
      style="top: 20px; right: 20px; z-index: 1050;">
      <i id="iconSidebar" class="bi bi-question-lg fs-4"></i>
    </a>

    <aside id="sidebar" class="sidebar navbar-dark p-4">
      <h4 class="mb-4 ">Perguntas Frequentes</h4>

      <div class="accordion accordion-flush" id="faqAccordion">

        <div class="accordion-item bg-dark text-light border-secondary">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-dark text-light" type="button"
                    data-bs-toggle="collapse" data-bs-target="#faq1">
              As joias são autênticas?
            </button>
          </h2>
          <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Sim. Trabalhamos apenas com metais e pedras preciosas certificados, garantindo autenticidade e procedência.
            </div>
          </div>
        </div>

        <div class="accordion-item bg-dark text-light border-secondary">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-dark text-light" type="button"
                    data-bs-toggle="collapse" data-bs-target="#faq2">
              Os produtos possuem certificado?
            </button>
          </h2>
          <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Todas as peças acompanham certificado de autenticidade e garantia.
            </div>
          </div>
        </div>

        <div class="accordion-item bg-dark text-light border-secondary">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-dark text-light" type="button"
                    data-bs-toggle="collapse" data-bs-target="#faq3">
              É seguro comprar pelo site?
            </button>
          </h2>
          <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Utilizamos sistemas de segurança avançados para proteger seus dados e transações.
            </div>
          </div>
        </div>

        <div class="accordion-item bg-dark text-light border-secondary">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-dark text-light" type="button"
                    data-bs-toggle="collapse" data-bs-target="#faq4">
              Posso considerar como investimento?
            </button>
          </h2>
          <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Ouro, prata e pedras preciosas são ativos de valor duradouro e reconhecidos mundialmente.
            </div>
          </div>
        </div>

        <div class="accordion-item bg-dark text-light border-secondary">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-dark text-light" type="button"
                    data-bs-toggle="collapse" data-bs-target="#faq5">
              Qual o prazo de entrega?
            </button>
          </h2>
          <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              O prazo varia conforme a região e é informado no momento da compra.
            </div>
          </div>
        </div>

      </div>
    </aside>

  </header>

  <main>
    <section class="hero">
      <div class="hero-overlay"></div>
      <div class="container hero-content">
        <div class="row">
          <div class="col-lg-7">
            <span class="hero-kicker">Metais preciosos • valor real • patrimônio</span>
            <h1 class="hero-title">Invista em metais e pedras preciosas com elegância e segurança</h1>
            <p class="hero-text">
              Uma experiência pensada para quem busca solidez, exclusividade e proteção de valor ao longo do tempo.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
              <a href="paginas/loja.html" class="btn btn-gold btn-lg">Começar agora</a>
              <a href="paginas/sobre.html" class="btn btn-outline-light btn-lg">Conheça a empresa</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section section-dark">
      <div class="container">
        <h2 class="section-title">Produtos Principais</h2>

        <div class="row">
          
          <div class="col-4">
            <div class="img-wrapper">
              <img src="img/ouro_venda.webp" class="img-fluid img-produto">
              <a class="btn btn-outline-primary btn-overlay " href="paginas/loja.html">
                Comprar Ouro
              </a>
            </div>
          </div>

          <div class="col-4">
            <div class="img-wrapper">
              <img src="img/prata_venda.webp" class="img-fluid img-produto">
              <a class="btn btn-outline-primary btn-overlay"href="paginas/loja.html">
                Comprar Prata
              </a>
            </div>
          </div>

          <div class="col-4">
            <div class="img-wrapper">
              <img src="img/diamante_venda.png" class="img-fluid rounded-4 img-produto">
              <a class="btn btn-outline-primary btn-overlay" href="paginas/loja.html">
                Comprar Diamantes
              </a>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class="section section-blue">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-5">
            <h2 class="section-title">Ouro: um ativo seguro</h2>
            <p class="section-text">
              Proteja seu capital contra inflação e instabilidade com um dos ativos mais sólidos do mundo.
            </p>
            <p class="section-text muted">
              Uma visão clara do comportamento do ouro nos últimos anos ajuda a entender por que ele continua sendo referência de proteção.
            </p>

          </div>

          <div class="col-lg-7">
            <div class="glass-card chart-card">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <h3 class="card-title-custom mb-1">Preço do ouro</h3>
                  <p class="card-subtitle-custom mb-0">Últimos 5 anos</p>
                </div>
                <span class="badge badge-gold">USD / oz</span>
              </div>
              <div class="chart-wrapper">
                <canvas id="goldChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="section section-blue">
      <div class="container">
        <div class="row align-items-center g-5 flex-lg-row-reverse">
          <div class="col-6">
            <h2 class="section-title">Pedras preciosas</h2>
            <p class="section-text">
              Amplie sua visão de investimento com diamantes, rubis e outras raridades de alto valor.
            </p>

            <p class="section-text">
              Nossas pedras preciosas representam o ápice da excelência e da sofisticação. Cada gema é selecionada com rigor absoluto, valorizando 
              critérios como pureza, lapidação impecável e brilho extraordinário. Todas passam por um processo criterioso de autenticação, garantindo não 
              apenas sua origem, mas também sua exclusividade e valor no mercado.
            </p>
             <div class="mt-auto">
              <a href="paginas/loja.html" class="btn btn-outline-light btn-transparente ">
                Comprar Agora
              </a>
            </div>
          </div>
          <div class="col-6">
            <div class="">
              <img src="img/asdasd.png" alt="Joias e pedras preciosas" class="img-fluid w-100">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section section-blue">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="">
              <img src="img/certificado-diamante-gia.jpeg" alt="Segurança e armazenamento" class="img-cover img-fluid rounded-4">
            </div>
          </div>

          <div class="col-lg-6">
            <h2 class="section-title">Segurança garantida</h2>
            <p class="section-text">
              Certificação, procedência e uma apresentação visual que transmite confiança desde o primeiro contato.
            </p>
            <ul class="list-unstyled section-text">

            <li class="d-flex align-items-center mb-2">
              <i class="bi bi-shield-check me-2"></i>
              Certificação oficial de pureza e composição dos metais preciosos
            </li>

            <li class="d-flex align-items-center mb-2">
              <i class="bi bi-shield-check me-2"></i>
              Autenticação rigorosa de pedras com análise especializada
            </li>

            <li class="d-flex align-items-center mb-2">
              <i class="bi bi-shield-check me-2"></i>
              Procedência garantida com rastreabilidade do material
            </li>

            <li class="d-flex align-items-center mb-2">
              <i class="bi bi-shield-check me-2"></i>
              Padrões internacionais de qualidade e avaliação
            </li>

          </ul>

          <a href="#" class="btn btn-outline-light btn-transparente mt-3 px-4">
            Conferir autenticidade
          </a>


            
          </div>
        </div>
      </div>
    </section>

    <section class="section section-bottom section-bottom d-flex">
      <div class="container">

        <h2 class="section-title mb-4">
          Pensando em Colecionar?
        </h2>

        <div id="carouselMoedas" class="carousel slide" data-bs-ride="false">
          
          <div class="carousel-inner">

            <div class="carousel-item active">
              <div class="row g-4">

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_1.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda Romana Antiga</h5>
                      <p>Moeda histórica do Império Romano, datada de aproximadamente 200 d.C.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_2.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda de Ouro 24k</h5>
                      <p>Peça moderna em ouro puro, excelente para investimento.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_3.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda Comemorativa</h5>
                      <p>Edição limitada lançada em evento histórico.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_4.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda de Ouro Antiga</h5>
                      <p>Produzida em prata maciça com excelente conservação.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="carousel-item">
              <div class="row g-4">

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_5.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda Bizantina</h5>
                      <p>Peça rara do Império Bizantino, altamente colecionável.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_6.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda Estanunidense</h5>
                      <p>Metal raro com alto valor de investimento.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_7.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda Antiga Grâ-Bretanha</h5>
                      <p>Relíquia histórica do oriente, com design único.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 d-flex">
                  <div class="card h-100 w-100">
                    <img src="img/moeda_8.webp" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                      <h5>Moeda de Ouro Rara</h5>
                      <p>Edição extremamente limitada para investidores exigentes.</p>
                      <a href="paginas/loja.html" class="btn btn-outline-light mt-auto">Comprar</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carouselMoedas" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>

          <button class="carousel-control-next" type="button" data-bs-target="#carouselMoedas" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>

        </div>

      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="row align-items-center gy-3">
        <div class="col-md-6">
          <div class="footer-links">
            <a href="#">TRABALHE CONOSCO</a>
            <a href="#">CONTATO</a>
          </div>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="footer-social">
            <span>SIGA-NOS:</span>
            <a href="https://www.facebook.com/TraxCHC" target="_blank" rel="noopener">FACEBOOK</a>
            <a href="https://www.instagram.com/trax_CHC/" target="_blank" rel="noopener">INSTAGRAM</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script>
      const ctx = document.getElementById("goldChart");

      if (ctx) {
        new Chart(ctx, {
          type: "line",
          data: {
            labels: ["2020", "2021", "2022", "2023", "2024"],
            datasets: [{
              label: "Preço do ouro (USD)",
              data: [1790, 1800, 1710, 1945, 2320],
              borderColor: "#d4af37",
              backgroundColor: "rgba(212, 175, 55, 0.15)",
              pointBackgroundColor: "#d4af37",
              pointBorderColor: "#d4af37",
              borderWidth: 3,
              tension: 0.35,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                labels: {
                  color: "#f5f5f5",
                  font: {
                    family: "Montserrat"
                  }
                }
              }
            },
            scales: {
              x: {
                ticks: { color: "#cfcfcf" },
                grid: { color: "rgba(255,255,255,0.08)" }
              },
              y: {
                ticks: { color: "#cfcfcf" },
                grid: { color: "rgba(255,255,255,0.08)" }
              }
            }
          }
        });
      }

    // Reviews sidebar
    const toggleReviews = document.getElementById("toggleReviews");
    const reviewsSidebar = document.getElementById("reviewsSidebar");
    const closeReviews = document.getElementById("closeReviews");

    toggleReviews.addEventListener("click", () => {
      reviewsSidebar.classList.toggle("active");
    });
    closeReviews.addEventListener("click", () => {
      reviewsSidebar.classList.remove("active");
    });

    const btn = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");
    const icon = document.getElementById("iconSidebar");

    btn.addEventListener("click", () => {
      sidebar.classList.toggle("active");

      // troca ícone
      if (sidebar.classList.contains("active")) {
        icon.classList.remove("bi-list");
        icon.classList.add("bi-x");
      } else {
        icon.classList.remove("bi-x");
        icon.classList.add("bi-list");
      }
    });

  </script>
</body>
</html>