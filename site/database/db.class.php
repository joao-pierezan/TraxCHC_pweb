<?php
class db {
    private $host     = 'localhost';
    private $dbname   = 'db_pweb1_traxchc'; // 4 atributos que o php usa para se conectar com o banco
    private $username = 'root';
<<<<<<< HEAD
    private $password = ''; // Usar aspas vazias é o padrão seguro para XAMPP
=======
    private $password = null;
>>>>>>> c8b35ed8d7310baa9b4cbfc122c32d3bc25ac834

    public function connect() { //função para conectar com o banco
        try {
            $conexao = new PDO( //PDO é a ferramenta que o php usa para conversar com o banco
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4", // Para o PDO saber o endereço do servidor e o nome do banco
                $this->username, 
                $this->password
            );
            
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//no exato momento que o código der erro, ele para e mostra o erro
            $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conexao;

        } catch (PDOException $e) {
            die('Erro na ligação à base de dados: ' . $e->getMessage());
        }
    }
}
?>