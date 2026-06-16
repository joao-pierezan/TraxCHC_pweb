-- --------------------------------------------------------
-- Banco de Dados: `db_pweb1_traxchc`
-- --------------------------------------------------------
DROP DATABASE IF EXISTS `db_pweb1_traxchc`;
CREATE DATABASE `db_pweb1_traxchc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_pweb1_traxchc`;

-- --------------------------------------------------------
-- 1. Estrutura da tabela `categoria`
-- --------------------------------------------------------
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Ativo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categoria` (`nome`, `descricao`, `status`) VALUES
('Ouro', 'Barras de ouro diversas com alto grau de pureza.', 'Ativo'),
('Prata', 'Barras de prata diversas para investimento seguro.', 'Ativo'),
('Moedas Históricas', 'Moedas raras de ouro e prata para colecionadores exigentes.', 'Ativo');

-- --------------------------------------------------------
-- 2. Estrutura da tabela `usuario`
-- --------------------------------------------------------
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserindo o administrador padrão
INSERT INTO `usuario` (`nome`, `telefone`, `email`, `login`, `senha`) VALUES
('Administrador', '(00) 00000-0000', 'admin@traxchc.com', 'admin', '$2y$10$5z3jQDNpqrQw9QQVTyBn1.Lll3InN1RlPzU6SSC1DV46XmZTUFaiO');

-- --------------------------------------------------------
-- 3. Estrutura da tabela `produto`
-- --------------------------------------------------------
CREATE TABLE `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria` (`categoria_id`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `produto` (`nome`, `descricao`, `preco`, `categoria_id`) VALUES
('Barra de Ouro 250g', 'Barra de Ouro puro 24k com certificação de autenticidade Suíça.', 85500.00, 1),
('Barra de Prata 1kg', 'Barra de Prata 999 para proteção e diversificação de patrimônio.', 4200.00, 2),
('Krugerrand Ouro 1oz', 'A mais famosa moeda de ouro de investimento do mundo, cunhada na África do Sul.', 11200.00, 3);

-- --------------------------------------------------------
-- 4. Estrutura da tabela `mensagem`
-- --------------------------------------------------------
CREATE TABLE `mensagem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `assunto` varchar(150) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `mensagem` (`nome`, `email`, `assunto`, `mensagem`) VALUES
('João Silva', 'joao.silva@email.com', 'Dúvida sobre custódia', 'Olá, gostaria de saber se vocês oferecem serviço de custódia para as barras adquiridas ou se a entrega é apenas física.'),
('Maria Oliveira', 'maria.invest@email.com', 'Cotação para alto volume', 'Tenho interesse em adquirir 3 barras de Ouro de 250g. Vocês aplicam algum desconto institucional para este volume? Fico no aguardo.');