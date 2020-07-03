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
-- Table structure for table `eksekusi`
--

DROP TABLE IF EXISTS `eksekusi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eksekusi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_inspeksi` int(10) NOT NULL,
  `tanggal_eksekusi` datetime NOT NULL,
  `metode_rintis` varchar(255) DEFAULT NULL,
  `bentangan_pohon` float NOT NULL,
  `eksekusi_selanjutnya` datetime NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eksekusi`
--

LOCK TABLES `eksekusi` WRITE;
/*!40000 ALTER TABLE `eksekusi` DISABLE KEYS */;
/*!40000 ALTER TABLE `eksekusi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inspeksi`
--

DROP TABLE IF EXISTS `inspeksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inspeksi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_jenis_pohon` int(10) NOT NULL,
  `segmen` varchar(255) DEFAULT NULL,
  `tanggal_inspeksi` date NOT NULL,
  `tinggi_pengukuran` float DEFAULT '0',
  `tinggi` float DEFAULT '0',
  `latitude` double NOT NULL DEFAULT '0',
  `longitude` double NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT '',
  `tiang1` varchar(255) DEFAULT '',
  `tiang2` varchar(255) DEFAULT '',
  `jarak_hutm_terdekat` float DEFAULT '0',
  `rekomendasi_penanganan` varchar(255) DEFAULT '',
  `ujung_pohon` varchar(255) DEFAULT NULL,
  `keterangan` varchar(1020) DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inspeksi`
--

LOCK TABLES `inspeksi` WRITE;
/*!40000 ALTER TABLE `inspeksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `inspeksi` ENABLE KEYS */;
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
  `meter_per_month` float DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_pohon`
--

LOCK TABLES `jenis_pohon` WRITE;
/*!40000 ALTER TABLE `jenis_pohon` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_pohon` ENABLE KEYS */;
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

-- Dump completed on 2020-07-03  7:03:05
