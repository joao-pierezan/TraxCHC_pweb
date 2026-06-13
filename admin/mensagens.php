<?php
session_start();

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../site/database/db.class.php';
$db = new db();
$conn = $db->connect();

try {
    // Busca as mensagens da mais nova para a mais antiga
    $stmt = $conn->prepare("SELECT * FROM mensagem ORDER BY data_envio DESC");
    $stmt->execute();
    $mensagens = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar mensagens: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="../style.css">
</head>
<body class="pb-5">

    <?php include 'header-admin.php'; ?>

    <div class="container my-5">
        
        <div class="mb-4">
                <i class="bi bi-envelope-open-fill me-2" style="color: var(--gold);"></i>Caixa de Entrada
            </h2>
        </div>

        <div class="row">
            <?php if (count($mensagens) > 0): ?>
                <?php foreach ($mensagens as $m): ?>
                    <div class="col-md-6 mb-4">
                        <div class="glass-card h-100 p-0 overflow-hidden shadow-lg border-0 d-flex flex-column justify-content-between">
                            
                            <div class="p-3 bg-dark bg-opacity-25 d-flex justify-content-between align-items-center border-bottom border-secondary border-opacity-50">
                                <span class="fw-bold text-white d-flex align-items-center gap-2">
                                    <?= htmlspecialchars($m['nome']); ?>
                                    <span class="badge bg-transparent border border-secondary text-white-50" style="font-size: 0.7rem; font-weight: 500; letter-spacing: 0.5px;">
                                        #TX<?= str_pad($m['id'], 4, '0', STR_PAD_LEFT); ?>
                                    </span>
                                </span>
                                <small class="text-white-50" style="font-size: 0.8rem;">
                                    <i class="bi bi-clock me-1"></i><?= date('d/m/Y H:i', strtotime($m['data_envio'])); ?>
                                </small>
                            </div>
                            
                            <div class="p-4 flex-grow-1">
                                <div class="mb-3">
                                    <span class="d-block small text-white-50 mb-1"><i class="bi bi-reply-fill me-1 text-secondary"></i> Remetente</span>
                                    <a href="mailto:<?= $m['email']; ?>" class="text-white fw-medium small text-decoration-none hover-gold"><?= htmlspecialchars($m['email']); ?></a>
                                </div>
                                
                                <?php if (!empty($m['telefone'])): ?>
                                    <div class="mb-3">
                                        <span class="d-block small text-white-50 mb-1"><i class="bi bi-whatsapp me-1 text-success"></i> Telefone / Celular</span>
                                        <span class="text-white small"><?= htmlspecialchars($m['telefone']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mb-3">
                                    <span class="d-block small text-white-50 mb-1"><i class="bi bi-tag-fill me-1" style="color: var(--gold);"></i> Assunto de Interesse</span>
                                    <span class="fw-semibold small" style="color: var(--gold);"><?= htmlspecialchars($m['assunto']); ?></span>
                                </div>
                                
                                <div class="bg-dark bg-opacity-50 text-white-50 p-3 border border-secondary border-opacity-50 rounded-3 mt-3" style="white-space: pre-wrap; font-size: 0.9rem; line-height: 1.6;">
                                    <?= htmlspecialchars($m['texto']); ?>
                                </div>
                            </div>
                            
                            <div class="p-3 bg-dark bg-opacity-10 border-top border-secondary border-opacity-20 d-flex justify-content-end gap-2">
                                <?php 
                                    $protocolo_formatado = "#TX" . str_pad($m['id'], 4, '0', STR_PAD_LEFT);
                                    $assunto_email = "Protocolo " . $protocolo_formatado . " | TraxCHC - " . $m['assunto'];
                                ?>
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($m['email']); ?>&su=<?= urlencode($assunto_email); ?>" target="_blank" class="btn btn-sm btn-outline-warning px-3 rounded-pill" style="font-size: 0.8rem; font-weight: 600;">
                                    <i class="bi bi-arrow-turn-up-left me-1"></i> Responder por E-mail
                                </a>
                                
                                <a href="mensagem-excluir.php?id=<?= $m['id']; ?>" class="btn btn-sm btn-outline-danger px-3 rounded-pill" style="font-size: 0.8rem; font-weight: 600;" onclick="return confirm('Tem certeza que deseja apagar esta mensagem?')">
                                    <i class="bi bi-trash3 me-1"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="glass-card text-center py-5 shadow-lg border-0">
                        <i class="bi bi-inbox-fill display-4 d-block mb-3 text-secondary" style="opacity: 0.5;"></i>
                        <h5 class="fw-semibold text-white mb-1">Caixa de entrada limpa</h5>
                        <p class="text-white-50 small mb-0">Nenhuma mensagem externa foi recebida pelo site até o momento.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>