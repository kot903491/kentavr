CREATE DATABASE  IF NOT EXISTS `kentavr` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `kentavr`;
-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: kentavr
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `confirm`
--

DROP TABLE IF EXISTS `confirm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `confirm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `confirm`
--

LOCK TABLES `confirm` WRITE;
/*!40000 ALTER TABLE `confirm` DISABLE KEYS */;
INSERT INTO `confirm` VALUES (1,'На согласовании'),(2,'Утвержденно'),(3,'Отменено');
/*!40000 ALTER TABLE `confirm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'тенге'),(2,'доллар'),(3,'рубль'),(4,'евро');
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dept`
--

DROP TABLE IF EXISTS `dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dept`
--

LOCK TABLES `dept` WRITE;
/*!40000 ALTER TABLE `dept` DISABLE KEYS */;
INSERT INTO `dept` VALUES (1,'ВЦ'),(2,'Гараж'),(3,'РМЦ');
/*!40000 ALTER TABLE `dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_main`
--

DROP TABLE IF EXISTS `menu_main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caption_UNIQUE` (`caption`),
  UNIQUE KEY `url_UNIQUE` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_main`
--

LOCK TABLES `menu_main` WRITE;
/*!40000 ALTER TABLE `menu_main` DISABLE KEYS */;
INSERT INTO `menu_main` VALUES (1,'Главная','/'),(2,'Телефонный справочник','/main/tel'),(3,'Почтовые номера','/main/pechkin');
/*!40000 ALTER TABLE `menu_main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_right`
--

DROP TABLE IF EXISTS `menu_right`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(45) NOT NULL,
  `url` varchar(100) NOT NULL,
  `access` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caption_UNIQUE` (`caption`),
  UNIQUE KEY `url_UNIQUE` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_right`
--

LOCK TABLES `menu_right` WRITE;
/*!40000 ALTER TABLE `menu_right` DISABLE KEYS */;
INSERT INTO `menu_right` VALUES (1,'Menu 1','#',0),(2,'Menu 2','##',0),(3,'Menu 3','###',0),(7,'Оформить заявку на ТМЦ','/page/addprovision',99),(8,'Создать пользователя','/admin/users/new',1),(9,'Утверждение заявок','/page/appprovision',6);
/*!40000 ALTER TABLE `menu_right` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `user` int(11) NOT NULL,
  `tovname` varchar(250) NOT NULL,
  `qt` decimal(10,2) NOT NULL,
  `unit` int(11) NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `curr` int(11) DEFAULT NULL,
  `term` int(11) NOT NULL,
  `conf` int(11) NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  `dataconf` date DEFAULT NULL,
  `qt_prov` decimal(10,2) DEFAULT NULL,
  `cost_prov` decimal(10,2) DEFAULT NULL,
  `curr_prov` int(11) DEFAULT NULL,
  `note_prov` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_provision_unit_idx` (`unit`),
  KEY `fk_provision_curr_idx` (`curr`),
  KEY `fk_provision_term_idx` (`term`),
  KEY `fk_provision_conf_idx` (`conf`),
  KEY `fk_provision_id` (`user`),
  CONSTRAINT `fk_provision_conf` FOREIGN KEY (`conf`) REFERENCES `confirm` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_provision_curr` FOREIGN KEY (`curr`) REFERENCES `currency` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_provision_id` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_provision_term` FOREIGN KEY (`term`) REFERENCES `term` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_provision_unit` FOREIGN KEY (`unit`) REFERENCES `units` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'2018-02-03 07:02:39',2,'товар 1',1.00,1,0.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL),(7,'2018-02-03 08:02:36',2,'товар 1',1.00,1,0.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL),(9,'2018-02-03 08:02:10',2,'товар 1',1.00,1,0.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL),(17,'2018-02-03 08:02:51',2,'товар 1',5.00,1,0.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL),(18,'2018-02-03 08:02:51',2,'товар 2',55.00,1,0.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL),(19,'2018-02-03 08:02:51',2,'товар 3',5.00,1,0.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL),(20,'2018-02-06 22:02:42',2,'новый товар',1.00,2,100.00,3,4,1,'новый тест',NULL,NULL,NULL,NULL,NULL),(21,'2018-02-07 00:02:25',1,'новый товар админ',5.00,1,50.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL),(22,'2018-02-07 00:02:18',4,'очень очень очень очень очень очень очень очень очень очень очень очень очень очень ',1.00,1,0.00,1,1,1,'',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pechkinbook`
--

DROP TABLE IF EXISTS `pechkinbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pechkinbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `number` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pechkinbook`
--

LOCK TABLES `pechkinbook` WRITE;
/*!40000 ALTER TABLE `pechkinbook` DISABLE KEYS */;
INSERT INTO `pechkinbook` VALUES (1,'Ахметзянов Тимур','964'),(2,'Носов Роман','2181');
/*!40000 ALTER TABLE `pechkinbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phonebook`
--

DROP TABLE IF EXISTS `phonebook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phonebook` (
  `idphonebook` int(11) NOT NULL AUTO_INCREMENT,
  `post` varchar(45) NOT NULL,
  `fio` varchar(100) DEFAULT NULL,
  `tel` varchar(20) NOT NULL,
  PRIMARY KEY (`idphonebook`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phonebook`
--

LOCK TABLES `phonebook` WRITE;
/*!40000 ALTER TABLE `phonebook` DISABLE KEYS */;
INSERT INTO `phonebook` VALUES (1,'Директор','Абдрахманов Марат Тлектесович','102'),(2,'Директор по производству','Абубакиров Дмитрий Равильевич','105');
/*!40000 ALTER TABLE `phonebook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Администратор'),(6,'Главный инженер'),(4,'Заказчик'),(2,'Начальник снабжения'),(5,'Секретарь'),(3,'Снабженец');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'В обработке снабжения'),(2,'Запущено в работу'),(3,'В доставке'),(4,'Поставлено на склад');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `term`
--

DROP TABLE IF EXISTS `term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(45) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `term`
--

LOCK TABLES `term` WRITE;
/*!40000 ALTER TABLE `term` DISABLE KEYS */;
INSERT INTO `term` VALUES (1,'1-3 дня',3),(2,'Неделя',7),(3,'2 недели',14),(4,'Месяц',30);
/*!40000 ALTER TABLE `term` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'шт'),(2,'кг'),(3,'тонна'),(4,'комплект'),(5,'литр');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `salt` varchar(35) NOT NULL,
  `uq_str` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `fio` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_users_dept_idx` (`dept`),
  KEY `fk_users_role_idx` (`role`),
  CONSTRAINT `fk_users_dept` FOREIGN KEY (`dept`) REFERENCES `dept` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$NG1F7L1WzJWgdJvRelJmh.VNpzgCQEfFTdV2MDTrvt0oiETAOdcTW','S<-/PL[Y)C{b)^b!i>S*not9)OCkX7','',1,1,'Тимур'),(2,'test','$2y$10$Lj6q.nthSj1s7XfdSoI1z.G5PU3Z3IdaFkUw9x3gIWcNUPcyhhBfK','f$J.H1C|r6fac)~r&s+FX[tp%8?|m0',NULL,2,2,'тест'),(3,'test2','$2y$10$Gy24JvLfnMkAfQ86PXreC.PKouIdbrdENKmt1VLwVzoyTpkkWhbUS','Gok~k?p~K(GGS8hchZ)nIZNS(t9HED',NULL,4,3,'test2'),(4,'test3','$2y$10$r9wGyItpEPZszFLKPp3t7.zpYSv5KRskujKtg45bwQ79Q4f2mOTqq','!,S/.50/4k5aSm81p]o-+YTIgx4[5`',NULL,6,1,'Инженер');
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

-- Dump completed on 2018-02-07  0:51:34
