<?php
session_start();

// Proteção da página: se não estiver logado, redireciona para o formulário de login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php?erro=Faça login para acessar o painel.');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - TraxCHC</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <?php include 'header-admin.php'; ?>

    <div class="container my-5">
        <div class="glass-card p-5 mb-5 shadow-lg">
            <div class="py-2">
                <span class="section-label">Painel de Controle</span>
                <h1 class="fw-bold mb-3" style="font-size: clamp(2rem, 4vw, 3rem); letter-spacing: -0.5px;">
                    Bem-vindo de volta!
                </h1>
                <p class="fs-5 mb-4" style="color: var(--text-muted); max-width: 850px; line-height: 1.7;">
                    Seja bem-vindo à área administrativa da TraxCHC. Aqui você pode gerenciar as categorias organizacionais, os produtos premium da vitrine e ler os feedbacks e mensagens enviadas pelos seus investidores e clientes.
                </p>
                
                <hr style="border-color: var(--border); opacity: 1;" class="my-4">
                
                <div class="row g-4 pt-2">
                    
                    <div class="col-md-3">
                        <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                            <div>
                                <h5 class="fw-bold mb-2" style="color: var(--gold);"> Categorias</h5>
                                <p class="small mb-4" style="color: var(--text-muted);">Organize, agrupe, adicione e gerencie os nichos e categorias dos ativos e produtos exibidos.</p>
                            </div>
                            <a href="categorias.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                                Visualizar
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                            <div>
                                <h5 class="fw-bold mb-2" style="color: var(--gold);"> Produtos</h5>
                                <p class="small mb-4" style="color: var(--text-muted);">Cadastre novos itens, faça upload de imagens, edite preços e controle as especificações da vitrine.</p>
                            </div>
                            <a href="produtos.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2 rounded-5" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em border-radius: 999px;">
                                Visualizar 
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                            <div>
                                <h5 class="fw-bold mb-2" style="color: var(--gold);"> Mensagens</h5>
                                <p class="small mb-4" style="color: var(--text-muted);">Consulte o canal de atendimento, verifique dúvidas e feedbacks enviados através do formulário.</p>
                            </div>
                            <a href="mensagens.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                                Visualizar 
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                            <div>
                                <h5 class="fw-bold mb-2" style="color: var(--gold);"> Usuários</h5>
                                <p class="small mb-4" style="color: var(--text-muted);">Consulte painel de usuários cadastrados e cadastre mais usuários admin</p>
                            </div>
                            <a href="usuarios.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                                Visualizar 
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .sub-card {
            background-color: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 18px;
            transition: all 0.3s ease;
        }
        .sub-card:hover {
            background-color: rgba(255, 255, 255, 0.06);
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-3px);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bundle.min.js"></script>
</body>
</html>