-- --------------------------------------------------------
-- Servidor:                     padraotorrent.com
-- Versão do servidor:           5.7.28-cll-lve - MySQL Community Server - (GPL)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela padraoto_magento.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela padraoto_magento.admin: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `email`, `senha`) VALUES
	(1, 'pyxissoftware@outlook.com', '6a529b7ee743ff9b83d41019eee93dd1');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Copiando estrutura para tabela padraoto_magento.planos
CREATE TABLE IF NOT EXISTS `planos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(20) NOT NULL,
  `descricao` text NOT NULL,
  `valor` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


-- Copiando estrutura para tabela padraoto_magento.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `endereco` text NOT NULL,
  `telefone` text NOT NULL,
  `descricao` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `tokken_api` text NOT NULL,
  `dias_venc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



-- Copiando estrutura para tabela padraoto_magento.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `plano` int(11) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  `senha` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cel_principal` varchar(20) NOT NULL,
  `cel_secundario` varchar(20) DEFAULT NULL,
  `endereco` varchar(100) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `dia_pagamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_plano` (`plano`),
  CONSTRAINT `fk_id_plano` FOREIGN KEY (`plano`) REFERENCES `planos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;


-- Copiando estrutura para tabela padraoto_magento.fatura
CREATE TABLE IF NOT EXISTS `fatura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lancamento` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `vencimento` varchar(50) NOT NULL,
  `valor` float NOT NULL,
  `idCliente` int(11) NOT NULL,
  `link` varchar(2048) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_cliente_fatura` (`idCliente`),
  CONSTRAINT `fk_id_cliente_fatura` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;


-- Copiando estrutura para tabela padraoto_magento.info_empresa
CREATE TABLE IF NOT EXISTS `info_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(20) NOT NULL,
  `desc_empresa` text NOT NULL,
  `endereco_empresa` varchar(100) NOT NULL,
  `cidade_empresa` varchar(30) NOT NULL,
  `tel_empresa` varchar(20) NOT NULL,
  `cel_empresa` varchar(20) DEFAULT NULL,
  `email_empresa` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando estrutura para tabela padraoto_magento.mural
CREATE TABLE IF NOT EXISTS `mural` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;


-- Copiando estrutura para tabela padraoto_magento.notificacao
CREATE TABLE IF NOT EXISTS `notificacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCliente` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_cliente_not` (`idCliente`),
  CONSTRAINT `fk_id_cliente_not` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela padraoto_magento.settings: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `endereco`, `telefone`, `descricao`, `email`, `tokken_api`, `dias_venc`) VALUES
	(1, 'Rua Ubaldo de SÃ¡, 566, Divino E. Santo', '87981071497', 'DescriÃ§Ã£o de teste', 'emersonmessoribeiro@gmail.com', 'TEST-3859115197274286-100215-b089d448887a9894c2ec2738b018c7a3-177075515', 5);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
