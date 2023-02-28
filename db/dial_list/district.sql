-- MariaDB dump 10.19  Distrib 10.6.5-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: weather_v5
-- ------------------------------------------------------
-- Server version	10.6.5-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `id` char(6) COLLATE utf8mb3_czech_ci NOT NULL,
  `district_name` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `region_id` char(5) COLLATE utf8mb3_czech_ci NOT NULL,
  PRIMARY KEY (`id`,`region_id`),
  KEY `fk_district_region1_idx` (`region_id`),
  CONSTRAINT `fk_district_region1` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES ('CZ0100','Hlavní město Praha','CZ010'),('CZ0201','Benešov','CZ020'),('CZ0202','Beroun','CZ020'),('CZ0203','Kladno','CZ020'),('CZ0204','Kolín','CZ020'),('CZ0205','Kutná Hora','CZ020'),('CZ0206','Mělník','CZ020'),('CZ0207','Mladá Boleslav','CZ020'),('CZ0208','Nymburk','CZ020'),('CZ0209','Praha-východ','CZ020'),('CZ020A','Praha-západ','CZ020'),('CZ020B','Příbram','CZ020'),('CZ020C','Rakovník','CZ020'),('CZ0311','České Budějovice','CZ031'),('CZ0312','Český Krumlov','CZ031'),('CZ0313','Jindřichův Hradec','CZ031'),('CZ0314','Písek','CZ031'),('CZ0315','Prachatice','CZ031'),('CZ0316','Strakonice','CZ031'),('CZ0317','Tábor','CZ031'),('CZ0321','Domažlice','CZ032'),('CZ0322','Klatovy','CZ032'),('CZ0323','Plzeň-město','CZ032'),('CZ0324','Plzeň-jih','CZ032'),('CZ0325','Plzeň-sever','CZ032'),('CZ0326','Rokycany','CZ032'),('CZ0327','Tachov','CZ032'),('CZ0411','Cheb','CZ041'),('CZ0412','Karlovy Vary','CZ041'),('CZ0413','Sokolov','CZ041'),('CZ0421','Děčín','CZ042'),('CZ0422','Chomutov','CZ042'),('CZ0423','Litoměřice','CZ042'),('CZ0424','Louny','CZ042'),('CZ0425','Most','CZ042'),('CZ0426','Teplice','CZ042'),('CZ0427','Ústí nad Labem','CZ042'),('CZ0511','Česká Lípa','CZ051'),('CZ0512','Jablonec nad Nisou','CZ051'),('CZ0513','Liberec','CZ051'),('CZ0514','Semily','CZ051'),('CZ0521','Hradec Králové','CZ052'),('CZ0522','Jičín','CZ052'),('CZ0523','Náchod','CZ052'),('CZ0524','Rychnov nad Kněžnou','CZ052'),('CZ0525','Trutnov','CZ052'),('CZ0531','Chrudim','CZ053'),('CZ0532','Pardubice','CZ053'),('CZ0533','Svitavy','CZ053'),('CZ0534','Ústí nad Orlicí','CZ053'),('CZ0631','Havlíčkův Brod','CZ061'),('CZ0632','Jihlava','CZ061'),('CZ0633','Pelhřimov','CZ061'),('CZ0634','Třebíč','CZ061'),('CZ0635','Žďár nad Sázavou','CZ061'),('CZ0641','Blansko','CZ062'),('CZ0642','Brno-město','CZ062'),('CZ0643','Brno-venkov','CZ062'),('CZ0644','Břeclav','CZ062'),('CZ0645','Hodonín','CZ062'),('CZ0646','Vyškov','CZ062'),('CZ0647','Znojmo','CZ062'),('CZ0711','Jeseník','CZ071'),('CZ0712','Olomouc','CZ071'),('CZ0713','Prostějov','CZ071'),('CZ0714','Přerov','CZ071'),('CZ0715','Šumperk','CZ071'),('CZ0721','Kroměříž','CZ072'),('CZ0722','Uherské Hradiště','CZ072'),('CZ0723','Vsetín','CZ072'),('CZ0724','Zlín','CZ072'),('CZ0801','Bruntál','CZ080'),('CZ0802','Frýdek-Místek','CZ080'),('CZ0803','Karviná','CZ080'),('CZ0804','Nový Jičín','CZ080'),('CZ0805','Opava','CZ080'),('CZ0806','Ostrava-město','CZ080');
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-28 19:47:00
