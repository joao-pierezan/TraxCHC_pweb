<?php
class db {
    private $host     = 'localhost';
    private $dbname   = 'db_pweb1_traxchc';
    private $username = 'root';
    private $password = ''; // XAMPP usa senha vazia por padrao

    // Metodo responsavel por conectar com o banco de dados
    public function connect() {
        try {
            // Instancia o PDO passando as credenciais
            $conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4", 
                $this->username, 
                $this->password
            );
            
            // Configura o PDO para exibir os erros corretamente
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conexao;

        } catch (PDOException $e) {
            die('Erro de conexao: ' . $e->getMessage());
        }
    }
}
?>