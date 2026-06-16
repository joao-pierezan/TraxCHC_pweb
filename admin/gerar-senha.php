<?php
// Gerando a criptografia correta para a senha "123" exigida pelo professor
echo password_hash('123', PASSWORD_DEFAULT);
?>