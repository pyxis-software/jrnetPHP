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

-- Copiando dados para a tabela padraoto_magento.cliente: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`id`, `nome`, `cpf`, `plano`, `ativo`, `senha`, `email`, `cel_principal`, `cel_secundario`, `endereco`, `cidade`, `dia_pagamento`) VALUES
	(1, 'Emerson Ribeiro Dos Santos', '108.103.094-16', 6, 1, 'bcc26970425d076d1e9fe42f2a0d2dfc', 'emersonmessoribeiro@gmail.com', '(87)98107-1497', '(87)99946-1893', 'Rua Ubaldo De Sa, 566', 'Salgueiro-PE', 21),
	(2, 'Maria Tatiane', '107.617.664-05', 1, 1, '159657535d5dc4a3fb14e4729822bf4c', 'tati.me94@gmail.com', '(87)98116-6231', NULL, 'Fazenda Destino', 'Terra Nova-PE', 16),
	(3, 'Teste', '111.111.111-11', 6, 1, 'e10adc3949ba59abbe56e057f20f883e', 'jeffersonbds_barros@hotmail.com', '(87)99999-9999', NULL, 'Rua nao sei, 0', 'Salgueiro-PE', 21),
	(13, 'emerson', '220.479.994-72', 1, 1, '159657535d5dc4a3fb14e4729822bf4c', 'emersonmessoribeiro@gmail.com', '(87)99946-1893', NULL, 'Rua ubaldo de sa, 566 Divino espirito santo', 'Salgueiro-PE', 2);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

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

-- Copiando dados para a tabela padraoto_magento.fatura: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `fatura` DISABLE KEYS */;
INSERT INTO `fatura` (`id`, `lancamento`, `status`, `payment_id`, `vencimento`, `valor`, `idCliente`, `link`, `barcode`) VALUES
	(3, '1574276412', 'approved', '22729066', '27/11/2019', 44.99, 13, 'https://www.mercadopago.com/mlb/payments/sandbox/ticket/helper?payment_id=22729066&payment_method_reference_id=22729067&caller_id=228230732&hash=59a87c5e-dff9-4130-92f9-884aac994bd8', '23792808600000044993380260002272906700633330'),
	(9, '1574370356', 'pending', '22753593', '26/11/2019', 44.99, 2, 'https://www.mercadopago.com/mlb/payments/sandbox/ticket/helper?payment_id=22753593&payment_method_reference_id=22753592&caller_id=478371464&hash=13d35a10-cc37-47bb-b395-6a98729a0562', '23791808500000044993380260002275359200633330'),
	(10, '1574372752', 'pending', '22754277', '26/11/2019', 44.99, 1, 'https://www.mercadopago.com/mlb/payments/sandbox/ticket/helper?payment_id=22754277&payment_method_reference_id=22754276&caller_id=228230732&hash=ed7c2d38-ad30-425c-bc53-27486b4198e2', '23795808500000044993380260002275427600633330'),
	(11, '1574527374', 'pending', '22780627', '04/12/2019', 109.99, 3, 'https://www.mercadopago.com/mlb/payments/sandbox/ticket/helper?payment_id=22780627&payment_method_reference_id=22780628&caller_id=478610285&hash=7a86313b-7e22-4068-82e5-74bac9d2d3a2', '23799809300000109993380260002278062800633330'),
	(12, '1574532587', 'approved', '22780926', '26/11/2019', 109.99, 3, 'https://www.mercadopago.com/mlb/payments/sandbox/ticket/helper?payment_id=22780926&payment_method_reference_id=22780927&caller_id=478610285&hash=0a3f8c21-4b29-4bf0-9b2a-c85ee303b2aa', '23796808500000109993380260002278092700633330'),
	(13, '1574532637', 'pending', '22780934', '23/11/2019', 109.99, 3, 'https://www.mercadopago.com/mlb/payments/sandbox/ticket/helper?payment_id=22780934&payment_method_reference_id=22780933&caller_id=478610285&hash=53dfdf43-01c7-4995-b8fb-54324542c3d5', '23794808200000109993380260002278093300633330');
/*!40000 ALTER TABLE `fatura` ENABLE KEYS */;

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

-- Copiando dados para a tabela padraoto_magento.info_empresa: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `info_empresa` DISABLE KEYS */;
INSERT INTO `info_empresa` (`id`, `nome_empresa`, `desc_empresa`, `endereco_empresa`, `cidade_empresa`, `tel_empresa`, `cel_empresa`, `email_empresa`) VALUES
	(1, 'Junior Net', '', 'Rua de Umas', 'Salgueiro', '(87)8888-8888', '(87)98888-8888', 'email@empresa.com');
/*!40000 ALTER TABLE `info_empresa` ENABLE KEYS */;

-- Copiando estrutura para tabela padraoto_magento.mural
CREATE TABLE IF NOT EXISTS `mural` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela padraoto_magento.mural: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `mural` DISABLE KEYS */;
INSERT INTO `mural` (`id`, `titulo`, `descricao`) VALUES
	(32, 'ManutenÃƒÂ§ÃƒÂ£o', 'ManutenÃƒÂ§ÃƒÂ£o programada para o dia 23 deste mÃƒÂªs para atualizaÃƒÂ§ÃƒÂ£o dos nossos servidores de internet! Grato a todos pela compreensÃƒÂ£o.');
/*!40000 ALTER TABLE `mural` ENABLE KEYS */;

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

-- Copiando dados para a tabela padraoto_magento.notificacao: ~13 rows (aproximadamente)
/*!40000 ALTER TABLE `notificacao` DISABLE KEYS */;
INSERT INTO `notificacao` (`id`, `idCliente`, `tipo`, `msg`) VALUES
	(10, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(11, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(12, 13, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(13, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(14, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(15, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(16, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(17, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(18, 2, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(19, 1, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(20, 3, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(21, 3, 0, 'Fatura de Novembro de 2019 disponÃ­vel!'),
	(22, 3, 0, 'Fatura de Novembro de 2019 disponÃ­vel!');
/*!40000 ALTER TABLE `notificacao` ENABLE KEYS */;

-- Copiando estrutura para tabela padraoto_magento.planos
CREATE TABLE IF NOT EXISTS `planos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(20) NOT NULL,
  `descricao` text NOT NULL,
  `valor` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela padraoto_magento.planos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `planos` DISABLE KEYS */;
INSERT INTO `planos` (`id`, `titulo`, `descricao`, `valor`) VALUES
	(1, 'Plano Residencial', 'Plano de Internet residencial com 50Mb de internet, ideal para navegaÃƒÂ§ÃƒÂ£o em sites e redes sociais, jogos e assistir online.', 44.99),
	(6, 'Plano Empresarial', 'Plano empresarial com internet FIBRA ÃƒÂ“PTICA com velocidade de 220Mb, ideal para sua empresa estar sempre conectada ÃƒÂ  internet.', 109.99),
	(7, '500Mbps', 'Teste', 599.9);
/*!40000 ALTER TABLE `planos` ENABLE KEYS */;

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

-- Copiando dados para a tabela padraoto_magento.settings: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `endereco`, `telefone`, `descricao`, `email`, `tokken_api`, `dias_venc`) VALUES
	(1, 'Rua Ubaldo de SÃ¡, 566, Divino E. Santo', '87981071497', 'DescriÃ§Ã£o de teste', 'emersonmessoribeiro@gmail.com', 'TEST-3859115197274286-100215-b089d448887a9894c2ec2738b018c7a3-177075515', 5);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
