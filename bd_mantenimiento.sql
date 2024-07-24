CREATE DATABASE  IF NOT EXISTS `bd_mantenimiento` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bd_mantenimiento`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: bd_mantenimiento
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_rep` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'MANTENIMIENTO CORRECTIVO','2024-04-09 09:04:02',NULL),(2,'MANTENIMIENTO PREVENTIVO','2024-04-09 09:04:02',NULL),(3,'MANTENIMIENTO PREDICTIVO','2024-04-09 09:04:02',NULL),(4,'MECANIZADO','2024-04-09 09:04:02',NULL),(5,'MATERIALES, INSUMOS Y REPUESTOS ADICIONALES','2024-04-09 09:04:02',NULL),(6,'SERVICIO','2024-04-09 09:04:02',NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_i_categorias` BEFORE INSERT ON `categorias` FOR EACH ROW BEGIN
  SET new.created_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_u_categorias` BEFORE UPDATE ON `categorias` FOR EACH ROW BEGIN
  SET new.updated_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_d_categorias` BEFORE DELETE ON `categorias` FOR EACH ROW BEGIN
  INSERT INTO log_categorias_rep VALUES (OLD.id,OLD.categoria_rep,OLD.created_at,now(),system_user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detalles_mantenimiento`
--

DROP TABLE IF EXISTS `detalles_mantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalles_mantenimiento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) DEFAULT NULL,
  `costo` double NOT NULL,
  `mantenimientos_id` int NOT NULL,
  `reparaciones_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_mantenimiento_mantenimiento1_idx` (`mantenimientos_id`),
  KEY `fk_detalle_mantenimiento_reparaciones1_idx` (`reparaciones_id`),
  CONSTRAINT `fk_detalle_mantenimiento_mantenimiento1` FOREIGN KEY (`mantenimientos_id`) REFERENCES `mantenimientos` (`id`),
  CONSTRAINT `fk_detalle_mantenimiento_reparaciones1` FOREIGN KEY (`reparaciones_id`) REFERENCES `reparaciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalles_mantenimiento`
--

LOCK TABLES `detalles_mantenimiento` WRITE;
/*!40000 ALTER TABLE `detalles_mantenimiento` DISABLE KEYS */;
INSERT INTO `detalles_mantenimiento` VALUES (1,'',45,29,8,'2024-03-07 11:48:43','2024-04-09 17:13:04'),(2,'',123.23,29,9,'2024-03-07 11:48:43','2024-04-09 17:13:04'),(3,'',78,29,7,'2024-03-07 11:48:43','2024-04-09 17:13:04'),(4,'',34,29,6,'2024-03-07 15:13:48','2024-04-09 17:13:04'),(5,'',98,29,3,'2024-03-07 15:13:48','2024-04-09 17:13:04'),(6,'',123,25,4,'2024-03-07 15:42:24','2024-04-09 17:13:16'),(7,'',13,28,7,'2024-03-07 15:43:52','2024-04-09 17:13:10'),(8,'',234,28,8,'2024-03-07 15:43:52','2024-04-09 17:13:10'),(9,'',123,28,12,'2024-03-07 15:43:52','2024-04-09 17:13:10'),(10,'',12,28,10,'2024-03-07 15:43:52','2024-04-09 17:13:10'),(11,'',666.5,29,5,'2024-03-07 15:44:13','2024-04-09 17:13:04'),(12,'',21232.57,29,2,'2024-03-07 15:44:13','2024-04-09 17:13:04'),(13,'',54,29,4,'2024-03-07 17:03:10','2024-04-09 17:13:04'),(20,'',89898,1,4,'2024-03-08 22:51:11','2024-05-20 09:41:10'),(23,'',2323,32,1,'2024-03-12 17:21:12','2024-04-09 17:12:58'),(24,'',2000,32,8,'2024-03-12 17:21:12','2024-04-09 17:12:58'),(25,'pruebassdfs',21312.01,33,4,'2024-03-13 09:33:42','2024-04-02 11:53:23'),(27,'',12312,33,3,'2024-03-13 09:33:42','2024-04-02 11:53:23'),(28,NULL,123,24,3,'2024-03-13 09:36:40','2024-03-13 14:36:40'),(29,'',76,25,1,'2024-03-13 09:37:03','2024-04-09 17:13:16'),(30,'',76567.3,33,1,'2024-03-15 14:53:47','2024-04-02 11:53:23'),(32,'',234,33,6,'2024-03-15 14:53:47','2024-04-02 11:53:23'),(34,'',21312.55,33,8,'2024-03-15 14:53:47','2024-04-02 11:53:23'),(35,'',23432,33,9,'2024-03-15 14:53:47','2024-04-02 11:53:23'),(36,'',3242,33,10,'2024-03-15 14:53:47','2024-04-02 11:53:23'),(37,'',342342,33,11,'2024-03-15 14:53:47','2024-04-02 11:53:23'),(38,'',3345,33,12,'2024-03-15 14:53:47','2024-04-02 11:53:23'),(40,NULL,12312,15,4,'2024-03-22 16:32:57','2024-03-22 16:32:57'),(41,NULL,12,13,4,'2024-03-22 16:33:15','2024-03-22 16:33:15'),(42,NULL,23423,13,3,'2024-03-22 16:33:15','2024-03-22 16:33:15'),(43,NULL,234,8,4,'2024-03-22 16:33:40','2024-03-22 16:33:40'),(44,NULL,23432,8,1,'2024-03-22 16:33:40','2024-03-22 16:33:40'),(45,'Ejemplo',666.66,16,7,'2024-03-25 11:56:10','2024-04-02 10:46:56'),(46,'LIMPIEZA',21345,34,13,'2024-04-02 11:55:05','2024-04-18 09:08:47'),(47,'REPUEST',2343,34,11,'2024-04-03 09:50:09','2024-04-18 09:28:05'),(48,'asdas',21312,23,11,'2024-04-12 10:13:21','2024-04-12 10:13:21'),(51,'asdasasdsasda',2321,37,9,'2024-04-18 10:27:15','2024-04-18 10:27:15'),(52,'asdasd',231423,37,2,'2024-04-18 10:27:15','2024-04-18 10:27:15'),(53,'isjfbiasjd',28731,27,9,'2024-04-22 09:27:56','2024-04-22 09:27:56'),(54,'',231,38,1,'2024-04-23 15:19:23','2024-04-23 15:19:23'),(55,'',23,25,11,'2024-04-23 16:02:30','2024-04-23 16:02:30'),(56,'sdf',123,39,1,'2024-04-23 17:18:02','2024-04-23 17:18:14'),(57,'qeqwe',23423,39,9,'2024-04-23 17:18:02','2024-04-23 17:18:02'),(59,'xdfsdsa',234,40,1,'2024-04-23 17:21:35','2024-04-26 10:41:59'),(61,'',234,41,4,'2024-04-26 11:09:20','2024-04-26 11:09:20'),(64,'Servicio',345,1,14,'2024-05-20 09:41:10','2024-05-20 09:41:10'),(65,'ola',495,43,9,'2024-05-20 10:04:15','2024-05-20 10:04:15'),(66,'ole',625,43,2,'2024-05-20 10:04:15','2024-05-20 10:04:15'),(67,'dsfsds',123123,43,1,'2024-07-18 18:20:02','2024-07-18 18:20:02'),(68,'1231|',1231,43,5,'2024-07-18 18:20:02','2024-07-18 18:20:02');
/*!40000 ALTER TABLE `detalles_mantenimiento` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_i_detalles_mantenimiento` BEFORE INSERT ON `detalles_mantenimiento` FOR EACH ROW BEGIN
  SET new.created_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_u_detalles_mantenimiento` BEFORE UPDATE ON `detalles_mantenimiento` FOR EACH ROW BEGIN
  SET new.updated_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_d_detalles_mantenimiento` BEFORE DELETE ON `detalles_mantenimiento` FOR EACH ROW BEGIN
  INSERT INTO log_detalles_mantenimiento VALUES (OLD.id,OLD.descripcion,OLD.costo,OLD.mantenimientos_id,OLD.reparaciones_id,OLD.created_at,now(),system_user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_categorias`
--

DROP TABLE IF EXISTS `log_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_categorias` (
  `id` int DEFAULT NULL,
  `categoria_rep` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_categorias`
--

LOCK TABLES `log_categorias` WRITE;
/*!40000 ALTER TABLE `log_categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_detalles_mantenimiento`
--

DROP TABLE IF EXISTS `log_detalles_mantenimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_detalles_mantenimiento` (
  `id` int DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `costo` double DEFAULT NULL,
  `mantenimientos_id` int DEFAULT NULL,
  `reparaciones_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_detalles_mantenimiento`
--

LOCK TABLES `log_detalles_mantenimiento` WRITE;
/*!40000 ALTER TABLE `log_detalles_mantenimiento` DISABLE KEYS */;
INSERT INTO `log_detalles_mantenimiento` VALUES (21,NULL,22222222,30,9,'2024-03-11 12:22:34','2024-03-12 17:08:35','root@localhost'),(14,NULL,123123,30,2,'2024-03-08 14:51:01','2024-03-12 17:13:51','root@localhost'),(15,NULL,345232,30,4,'2024-03-08 14:51:01','2024-03-12 17:13:51','root@localhost'),(16,NULL,2342,30,5,'2024-03-08 14:51:01','2024-03-12 17:13:51','root@localhost'),(17,NULL,234,30,3,'2024-03-08 14:51:01','2024-03-12 17:13:51','root@localhost'),(18,NULL,12312,30,1,'2024-03-08 14:51:01','2024-03-12 17:13:51','root@localhost'),(19,NULL,23423,30,6,'2024-03-08 14:51:01','2024-03-12 17:13:51','root@localhost'),(22,NULL,2323,31,1,'2024-03-12 17:20:54','2024-03-12 17:21:29','root@localhost'),(26,NULL,343.98,33,2,'2024-03-13 09:33:42','2024-04-02 11:34:47','root@localhost'),(31,NULL,234.2,33,5,'2024-03-15 14:53:47','2024-04-02 11:34:47','root@localhost'),(33,NULL,34343.1,33,7,'2024-03-15 14:53:47','2024-04-02 11:34:47','root@localhost'),(39,NULL,234324.9,33,13,'2024-03-15 14:53:47','2024-04-02 11:34:47','root@localhost'),(49,'qwqw',123123,35,9,'2024-04-18 09:00:19','2024-04-18 09:00:27','root@localhost'),(50,'',12132,36,5,'2024-04-18 09:08:09','2024-04-18 09:08:18','root@localhost'),(58,'sdfsd',43,39,11,'2024-04-23 17:18:02','2024-04-25 11:14:25','root@localhost'),(60,'',345,40,11,'2024-04-25 09:18:32','2024-04-26 10:02:11','root@localhost'),(62,'',3234,42,14,'2024-04-29 08:50:48','2024-07-22 16:50:09','root@localhost'),(63,'',6767,42,11,'2024-04-29 08:54:10','2024-07-22 16:50:09','root@localhost');
/*!40000 ALTER TABLE `log_detalles_mantenimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_mantenimientos`
--

DROP TABLE IF EXISTS `log_mantenimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_mantenimientos` (
  `id` int DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `expediente` varchar(45) DEFAULT NULL,
  `fecha_requerimiento` date DEFAULT NULL,
  `fecha_conformidad_servicio` date DEFAULT NULL,
  `fecha_ingreso_taller` date DEFAULT NULL,
  `fecha_salida_taller` date DEFAULT NULL,
  `km_mantenimiento` double DEFAULT NULL,
  `vehiculos_id` varchar(10) DEFAULT NULL,
  `proveedores_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_mantenimientos`
--

LOCK TABLES `log_mantenimientos` WRITE;
/*!40000 ALTER TABLE `log_mantenimientos` DISABLE KEYS */;
INSERT INTO `log_mantenimientos` VALUES (5,'PREVENTIVO/NO EJECUTADO','vvv','2024-02-13','2024-02-09','2024-02-02','2024-01-31',NULL,'2',1,'2024-02-29 08:26:21','2024-02-29 09:01:59','root@localhost'),(10,'PREVENTIVO','zsd','2024-02-14','2024-02-17','2024-02-14','2024-02-14',NULL,'4',3,'2024-02-29 11:31:30','2024-03-01 12:46:05','root@localhost'),(11,'PREVENTIVO/CORRECTIVO','sfasdasda','2024-02-15','1222-12-12','2024-02-14','2211-11-11',NULL,'4',4,'2024-02-29 11:35:44','2024-03-01 12:46:08','root@localhost'),(4,'PREVENTIVO/NO EJECUTADO','jhuvj','2024-02-14','2024-03-01','2024-01-29','2024-02-08',NULL,'4',3,'2024-02-29 08:22:22','2024-03-01 12:46:12','root@localhost'),(3,'PREVENTIVO/CORRECTIVO','asdas','2024-02-07','2024-02-09','2024-02-12','2024-02-22',NULL,'3',3,'2024-02-29 08:21:16','2024-03-01 12:46:18','root@localhost'),(2,'CORRECTIVO/NO EJECUTADO','123423j4n2','2024-02-17','2024-02-08','2024-02-16','2024-02-05',NULL,'4',5,'2024-02-28 17:24:08','2024-03-01 12:46:21','root@localhost'),(9,'CORRECTIVO/NO EJECUTADO','khjhbhjb','2024-02-21','2024-02-23','2024-02-19','2024-02-15',NULL,'4',6,'2024-02-29 11:23:56','2024-03-01 12:46:25','root@localhost'),(12,'CORRECTIVO/NO EJECUTADO','bhjkbjhb','2024-02-14','2024-02-06','2024-02-20','2024-02-07',NULL,'2',5,'2024-02-29 11:38:20','2024-03-01 12:46:29','root@localhost'),(7,'PREVENTIVO/NO EJECUTADO','sdmaksmdas','1212-12-12','2024-02-27','2024-01-31','2024-02-07',NULL,'14',3,'2024-02-29 10:14:40','2024-03-01 12:46:33','root@localhost'),(6,'PREVENTIVO/NO EJECUTADO','khjhbhjb','2024-02-07','2024-02-13','2024-01-31','2024-02-22',NULL,'1',4,'2024-02-29 08:44:35','2024-03-01 12:46:37','root@localhost'),(14,'CORRECTIVO','asmdmas','2024-02-10','2024-02-10','2024-02-14','2024-02-14',NULL,'15',4,'2024-02-29 11:56:47','2024-03-01 12:46:53','root@localhost'),(18,'PREVENTIVO / CORRECTIVO','pppppp','2024-03-22','2024-03-12','2024-03-12','2024-03-14',NULL,'15',3,'2024-03-01 15:44:29','2024-03-04 09:27:43','root@localhost'),(20,'PREVENTIVO / CORRECTIVO','dasda',NULL,NULL,NULL,NULL,NULL,'4',4,'2024-03-06 10:37:46','2024-03-06 10:38:09','root@localhost'),(21,'CORRECTIVO / NO EJECUTADO','asdas',NULL,NULL,NULL,NULL,NULL,'3',3,'2024-03-06 10:38:29','2024-03-06 12:42:22','root@localhost'),(19,'PREVENTIVO / CORRECTIVO','asdsa',NULL,NULL,NULL,NULL,NULL,'5',5,'2024-03-05 17:24:41','2024-03-06 14:43:41','root@localhost'),(17,'PREVENTIVO','vvvasd','2024-03-14','2024-03-18','2024-03-23','2024-03-10',NULL,'5',4,'2024-03-01 12:53:51','2024-03-06 17:12:46','root@localhost'),(22,'CORRECTIVO / NO EJECUTADO','asdassa',NULL,NULL,NULL,NULL,NULL,'4',6,'2024-03-07 09:00:44','2024-03-07 10:38:23','root@localhost'),(26,'CORRECTIVO','asdasda','2024-03-13','2024-02-27','2024-02-27','2024-02-28',NULL,'3',5,'2024-03-07 11:38:07','2024-03-07 11:42:21','root@localhost'),(30,'PREVENTIVO / NO EJECUTADO','1555555555','2024-03-21','2024-03-19','2024-02-27','2024-03-12',NULL,'6',5,'2024-03-08 14:51:01','2024-03-12 17:13:51','root@localhost'),(31,'CORRECTIVO / NO EJECUTADO','1929192','2024-03-13','2024-03-20','2024-03-13','2024-03-16',NULL,'16',9,'2024-03-12 17:20:54','2024-03-12 17:21:29','root@localhost'),(35,'PREVENTIVO','12314','2024-04-16','2024-04-20','2024-04-10',NULL,433232,'20',6,'2024-04-18 09:00:19','2024-04-18 09:00:27','root@localhost'),(36,'PREVENTIVO / CORRECTIVO','123','2024-04-10',NULL,NULL,NULL,124234,'5',3,'2024-04-18 09:08:09','2024-04-18 09:08:18','root@localhost'),(42,'CORRECTIVO','2342234','2024-04-17',NULL,'2024-04-18',NULL,NULL,'4',4,'2024-04-29 08:50:48','2024-07-22 16:50:09','root@localhost');
/*!40000 ALTER TABLE `log_mantenimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_personas`
--

DROP TABLE IF EXISTS `log_personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_personas` (
  `id` int DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellidos` varchar(150) DEFAULT NULL,
  `celular` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_personas`
--

LOCK TABLES `log_personas` WRITE;
/*!40000 ALTER TABLE `log_personas` DISABLE KEYS */;
INSERT INTO `log_personas` VALUES (11,'Ronaldo','Rivera Vergaray',NULL,'2024-02-21 16:25:33','2024-02-21 17:16:08','root@localhost'),(12,'Ejempl','TOLENTINO LAZARO',984345123,'2024-02-23 14:37:44','2024-02-23 14:39:09','root@localhost'),(13,'njnijnijn','nijnijni',NULL,'2024-02-23 14:45:25','2024-02-23 14:45:40','root@localhost'),(14,'ALBUJAR','asdasjdbsa',NULL,'2024-02-23 14:49:34','2024-02-23 14:49:44','root@localhost'),(15,'DARIO','MAGUIÑA AGUERO',723498234,'2024-03-15 17:22:26','2024-03-15 17:22:31','root@localhost');
/*!40000 ALTER TABLE `log_personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_proveedores`
--

DROP TABLE IF EXISTS `log_proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_proveedores` (
  `id` int DEFAULT NULL,
  `ruc` varchar(50) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_proveedores`
--

LOCK TABLES `log_proveedores` WRITE;
/*!40000 ALTER TABLE `log_proveedores` DISABLE KEYS */;
INSERT INTO `log_proveedores` VALUES (13,'36436457621','mvvv6666','2024-02-21 12:17:28','2024-02-21 12:31:06','root@localhost'),(12,'12345678901','testasasdassdfsdfs','2024-02-21 10:52:16','2024-02-21 12:32:13','root@localhost'),(11,'12345678912','nuevo etas','2024-02-21 10:47:31','2024-02-21 12:33:40','root@localhost'),(10,'12345678912','test','2024-02-21 10:45:43','2024-02-21 12:34:01','root@localhost'),(14,'111111111111','jnadjnasd','2024-02-21 12:37:33','2024-02-21 12:37:38','root@localhost'),(15,'27834565734','asasas','2024-02-21 12:39:09','2024-02-21 12:39:13','root@localhost'),(16,'45345623456','sdasdasdvvvvv','2024-02-21 12:40:44','2024-02-21 12:46:48','root@localhost'),(17,'47546547534','mmmmmmmm','2024-02-21 12:50:31','2024-02-21 12:50:40','root@localhost'),(18,'10239458612','cbhbjsd','2024-02-21 12:53:38','2024-02-21 12:54:13','root@localhost'),(19,'12345678901','wwwwwwwww','2024-02-21 12:55:19','2024-02-21 12:55:42','root@localhost'),(20,'12345678900','example','2024-02-21 12:57:37','2024-02-21 14:44:39','root@localhost'),(21,'12312312341','qqqqqqqddz','2024-02-21 14:46:25','2024-02-21 15:09:31','root@localhost'),(22,'12345678901','wwewe','2024-02-21 15:11:17','2024-02-21 15:11:24','root@localhost'),(23,'10293847561','aaaaaaa','2024-02-21 15:15:10','2024-02-21 15:16:27','root@localhost'),(24,'10293847566','exampleeedit','2024-02-21 15:17:50','2024-02-21 15:18:01','root@localhost'),(25,'1020394857','sdcsdf','2024-02-21 15:20:40','2024-02-21 15:20:44','root@localhost'),(10,'10293847561','prueba','2024-02-21 15:21:48','2024-02-21 15:21:58','root@localhost'),(11,'121','sdfsdf','2024-02-21 15:22:04','2024-02-21 15:22:08','root@localhost'),(10,'12345678901','ejemploxddddddddd','2024-02-21 16:23:08','2024-02-21 16:23:18','root@localhost'),(11,'01293874654','mmmm','2024-02-23 11:34:20','2024-02-23 11:34:29','root@localhost'),(12,'18273748374','asdasdsa','2024-02-23 14:39:51','2024-02-23 14:40:24','root@localhost'),(13,'23123123123','kajsdbaskjdas2131231','2024-03-06 17:29:28','2024-03-06 17:29:39','root@localhost'),(14,'12371263512','CARLOS RAU','2024-04-18 11:27:12','2024-04-18 11:27:32','root@localhost');
/*!40000 ALTER TABLE `log_proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_reparaciones`
--

DROP TABLE IF EXISTS `log_reparaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_reparaciones` (
  `id` int DEFAULT NULL,
  `elemento` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_reparaciones`
--

LOCK TABLES `log_reparaciones` WRITE;
/*!40000 ALTER TABLE `log_reparaciones` DISABLE KEYS */;
INSERT INTO `log_reparaciones` VALUES (1,'Test','2024-02-19 09:47:40','2024-02-19 09:48:14','root@localhost'),(2,'Test','2024-02-19 09:50:29','2024-02-19 10:03:07','root@localhost'),(3,'BUJIAS DE ENCENDIDO','2024-02-19 10:02:39','2024-02-19 10:03:15','root@localhost'),(4,'BUJIAS DE ENCENDIDO','2024-02-19 10:03:26','2024-02-19 10:16:30','root@localhost'),(5,'BUJIAS DE ENCENDIDO','2024-02-19 10:16:57','2024-02-19 10:17:08','root@localhost'),(5,'FILTRO DEL HABITACULO','2024-02-19 10:24:56','2024-02-19 10:26:32','root@localhost'),(15,'ejemplo','2024-04-09 10:51:07','2024-04-09 10:58:22','root@localhost');
/*!40000 ALTER TABLE `log_reparaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_vehiculos`
--

DROP TABLE IF EXISTS `log_vehiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_vehiculos` (
  `id` varchar(10) DEFAULT NULL,
  `unidad` varchar(100) DEFAULT NULL,
  `marca` varchar(150) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `motor` varchar(500) DEFAULT NULL,
  `anio` int DEFAULT NULL,
  `km` double DEFAULT NULL,
  `carga_util_kg` double DEFAULT NULL,
  `personas_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_vehiculos`
--

LOCK TABLES `log_vehiculos` WRITE;
/*!40000 ALTER TABLE `log_vehiculos` DISABLE KEYS */;
INSERT INTO `log_vehiculos` VALUES ('1','MOTO FURGONETA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-02-23 08:33:48','2024-02-23 08:35:25','root@localhost'),('2','MOTO FURGONETA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-02-23 08:35:39','2024-02-23 09:50:14','root@localhost'),('3','MOTO FURGONETAs','asasasa','asas',NULL,2003,700,NULL,NULL,'2024-02-23 09:26:06','2024-02-23 09:50:33','root@localhost'),('6','kejbweijrb||','kqwjneqkjwnekj','asdakjsd',NULL,3453,12361,1273615263,NULL,'2024-02-23 10:22:50','2024-02-23 10:25:38','root@localhost'),('7','kjwenwkjenr|','kmnwekjrn','kjenrkjwen',NULL,1231,123123,2342342,8,'2024-02-23 10:26:13','2024-02-23 10:26:46','root@localhost'),('5','MOTO FURGONETA',NULL,'werwer',NULL,1231,12312321,234234,4,'2024-02-23 09:52:00','2024-02-23 10:26:48','root@localhost'),('4','ssasd','dasd','dsadas',NULL,1233,123123,12312312,7,'2024-02-23 09:34:56','2024-02-23 10:26:51','root@localhost'),('9','CAMIONETA','MITSUBISHI','L200 CR 4X4 2.5 C/D',NULL,2008,NULL,NULL,NULL,'2024-02-23 10:55:09','2024-02-23 11:17:40','root@localhost'),('10','CAMIONETA','MITSUBISHI','L200 CR 4X4 2.5 C/D',NULL,2008,116823,NULL,NULL,'2024-02-23 10:55:56','2024-02-23 11:19:43','root@localhost'),('12','CAMIONETA','MITSUBISHI','L200 CR 4X4 2.5 C/D',NULL,2008,NULL,NULL,NULL,'2024-02-23 10:56:53','2024-02-23 11:20:37','root@localhost'),('11','CAMIONETA','MITSUBISHI','L200 CR 4X4 2.5 C/D',NULL,2008,NULL,NULL,NULL,'2024-02-23 10:56:30','2024-02-23 11:20:48','root@localhost'),('8','CAMIONETA','MITSUBISHI','L200 CR 4X4 2.5 C/D',NULL,2008,224447,NULL,NULL,'2024-02-23 10:54:12','2024-02-29 09:11:54','root@localhost'),('15','ffffffffffffffffffffff','ccccccccc',NULL,NULL,NULL,NULL,NULL,5,'2024-02-29 09:14:54','2024-03-04 09:27:58','root@localhost'),('1','MOTO FURGONETA',NULL,NULL,NULL,NULL,NULL,NULL,1,'2024-02-23 10:46:58','2024-03-04 12:54:59','root@localhost'),('17','xddddd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-03-04 09:50:08','2024-03-04 12:56:05','root@localhost'),('13','MOTO FURGONETAs','asasasa',NULL,NULL,NULL,NULL,NULL,4,'2024-02-28 17:22:15','2024-03-13 09:51:16','root@localhost'),('21','RODILLO VIBRATORIO','CET',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-18 09:53:58','2024-04-18 09:54:04','root@localhost'),('22','xddddd','iasdas',NULL,NULL,NULL,NULL,NULL,4,'2024-04-18 10:30:50','2024-04-18 10:30:55','root@localhost'),('23','asd','asdaswq',NULL,NULL,NULL,NULL,NULL,NULL,'2024-04-18 10:34:54','2024-04-18 10:35:19','root@localhost'),('24','xddddd','FORD','asdasd','qwiuehqwuir',NULL,NULL,NULL,NULL,'2024-04-18 12:18:55','2024-04-18 12:19:14','root@localhost');
/*!40000 ALTER TABLE `log_vehiculos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mantenimientos`
--

DROP TABLE IF EXISTS `mantenimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mantenimientos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL,
  `expediente` varchar(45) NOT NULL,
  `fecha_requerimiento` date DEFAULT NULL,
  `fecha_conformidad_servicio` date DEFAULT NULL,
  `fecha_ingreso_taller` date DEFAULT NULL,
  `fecha_salida_taller` date DEFAULT NULL,
  `km_mantenimiento` double DEFAULT NULL,
  `vehiculos_id` int NOT NULL,
  `proveedores_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mantenimiento_proveedores1_idx` (`proveedores_id`),
  KEY `fk_mantenimientos_vehiculos1_idx` (`vehiculos_id`),
  CONSTRAINT `fk_mantenimiento_proveedores1` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`),
  CONSTRAINT `fk_mantenimientos_vehiculos1` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mantenimientos`
--

LOCK TABLES `mantenimientos` WRITE;
/*!40000 ALTER TABLE `mantenimientos` DISABLE KEYS */;
INSERT INTO `mantenimientos` VALUES (1,'PREVENTIVO / CORRECTIVO','23123','2024-02-07','2024-02-08','2024-02-13','2024-02-09',NULL,3,1,'2024-02-28 17:19:42','2024-03-08 22:51:11'),(8,'PREVENTIVO','akjdnakjsdn','2024-03-06','2024-02-08','2024-02-16','2024-02-29',NULL,4,5,'2024-02-29 11:20:00','2024-02-29 16:20:00'),(13,'PREVENTIVO','vvv','2024-02-06','2024-02-16','2024-03-06','2024-02-08',NULL,4,5,'2024-02-29 11:50:59','2024-03-01 12:45:46'),(15,'CORRECTIVO','1','2024-03-01',NULL,NULL,NULL,NULL,4,6,'2024-02-29 11:57:49','2024-03-22 16:32:57'),(16,'PREVENTIVO','jhbzs','2024-03-12',NULL,'4321-03-12','0003-12-12',NULL,2,2,'2024-03-01 08:42:43','2024-04-11 09:17:20'),(23,'CORRECTIVO','zsdasdas','2024-03-25','2024-03-04','2024-02-26','2024-03-26',12312,2,4,'2024-03-07 09:07:40','2024-04-12 10:13:21'),(24,'PREVENTIVO / CORRECTIVO','expdf','2024-03-28','2024-03-26','2024-03-20','2024-03-28',NULL,5,7,'2024-03-07 10:40:05','2024-03-07 15:40:05'),(25,'CORRECTIVO','1asdasd001','2024-03-13',NULL,'2024-02-27','2024-02-28',NULL,4,6,'2024-03-07 11:10:54','2024-04-23 16:02:30'),(27,'CORRECTIVO','asdasdaasd','2024-03-13','2024-02-27','2024-02-27','2024-02-28',NULL,3,5,'2024-03-07 11:39:43','2024-03-07 16:39:43'),(28,'CORRECTIVO','12311231','2024-03-01','2024-03-10','2024-03-01','2024-03-04',NULL,14,9,'2024-03-07 11:46:55','2024-04-11 08:47:39'),(29,'CORRECTIVO','asdasd','2024-03-26','2024-03-26','2024-03-21','2024-03-05',NULL,5,6,'2024-03-07 11:48:43','2024-04-09 17:13:04'),(32,'PREVENTIVO / CORRECTIVO','19291929','2024-03-13','2024-03-20','2024-03-13','2024-03-16',NULL,16,9,'2024-03-12 17:21:12','2024-04-09 17:12:58'),(33,'PREVENTIVO','1287312','2024-03-13','2024-03-01','2024-03-14','2024-03-28',NULL,3,7,'2024-03-13 09:33:42','2024-04-09 17:12:52'),(34,'CORRECTIVO','1231239999','2024-04-19',NULL,NULL,NULL,8900.6,16,5,'2024-04-02 11:55:05','2024-04-23 14:38:31'),(37,'CORRECTIVO','qweq2056','2024-04-10','2024-04-18',NULL,NULL,1234,18,4,'2024-04-18 10:27:15','2024-04-29 08:47:43'),(38,'PREVENTIVO','123150','2024-04-11',NULL,NULL,NULL,NULL,16,3,'2024-04-23 15:19:23','2024-04-23 16:16:09'),(39,'PREVENTIVO','fghfgh','2024-04-17','2024-04-25',NULL,NULL,NULL,7,2,'2024-04-23 17:18:02','2024-04-23 17:21:00'),(40,'CORRECTIVO','23423','2024-04-26',NULL,NULL,NULL,555555,7,4,'2024-04-23 17:21:35','2024-06-18 15:08:52'),(41,'PREVENTIVO / CORRECTIVO','345wef6','2024-04-27',NULL,'2024-05-27',NULL,NULL,4,4,'2024-04-26 11:09:20','2024-06-04 21:05:58'),(43,'CORRECTIVO','i73423','2024-05-20',NULL,'2024-05-21',NULL,NULL,3,3,'2024-05-20 10:04:15','2024-06-13 09:44:22');
/*!40000 ALTER TABLE `mantenimientos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_i_mantenimientos` BEFORE INSERT ON `mantenimientos` FOR EACH ROW BEGIN
  SET new.created_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_u_mantenimientos` BEFORE UPDATE ON `mantenimientos` FOR EACH ROW BEGIN
  SET new.updated_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_d_mantenimientos` BEFORE DELETE ON `mantenimientos` FOR EACH ROW BEGIN
  INSERT INTO log_mantenimientos VALUES (OLD.id,OLD.tipo,OLD.expediente,OLD.fecha_requerimiento,OLD.fecha_conformidad_servicio,
  OLD.fecha_ingreso_taller,OLD.fecha_salida_taller,OLD.km_mantenimiento,OLD.vehiculos_id,OLD.proveedores_id,OLD.created_at,now(),system_user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(7,'2024_06_04_081226_create_permission_tables',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('vergaray247@gmail.com','$2y$12$L7ov0oJqBIn4aLH4qS/QJO52jMuNsnuRT3nR3GtX6WlQBV.HkQuU2','2024-07-20 04:06:15');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'create users','web','2024-06-04 13:16:42','2024-06-04 13:16:42'),(2,'edit users','web','2024-06-04 13:16:42','2024-06-04 13:16:42'),(3,'delete users','web','2024-06-04 13:16:42','2024-06-04 13:16:42'),(4,'view users','web','2024-06-04 13:16:42','2024-06-04 13:16:42'),(5,'create data','web','2024-06-04 13:16:42','2024-06-04 13:16:42'),(6,'edit data','web','2024-06-04 13:16:42','2024-06-04 13:16:42'),(7,'delete data','web','2024-06-04 13:16:42','2024-06-04 13:16:42'),(8,'view data','web','2024-06-04 13:16:42','2024-06-04 13:16:42');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personas`
--

DROP TABLE IF EXISTS `personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `celular` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas`
--

LOCK TABLES `personas` WRITE;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` VALUES (1,'ANTONIO','DEXTRE MAGUIÑA',NULL,'2024-02-19 15:30:45','2024-02-19 16:23:10'),(2,'MIGUEL','MONTES ALARCON',NULL,'2024-02-20 16:11:32',NULL),(3,'LEOPOLDO','TOLENTINO LAZARO',NULL,'2024-02-20 16:13:36',NULL),(4,'WILBER','OBREGON ESPINOZA',NULL,'2024-02-20 16:15:02',NULL),(5,'PABLO','FERMIN SILVESTRE',NULL,'2024-02-20 16:15:18',NULL),(6,'CARLOS RAUL','MEDINA ROMERO',230847238,'2024-02-20 16:15:34','2024-03-18 09:43:23'),(7,'MARCO','REYES TRUJILLO',NULL,'2024-02-20 16:15:53',NULL),(8,'MAURO','SHUAN LAZARO',NULL,'2024-02-20 16:16:25',NULL),(9,'JOSE LUIS','PAREDES MORALE',162736567,'2024-02-20 16:16:50','2024-06-06 09:23:04'),(10,'EMILIO VICTO','DOMINGUEZ NORABUENO',273463248,'2024-02-20 16:17:13','2024-06-18 14:58:16');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_i_personas` BEFORE INSERT ON `personas` FOR EACH ROW BEGIN
  SET new.created_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_u_personas` BEFORE UPDATE ON `personas` FOR EACH ROW BEGIN
  SET new.updated_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_d_personas` BEFORE DELETE ON `personas` FOR EACH ROW BEGIN
  INSERT INTO log_personas VALUES (OLD.id,OLD.nombre,OLD.apellidos,OLD.celular,OLD.created_at,now(),system_user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ruc` varchar(50) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'20610742549','ALBUJAR','2024-02-20 23:31:22',NULL),(2,'20146921427','ROGE LUNA','2024-02-21 10:30:59','2024-02-21 15:18:46'),(3,'10316032724','PANCHO','2024-02-21 10:32:57','2024-02-21 15:32:57'),(4,'20408088250','MACHETE','2024-02-21 10:33:22','2024-02-21 15:33:22'),(5,'10430924716','JULIO MORENO','2024-02-21 10:35:00','2024-02-21 15:35:00'),(6,'10434950517','HUARAZ TRACTOR','2024-02-21 10:35:48','2024-02-21 15:35:48'),(7,'10427244054','TRUJILLO','2024-02-21 10:36:38','2024-02-21 15:36:38'),(8,'10320394509','VIRGEN DE LAS MERCEDES - ARMAS','2024-02-21 10:41:36','2024-02-21 15:41:36'),(9,'2146921427','ALVARITO MOTORS - HENRY','2024-02-21 10:43:59','2024-02-21 16:22:09'),(15,'00000000000','DESCONOCIDO','2024-04-30 08:28:58','2024-04-30 08:28:58');
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_i_proveedores` BEFORE INSERT ON `proveedores` FOR EACH ROW BEGIN
  SET new.created_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_u_proveedores` BEFORE UPDATE ON `proveedores` FOR EACH ROW BEGIN
  SET new.updated_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_d_proveedores` BEFORE DELETE ON `proveedores` FOR EACH ROW BEGIN
  INSERT INTO log_proveedores VALUES (OLD.id,OLD.ruc,OLD.nombre,OLD.created_at,now(),system_user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `reparaciones`
--

DROP TABLE IF EXISTS `reparaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reparaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `elemento` varchar(200) NOT NULL,
  `categorias_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reparaciones_categorias_idx` (`categorias_id`),
  CONSTRAINT `fk_reparaciones_categorias` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reparaciones`
--

LOCK TABLES `reparaciones` WRITE;
/*!40000 ALTER TABLE `reparaciones` DISABLE KEYS */;
INSERT INTO `reparaciones` VALUES (1,'BUJIAS DE ENCENDIDO',1,'2024-02-19 10:17:30','2024-04-09 09:33:13'),(2,'HOLGURAS DE VALVULAS DE ADMISION Y ESCAPE',2,'2024-02-19 10:20:24','2024-04-09 09:33:13'),(3,'INYECTOR DE COMBUSTIBLE',3,'2024-02-19 10:22:54','2024-04-09 09:33:13'),(4,'FILTRO DEL HABITACULO',4,'2024-02-19 10:24:43','2024-04-09 09:33:13'),(5,'FILTRO DEL DEPURADOR DE AIRE  (TIPO DE PAPEL SECO)',1,'2024-02-19 10:25:51','2024-04-09 09:33:13'),(6,'FILTRO DE AIRE TIPO VISCOSO',2,'2024-02-19 10:28:39','2024-04-09 09:33:13'),(7,'FILTRO DE AIRE PRIMARIO',3,'2024-02-19 10:30:04','2024-04-09 09:33:13'),(8,'FILTRO DE AIRE SECUNDARIO',2,'2024-02-19 10:32:20','2024-04-09 09:33:13'),(9,'FILTRO DE AIRE PRIMARIO Y SECUNDARIO',1,'2024-02-19 10:34:43','2024-04-09 09:33:13'),(10,'FAJA DE ACCESORIOS',3,'2024-02-19 10:36:17','2024-04-09 09:33:13'),(11,'TENSOR DE FAJA',1,'2024-02-19 10:44:13','2024-04-09 09:33:13'),(12,'FAJA DE DISTRIBUCION',2,'2024-02-19 10:46:37','2024-04-09 09:33:13'),(13,'KIT DE DISTRIBUCION',2,'2024-02-19 11:23:38','2024-04-09 09:33:13'),(14,'OTROS',6,'2024-04-02 12:26:22','2024-04-09 10:58:29');
/*!40000 ALTER TABLE `reparaciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_i_reparaciones` BEFORE INSERT ON `reparaciones` FOR EACH ROW BEGIN
  SET new.created_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_u_reparaciones` BEFORE UPDATE ON `reparaciones` FOR EACH ROW BEGIN
  SET new.updated_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_d_reparaciones` BEFORE DELETE ON `reparaciones` FOR EACH ROW BEGIN
  INSERT INTO log_reparaciones VALUES (OLD.id,OLD.elemento,OLD.created_at,now(),system_user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(4,2),(5,2),(6,2),(7,2),(8,2),(8,3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrador','web','2024-06-04 13:16:41','2024-06-04 13:16:41'),(2,'usuario','web','2024-06-04 13:16:41','2024-06-04 13:16:41'),(3,'visualizador','web','2024-06-04 13:16:42','2024-06-04 13:16:42');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ADMINISTRADOR','vergaray247@gmail.com',NULL,'$2y$12$Q01Xb/iy02ZNLJDOOS12OO4owBjyRJ.4wC1foh.YXuTOEfl1IDb16','vyJcOqbqVVA1G2NdkzYeKV2esuKbkOXlK6gV7a58hizRwJ4oduNFy90C1fFG','2024-02-15 20:13:59','2024-07-20 04:56:41'),(2,'MAESTRANZA','ronaldorv_02@hotmail.com',NULL,'$2y$12$H5uerO26/R4R0cjAL.4qmOpI9gTbVkTeFX8jdarXG2ErizwG0yva.',NULL,'2024-06-03 15:17:04','2024-06-03 15:17:04'),(3,'GAYF','73126108@pronabec.edu.pe',NULL,'$2y$12$nMr7fjGhaphi93TO7dC6LexZtgp253wKEtV41VxFeK2iaB1jpjUWK',NULL,'2024-06-03 15:17:53','2024-07-20 05:07:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(20) NOT NULL,
  `unidad` varchar(100) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `motor` varchar(500) DEFAULT NULL,
  `anio` int DEFAULT NULL,
  `km` double DEFAULT NULL,
  `carga_util_kg` double DEFAULT NULL,
  `personas_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vehiculos_personas_idx` (`personas_id`),
  CONSTRAINT `fk_vehiculos_personas` FOREIGN KEY (`personas_id`) REFERENCES `personas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculos`
--

LOCK TABLES `vehiculos` WRITE;
/*!40000 ALTER TABLE `vehiculos` DISABLE KEYS */;
INSERT INTO `vehiculos` VALUES (2,'EX-0771','MOTO FURGONETA',NULL,NULL,NULL,NULL,12312,NULL,2,'2024-02-23 10:47:14','2024-04-12 10:13:21'),(3,'EUG-096','CAMIONETA','FORD','RANGER',NULL,2019,NULL,NULL,NULL,'2024-02-23 10:48:50','2024-04-18 09:30:12'),(4,'EUG-097','CAMIONETA','FORD','RANGER',NULL,2019,NULL,NULL,5,'2024-02-23 10:49:59','2024-04-23 15:59:27'),(5,'MAQ-001','CAMIONETA','FORD','RANGER',NULL,2019,124234,NULL,NULL,'2024-02-23 10:51:37','2024-04-18 09:08:09'),(6,'EUG-099','CAMIONETA','FORD','RANGER',NULL,2019,64065,NULL,3,'2024-02-23 10:52:28','2024-02-23 15:52:28'),(7,'MAQ-002','COMBI','NISSAN','URVAN',NULL,2018,555555,NULL,NULL,'2024-02-23 10:53:06','2024-06-18 15:08:52'),(14,'SER-123','CAMIONETA','VOLVO','Yaris','Motor Generico',2023,700,NULL,2,'2024-02-29 09:11:24','2024-04-05 16:44:30'),(16,'EX-0770','asd','gggg','asdasd','cummins C-8.3  215 P5-0 Turbo Intercooler',2039,NULL,212,2,'2024-03-04 09:46:58','2024-04-23 15:19:23'),(18,'MAQ-003','tractor','FORD67',NULL,NULL,NULL,1234,NULL,NULL,'2024-04-16 11:56:18','2024-04-18 10:27:15'),(19,'EX-0779','CAMIONETA','iasdas','RANGER',NULL,NULL,NULL,NULL,10,'2024-04-16 16:43:42','2024-04-16 16:43:42'),(20,'MAQ-004','TRUCK','TRACK','F40',NULL,NULL,433232,NULL,NULL,'2024-04-16 16:46:06','2024-04-18 09:53:10');
/*!40000 ALTER TABLE `vehiculos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_i_vehiculos` BEFORE INSERT ON `vehiculos` FOR EACH ROW BEGIN
  SET new.created_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_u_vehiculos` BEFORE UPDATE ON `vehiculos` FOR EACH ROW BEGIN
  SET new.updated_at = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tgr_d_vehiculos` BEFORE DELETE ON `vehiculos` FOR EACH ROW BEGIN
  INSERT INTO log_vehiculos VALUES (OLD.id,OLD.unidad,OLD.marca,OLD.modelo,OLD.motor,OLD.anio,OLD.km,OLD.carga_util_kg,OLD.personas_id,OLD.created_at,now(),system_user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'bd_mantenimiento'
--

--
-- Dumping routines for database 'bd_mantenimiento'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-23 17:52:17
