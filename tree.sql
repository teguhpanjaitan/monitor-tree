-- MySQL dump 10.13  Distrib 8.0.18, for macos10.14 (x86_64)
--
-- Host: localhost    Database: tree
-- ------------------------------------------------------
-- Server version	5.7.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `desc_level`
--

DROP TABLE IF EXISTS `desc_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `desc_level` (
  `ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `level_id` tinyint(1) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `desc_level`
--

LOCK TABLES `desc_level` WRITE;
/*!40000 ALTER TABLE `desc_level` DISABLE KEYS */;
INSERT INTO `desc_level` VALUES (1,1,'Administrator',0),(2,2,'User',0);
/*!40000 ALTER TABLE `desc_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_pohon`
--

DROP TABLE IF EXISTS `jenis_pohon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_pohon` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `meter_per_month` float NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_pohon`
--

LOCK TABLES `jenis_pohon` WRITE;
/*!40000 ALTER TABLE `jenis_pohon` DISABLE KEYS */;
INSERT INTO `jenis_pohon` VALUES (1,'akasia',0.3,0),(2,'sdfsd',3,1),(3,'86jjj',2,0);
/*!40000 ALTER TABLE `jenis_pohon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `point`
--

DROP TABLE IF EXISTS `point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `point` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_jenis_pohon` int(10) NOT NULL,
  `segmen` varchar(100) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `tinggi` float NOT NULL DEFAULT '0',
  `latitude` double NOT NULL DEFAULT '0',
  `longitude` double NOT NULL DEFAULT '0',
  `tiang1` varchar(255) DEFAULT '',
  `tiang2` varchar(255) DEFAULT '',
  `bentangan` float NOT NULL DEFAULT '0',
  `penanganan` varchar(255) DEFAULT '',
  `keterangan` VARCHAR(1020) DEFAULT '',
  `image` varchar(255) DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `point`
--

LOCK TABLES `point` WRITE;
/*!40000 ALTER TABLE `point` DISABLE KEYS */;
INSERT INTO `point` VALUES (1,1,'segmen-5','2019-12-06',1,2,5,0.671621276,99.704031779,'',0),(7,1,'SEGMENT-YB.03-MAIN41-SAYUR MAINCAT 1','2019-12-06',55,55,50,0.671492539,99.704139067,'',0),(8,1,'segmen-a10','2010-03-20',35,35,55,0.8223488,0.732999,'Screen Shot 2020-03-18 at 11.15.37.png',0);
/*!40000 ALTER TABLE `point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `ID` smallint(5) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(500) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level` tinyint(1) DEFAULT '2',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Teguh putra utama ST','teguh','$2y$10$Erg6F.2kIeO50ax5oKvrDOiZwrjWXSJlUnqOOk.j9YxSP6eGba6WW',1,1),(12,'Tama testing','tamapnj','$2y$10$kPqArrL/xXNJu.rl925PYeiQBmr.UGbxqaaZtBnIOHdh9k2rrxX4m',1,1),(13,'tama teging','tama123','$2y$10$xIMGMkwoEJVvmWO8e/KoL.AelnVfzK/5KKxzSDEO0IkcdpMYAHeu2',1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-19  9:04:43
