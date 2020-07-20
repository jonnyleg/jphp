-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	4.1.11-Debian_4sarge4-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema testej
--

CREATE DATABASE testej;
USE testej;

--
-- Definition of table `pessoas`
--

DROP TABLE IF EXISTS `pessoas`;
CREATE TABLE `pessoas` (
  `idPessoa` int(11) NOT NULL auto_increment,
  `nome` varchar(200) NOT NULL default '',
  `endereco` varchar(255) NOT NULL default '',
  `telefone` varchar(15) default NULL,
  `cidade` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`idPessoa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pessoas`
--

/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
INSERT INTO `pessoas` (`idPessoa`,`nome`,`endereco`,`telefone`,`cidade`) VALUES 
 (1,'José Fulano de Souza','Rua Teste de Endereço, 80','(32) 8744-1122','Cataguases'),
 (2,'Fernando Ciclano Silva','Rua Testando outro endereço, 25','(32) 4125-8795','Cataguases'),
 (3,'Maria Beltrana Camargo','Alameda dos testes, 44','(32) 8744-1124','Leopoldina'),
 (4,'Otacílio Manoel de Souza Testando','Rua Mais um teste, 44','(32) 4125-8744','Leopoldina');
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
