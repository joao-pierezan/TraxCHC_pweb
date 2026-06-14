<?php
class db {
    private $host     = 'localhost';
    private $dbname   = 'db_pweb1_traxchc'; // Nome correto com bd_
    private $username = 'root';
    private $password = ''; // Usar aspas vazias é o padrão seguro para XAMPP

    public function connect() {
        try {
            $conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4", 
                $this->username, 
                $this->password
            );
            
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conexao;

        } catch (PDOException $e) {
            die('Erro na ligação à base de dados: ' . $e->getMessage());
        }
    }
}
?>