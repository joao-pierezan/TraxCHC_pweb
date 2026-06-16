<?php
session_start();

// Verifica se o usuário não está logado, caso seja verdadeiro ele é direcionado para a página de login
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php?erro=Faça login para acessar o painel.');
    exit;
}

// Configura o caminho base (como index.php está na raiz da pasta admin, voltamos 1 nível para chegar no site)
$base_path = "../"; 
include 'header-admin.php'; 
?>

<div class="container my-5">
    <div class="glass-card p-5 mb-5 shadow-lg border-0">
        <div class="py-2">
            <span class="section-label mb-2">Painel de Controle</span>
            <h1 class="fw-bold text-white mb-3" style="font-size: clamp(2rem, 4vw, 3rem); letter-spacing: -0.5px;">
                Bem-vindo de volta!
            </h1>
            <p class="fs-5 mb-4 text-white-50" style="max-width: 850px; line-height: 1.7;">
                Seja bem-vindo à área administrativa da TraxCHC. Aqui você pode gerenciar as categorias organizacionais, os produtos premium da vitrine e ler os feedbacks e mensagens enviadas pelos seus investidores e clientes.
            </p>
            
            <hr class="border-secondary opacity-25 my-4">
            
            <div class="row g-4 pt-2">
                
                <div class="col-md-3">
                    <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                        <div>
                            <h5 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--gold);">
                                <i class="bi bi-tags-fill"></i> Categorias
                            </h5>
                            <p class="small mb-4 text-white-50">Organize, agrupe, adicione e gerencie os nichos e categorias dos ativos e produtos exibidos.</p>
                        </div>
                        <a href="categoria/CategoriaList.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                            Acessar Módulo
                        </a>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                        <div>
                            <h5 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--gold);">
                                <i class="bi bi-box-seam-fill"></i> Produtos
                            </h5>
                            <p class="small mb-4 text-white-50">Cadastre novos itens, faça upload de imagens, edite preços e controle as especificações da vitrine.</p>
                        </div>
                        <a href="produto/ProdutoList.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                            Acessar Módulo
                        </a>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                        <div>
                            <h5 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--gold);">
                                <i class="bi bi-envelope-open-fill"></i> Mensagens
                            </h5>
                            <p class="small mb-4 text-white-50">Consulte o canal de atendimento, verifique dúvidas e feedbacks enviados através do formulário.</p>
                        </div>
                        <a href="mensagem/MensagemList.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                            Acessar Módulo
                        </a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-4 h-100 d-flex flex-column justify-content-between sub-card">
                        <div>
                            <h5 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--gold);">
                                <i class="bi bi-people-fill"></i> Usuários
                            </h5>
                            <p class="small mb-4 text-white-50">Consulte o painel de usuários e cadastre novos administradores com acesso restrito ao sistema.</p>
                        </div>
                        <a href="usuario/UsuarioList.php" class="btn btn-transparente btn-sm w-100 text-uppercase py-2" style="font-size: 0.78rem; font-weight: 700; letter-spacing: 0.05em; border-radius: 999px;">
                            Acessar Módulo
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .sub-card {
        background-color: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        transition: all 0.3s ease;
    }
    .sub-card:hover {
        background-color: rgba(255, 255, 255, 0.05);
        border-color: rgba(212, 175, 55, 0.4);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
</style>

<?php include 'footer-admin.php'; ?>