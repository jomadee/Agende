/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela gostinho.ll_agende_organizadores
CREATE TABLE IF NOT EXISTS `ll_agende_organizadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(256) NOT NULL,
  `logo` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela gostinho.ll_agende_programacao
CREATE TABLE IF NOT EXISTS `ll_agende_programacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(50) NOT NULL,
  `titulo` varchar(256) NOT NULL,
  `img` varchar(150) DEFAULT NULL,
  `descricao` text,
  `endereco` varchar(256) NOT NULL,
  `organizador` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `organizador` (`organizador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
