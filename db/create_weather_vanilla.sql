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
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `house_number` smallint(6) DEFAULT NULL,
  `street_name` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `coordinates` point DEFAULT NULL,
  `town_id` mediumint(8) unsigned NOT NULL,
  `town_district_id` char(6) COLLATE utf8mb3_czech_ci NOT NULL,
  `town_district_region_id` char(5) COLLATE utf8mb3_czech_ci NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`,`town_id`,`town_district_id`,`town_district_region_id`,`user_id`),
  UNIQUE KEY `nickname` (`nickname`),
  KEY `fk_location_town1_idx` (`town_id`,`town_district_id`,`town_district_region_id`),
  KEY `fk_location_user1_idx` (`user_id`),
  CONSTRAINT `fk_location_town1` FOREIGN KEY (`town_id`, `town_district_id`, `town_district_region_id`) REFERENCES `town` (`id`, `district_id`, `district_region_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_location_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `region` (
  `id` char(5) COLLATE utf8mb3_czech_ci NOT NULL,
  `region_name` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `town`
--

DROP TABLE IF EXISTS `town`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `town` (
  `id` mediumint(8) unsigned NOT NULL,
  `town_name` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `district_id` char(6) COLLATE utf8mb3_czech_ci NOT NULL,
  `district_region_id` char(5) COLLATE utf8mb3_czech_ci NOT NULL,
  PRIMARY KEY (`id`,`district_id`,`district_region_id`),
  KEY `fk_town_district1_idx` (`district_id`,`district_region_id`),
  CONSTRAINT `fk_town_district1` FOREIGN KEY (`district_id`, `district_region_id`) REFERENCES `district` (`id`, `region_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb3_czech_ci NOT NULL,
  `password` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `first_name` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `account_created` date NOT NULL DEFAULT current_timestamp(),
  `validated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=458 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger user_creation_timestamp
	before insert
    on `user` for each row
begin
 SET NEW.account_created = NOW();
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `weather`
--

DROP TABLE IF EXISTS `weather`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weather` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `temperature` smallint(6) NOT NULL,
  `relative_humidity` decimal(5,2) unsigned NOT NULL,
  `pressure_mb` smallint(5) unsigned NOT NULL,
  `wind_speed_km/h` int(11) NOT NULL,
  `precipitation_mm` float unsigned DEFAULT NULL,
  `precipitation_type` enum('rain','snow','nothing') COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `location_town_id` mediumint(8) unsigned NOT NULL,
  `location_town_district_id` char(6) COLLATE utf8mb3_czech_ci NOT NULL,
  `location_town_district_region_id` char(5) COLLATE utf8mb3_czech_ci NOT NULL,
  `location_user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`,`location_id`,`location_town_id`,`location_town_district_id`,`location_town_district_region_id`,`location_user_id`),
  KEY `fk_weather_location1_idx` (`location_id`,`location_town_id`,`location_town_district_id`,`location_town_district_region_id`,`location_user_id`),
  CONSTRAINT `fk_weather_location1` FOREIGN KEY (`location_id`, `location_town_id`, `location_town_district_id`, `location_town_district_region_id`, `location_user_id`) REFERENCES `location` (`id`, `town_id`, `town_district_id`, `town_district_region_id`, `user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1664 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-28 19:45:51
