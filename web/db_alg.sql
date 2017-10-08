-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: db_alg
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

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
-- Table structure for table `aml_city`
--

DROP TABLE IF EXISTS `aml_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_city` (
  `cit_id` int(11) NOT NULL AUTO_INCREMENT,
  `cit_cou_id` int(11) NOT NULL,
  `cit_name` varchar(75) NOT NULL,
  `cit_created_date` datetime NOT NULL,
  PRIMARY KEY (`cit_id`),
  KEY `fk_aml_city_cou_idx` (`cit_cou_id`),
  CONSTRAINT `fk_aml_city_cou` FOREIGN KEY (`cit_cou_id`) REFERENCES `aml_country` (`cou_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_city`
--

LOCK TABLES `aml_city` WRITE;
/*!40000 ALTER TABLE `aml_city` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_country`
--

DROP TABLE IF EXISTS `aml_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_country` (
  `cou_id` int(11) NOT NULL AUTO_INCREMENT,
  `cou_name` varchar(100) NOT NULL,
  `cou_created_date` datetime NOT NULL,
  PRIMARY KEY (`cou_id`),
  UNIQUE KEY `cou_name_UNIQUE` (`cou_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_country`
--

LOCK TABLES `aml_country` WRITE;
/*!40000 ALTER TABLE `aml_country` DISABLE KEYS */;
INSERT INTO `aml_country` VALUES (1,'El Salvador','2017-10-08 00:00:00');
/*!40000 ALTER TABLE `aml_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_evaluation_point`
--

DROP TABLE IF EXISTS `aml_evaluation_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_evaluation_point` (
  `evp_id` int(11) NOT NULL AUTO_INCREMENT,
  `evp_name` varchar(45) NOT NULL,
  `evp_status` tinyint(1) NOT NULL DEFAULT '1',
  `evp_created_date` datetime NOT NULL,
  `evp_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`evp_id`),
  UNIQUE KEY `evp_name_UNIQUE` (`evp_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_evaluation_point`
--

LOCK TABLES `aml_evaluation_point` WRITE;
/*!40000 ALTER TABLE `aml_evaluation_point` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_evaluation_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider`
--

DROP TABLE IF EXISTS `aml_provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_name` varchar(45) NOT NULL,
  `pro_address` varchar(250) NOT NULL,
  `pro_cit_id` int(11) NOT NULL,
  `pro_main_phone_number` varchar(45) NOT NULL,
  `pro_site_url` varchar(200) DEFAULT NULL,
  `pro_prg_id` int(11) DEFAULT NULL,
  `pro_prt_id` int(11) NOT NULL,
  `pro_pra_id` int(11) NOT NULL,
  `pro_description` varchar(250) DEFAULT NULL,
  `pro_status` tinyint(1) NOT NULL DEFAULT '1',
  `pro_created_date` datetime NOT NULL,
  `pro_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`pro_id`),
  UNIQUE KEY `pro_name_UNIQUE` (`pro_name`),
  KEY `FK_provider_afiliation` (`pro_pra_id`),
  KEY `FK_provider_group` (`pro_prg_id`),
  KEY `FK_provider_type` (`pro_prt_id`),
  CONSTRAINT `FK_provider_afiliation` FOREIGN KEY (`pro_pra_id`) REFERENCES `aml_provider_afiliation` (`pra_id`),
  CONSTRAINT `FK_provider_group` FOREIGN KEY (`pro_prg_id`) REFERENCES `aml_provider_group` (`prg_id`),
  CONSTRAINT `FK_provider_type` FOREIGN KEY (`pro_prt_id`) REFERENCES `aml_provider_type` (`prt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider`
--

LOCK TABLES `aml_provider` WRITE;
/*!40000 ALTER TABLE `aml_provider` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_afiliation`
--

DROP TABLE IF EXISTS `aml_provider_afiliation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_afiliation` (
  `pra_id` int(11) NOT NULL AUTO_INCREMENT,
  `pra_name` varchar(45) NOT NULL,
  `pra_description` varchar(200) DEFAULT NULL,
  `pra_status` tinyint(1) NOT NULL DEFAULT '1',
  `pra_created_date` datetime NOT NULL,
  `pra_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`pra_id`),
  UNIQUE KEY `afi_name_UNIQUE` (`pra_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_afiliation`
--

LOCK TABLES `aml_provider_afiliation` WRITE;
/*!40000 ALTER TABLE `aml_provider_afiliation` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_afiliation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_contact`
--

DROP TABLE IF EXISTS `aml_provider_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_contact` (
  `prc_id` int(11) NOT NULL AUTO_INCREMENT,
  `prc_name` varchar(75) NOT NULL,
  `prc_phone_number` varchar(25) NOT NULL,
  `prc_job_title` varchar(50) NOT NULL,
  `prc_email` varchar(175) NOT NULL,
  `prc_created_date` datetime NOT NULL,
  `prc_updated_date` datetime DEFAULT NULL,
  `prc_pro_id` int(11) NOT NULL,
  PRIMARY KEY (`prc_id`),
  KEY `FK_provider_contact_provider` (`prc_pro_id`),
  CONSTRAINT `FK_provider_contact_provider` FOREIGN KEY (`prc_pro_id`) REFERENCES `aml_provider` (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_contact`
--

LOCK TABLES `aml_provider_contact` WRITE;
/*!40000 ALTER TABLE `aml_provider_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_eval_score`
--

DROP TABLE IF EXISTS `aml_provider_eval_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_eval_score` (
  `pes_id` int(11) NOT NULL AUTO_INCREMENT,
  `pes_pre_id` int(11) NOT NULL,
  `pes_evp_id` int(11) NOT NULL,
  `pes_score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pes_id`),
  KEY `FK_pes_evp` (`pes_evp_id`),
  KEY `FK_pes_pre` (`pes_pre_id`),
  CONSTRAINT `FK_pes_evp` FOREIGN KEY (`pes_evp_id`) REFERENCES `aml_evaluation_point` (`evp_id`),
  CONSTRAINT `FK_pes_pre` FOREIGN KEY (`pes_pre_id`) REFERENCES `aml_provider_evaluation` (`pre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_eval_score`
--

LOCK TABLES `aml_provider_eval_score` WRITE;
/*!40000 ALTER TABLE `aml_provider_eval_score` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_eval_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_evaluation`
--

DROP TABLE IF EXISTS `aml_provider_evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_evaluation` (
  `pre_id` int(11) NOT NULL AUTO_INCREMENT,
  `pre_pro_id` int(11) NOT NULL,
  `pre_use_id` int(11) NOT NULL,
  `pre_date` datetime NOT NULL,
  PRIMARY KEY (`pre_id`),
  KEY `FK_pre_provider` (`pre_pro_id`),
  KEY `FK_pre_user` (`pre_use_id`),
  CONSTRAINT `FK_pre_provider` FOREIGN KEY (`pre_pro_id`) REFERENCES `aml_provider` (`pro_id`),
  CONSTRAINT `FK_pre_user` FOREIGN KEY (`pre_use_id`) REFERENCES `aml_user` (`use_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_evaluation`
--

LOCK TABLES `aml_provider_evaluation` WRITE;
/*!40000 ALTER TABLE `aml_provider_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_feedback`
--

DROP TABLE IF EXISTS `aml_provider_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_feedback` (
  `prf_id` int(11) NOT NULL AUTO_INCREMENT,
  `prf_pro_id` int(11) NOT NULL,
  `prf_use_id` int(11) NOT NULL,
  `prf_date` datetime NOT NULL,
  `prf_comment` longtext NOT NULL,
  PRIMARY KEY (`prf_id`),
  KEY `FK_prf_pro_id` (`prf_pro_id`),
  KEY `FK_prf_use_id` (`prf_use_id`),
  CONSTRAINT `FK_prf_pro_id` FOREIGN KEY (`prf_pro_id`) REFERENCES `aml_provider` (`pro_id`),
  CONSTRAINT `FK_prf_use_id` FOREIGN KEY (`prf_use_id`) REFERENCES `aml_user` (`use_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_feedback`
--

LOCK TABLES `aml_provider_feedback` WRITE;
/*!40000 ALTER TABLE `aml_provider_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_group`
--

DROP TABLE IF EXISTS `aml_provider_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_group` (
  `prg_id` int(11) NOT NULL AUTO_INCREMENT,
  `prg_name` varchar(45) NOT NULL,
  `prg_status` tinyint(1) NOT NULL DEFAULT '1',
  `prg_created_at` datetime NOT NULL,
  `prg_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`prg_id`),
  UNIQUE KEY `prg_name_UNIQUE` (`prg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_group`
--

LOCK TABLES `aml_provider_group` WRITE;
/*!40000 ALTER TABLE `aml_provider_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_service`
--

DROP TABLE IF EXISTS `aml_provider_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_service` (
  `prs_id` int(11) NOT NULL AUTO_INCREMENT,
  `prs_pro_id` int(11) NOT NULL,
  `prs_ser_id` int(11) NOT NULL,
  `prs_status` tinyint(1) NOT NULL DEFAULT '1',
  `prs_created_date` datetime NOT NULL,
  `prs_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`prs_id`),
  KEY `FK_provider_service` (`prs_ser_id`),
  KEY `FK_provider_provider` (`prs_pro_id`),
  CONSTRAINT `FK_provider_provider` FOREIGN KEY (`prs_pro_id`) REFERENCES `aml_provider` (`pro_id`),
  CONSTRAINT `FK_provider_service` FOREIGN KEY (`prs_ser_id`) REFERENCES `aml_service` (`ser_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_service`
--

LOCK TABLES `aml_provider_service` WRITE;
/*!40000 ALTER TABLE `aml_provider_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_provider_type`
--

DROP TABLE IF EXISTS `aml_provider_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_provider_type` (
  `prt_id` int(11) NOT NULL AUTO_INCREMENT,
  `prt_name` varchar(45) NOT NULL,
  `prt_description` varchar(100) NOT NULL,
  `prt_status` tinyint(1) NOT NULL DEFAULT '1',
  `prt_created_date` datetime NOT NULL,
  `prt_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`prt_id`),
  UNIQUE KEY `prt_name_UNIQUE` (`prt_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_provider_type`
--

LOCK TABLES `aml_provider_type` WRITE;
/*!40000 ALTER TABLE `aml_provider_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_provider_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_rol`
--

DROP TABLE IF EXISTS `aml_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_rol` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_name` varchar(20) NOT NULL,
  `rol_status` tinyint(1) NOT NULL DEFAULT '1',
  `rol_created_date` datetime NOT NULL,
  `rol_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `rol_name_UNIQUE` (`rol_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_rol`
--

LOCK TABLES `aml_rol` WRITE;
/*!40000 ALTER TABLE `aml_rol` DISABLE KEYS */;
INSERT INTO `aml_rol` VALUES (1,'ROLE_ADMIN',1,'2017-10-08 00:00:00',NULL),(2,'ROLE_USER',1,'2017-10-08 00:00:00',NULL);
/*!40000 ALTER TABLE `aml_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_service`
--

DROP TABLE IF EXISTS `aml_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_service` (
  `ser_id` int(11) NOT NULL AUTO_INCREMENT,
  `ser_name` varchar(45) NOT NULL,
  `ser_status` tinyint(1) NOT NULL DEFAULT '1',
  `ser_created_date` datetime NOT NULL,
  `ser_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`ser_id`),
  UNIQUE KEY `ser_name_UNIQUE` (`ser_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_service`
--

LOCK TABLES `aml_service` WRITE;
/*!40000 ALTER TABLE `aml_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `aml_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_station`
--

DROP TABLE IF EXISTS `aml_station`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_station` (
  `sta_id` int(11) NOT NULL AUTO_INCREMENT,
  `sta_name` varchar(45) NOT NULL,
  `sta_created_date` datetime NOT NULL,
  PRIMARY KEY (`sta_id`),
  UNIQUE KEY `sta_name_UNIQUE` (`sta_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_station`
--

LOCK TABLES `aml_station` WRITE;
/*!40000 ALTER TABLE `aml_station` DISABLE KEYS */;
INSERT INTO `aml_station` VALUES (1,'Station 1','2017-10-08 00:00:00');
/*!40000 ALTER TABLE `aml_station` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aml_user`
--

DROP TABLE IF EXISTS `aml_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aml_user` (
  `use_id` int(11) NOT NULL AUTO_INCREMENT,
  `use_name` varchar(45) NOT NULL,
  `use_password` varchar(150) NOT NULL,
  `use_status` tinyint(1) NOT NULL DEFAULT '1',
  `use_rol_id` int(11) NOT NULL,
  `use_email` varchar(150) NOT NULL,
  `use_phone_number` varchar(45) DEFAULT NULL,
  `use_cou_id` int(11) NOT NULL,
  `use_sta_id` int(11) NOT NULL,
  PRIMARY KEY (`use_id`),
  UNIQUE KEY `use_name_UNIQUE` (`use_name`),
  UNIQUE KEY `use_email_UNIQUE` (`use_email`),
  KEY `FK_user_role` (`use_rol_id`),
  KEY `FK_user_country` (`use_cou_id`),
  KEY `FK_user_station` (`use_sta_id`),
  CONSTRAINT `FK_user_country` FOREIGN KEY (`use_cou_id`) REFERENCES `aml_country` (`cou_id`),
  CONSTRAINT `FK_user_role` FOREIGN KEY (`use_rol_id`) REFERENCES `aml_rol` (`rol_id`),
  CONSTRAINT `FK_user_station` FOREIGN KEY (`use_sta_id`) REFERENCES `aml_station` (`sta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aml_user`
--

LOCK TABLES `aml_user` WRITE;
/*!40000 ALTER TABLE `aml_user` DISABLE KEYS */;
INSERT INTO `aml_user` VALUES (1,'cubias','$2y$12$e0dtMubkAz1aFhgyoiYQ/eQd9MQRrdyXiN605zeIAEGjACoEMzJQq',1,1,'cubiascaceres@gmail.com','(503)7985-1748',1,1);
/*!40000 ALTER TABLE `aml_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-08 12:29:28
