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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dept`
--

LOCK TABLES `dept` WRITE;
/*!40000 ALTER TABLE `dept` DISABLE KEYS */;
INSERT INTO `dept` VALUES (1,'ВЦ'),(2,'Гараж'),(3,'РМЦ'),(4,'ПВТСКиБ'),(5,'ЦУБ'),(6,'Администрация'),(7,'Лаборатория');
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
  `access` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caption_UNIQUE` (`caption`),
  UNIQUE KEY `url_UNIQUE` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_right`
--

LOCK TABLES `menu_right` WRITE;
/*!40000 ALTER TABLE `menu_right` DISABLE KEYS */;
INSERT INTO `menu_right` VALUES (1,'Menu 1','#','0'),(2,'Menu 2','##','0'),(3,'Menu 3','###','0'),(7,'Оформить заявку на ТМЦ','/page/addprovision','99'),(8,'Создать пользователя','/admin/users/new','1'),(9,'Утверждение заявок','/page/appprovision','6'),(10,'Снабжение - заявки','/page/vieworder','2');
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
  `dateconf` date DEFAULT NULL,
  `deadline` date DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'2018-02-09 16:02:06',2,'Ремкомплект поршневой группы',2.00,4,1000.00,1,2,2,'','2018-02-09','2018-02-23',NULL,NULL,NULL,NULL),(2,'2018-02-09 16:02:06',2,'Прокладка тормозной системы',5.00,4,2000.00,3,3,2,'','2018-02-09','2018-03-02',NULL,NULL,NULL,NULL),(3,'2018-02-09 23:02:13',2,'товар 1',1.00,1,1.00,1,1,2,'','2018-02-09','2018-02-14',NULL,NULL,NULL,NULL),(4,'2018-02-09 23:02:13',2,'товар 2',1.00,1,1.00,1,2,2,'','2018-02-09','2018-02-23',NULL,NULL,NULL,NULL),(5,'2018-02-09 23:02:13',2,'товар 3',1.00,1,1.00,1,3,2,'','2018-02-09','2018-03-02',NULL,NULL,NULL,NULL),(6,'2018-02-09 23:02:13',2,'товар 4',1.00,1,1.00,1,4,2,'','2018-02-09','2018-03-16',NULL,NULL,NULL,NULL),(7,'2018-02-09 23:02:43',4,'товар 2',1.00,1,1.00,1,2,2,'','2018-02-09','2018-02-23',NULL,NULL,NULL,NULL),(8,'2018-02-09 23:02:43',4,'товар 5',2555.00,1,5.00,1,1,3,'','2018-02-09',NULL,NULL,NULL,NULL,NULL),(9,'2018-02-11 21:02:55',4,'товар8',1.00,1,500.00,1,1,2,'','2018-02-12','2018-02-16',NULL,NULL,NULL,NULL),(10,'2018-02-12 16:02:23',5,'товар 2',5.00,1,0.00,1,2,2,'','2018-02-12','2018-02-23',NULL,NULL,NULL,NULL),(11,'2018-02-12 16:02:50',5,'товар 2',5.00,1,0.00,1,3,2,'','2018-02-12','2018-03-02',NULL,NULL,NULL,NULL),(12,'2018-02-13 00:02:35',6,'товар 3',50.00,2,20.00,1,3,2,'примечание','2018-02-13','2018-03-02',NULL,NULL,NULL,NULL),(13,'2018-02-13 00:02:35',6,'товар 3',50.00,1,80.00,1,3,2,'примечание 2','2018-02-13','2018-03-02',NULL,NULL,NULL,NULL);
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
  `strtotime` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `term`
--

LOCK TABLES `term` WRITE;
/*!40000 ALTER TABLE `term` DISABLE KEYS */;
INSERT INTO `term` VALUES (1,'1-3 дня','3'),(2,'Неделя','+1 week next Friday'),(3,'2 недели','+2 week next Friday'),(4,'Месяц','+1 month next Friday');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$NG1F7L1WzJWgdJvRelJmh.VNpzgCQEfFTdV2MDTrvt0oiETAOdcTW','S<-/PL[Y)C{b)^b!i>S*not9)OCkX7','',1,1,'Тимур'),(2,'test','$2y$10$Lj6q.nthSj1s7XfdSoI1z.G5PU3Z3IdaFkUw9x3gIWcNUPcyhhBfK','f$J.H1C|r6fac)~r&s+FX[tp%8?|m0',NULL,4,2,'тест'),(3,'test2','$2y$10$Gy24JvLfnMkAfQ86PXreC.PKouIdbrdENKmt1VLwVzoyTpkkWhbUS','Gok~k?p~K(GGS8hchZ)nIZNS(t9HED',NULL,4,3,'test2'),(4,'test3','$2y$10$r9wGyItpEPZszFLKPp3t7.zpYSv5KRskujKtg45bwQ79Q4f2mOTqq','!,S/.50/4k5aSm81p]o-+YTIgx4[5`',NULL,6,1,'Инженер'),(5,'snab','$2y$10$9DbjMGToUp1ygR6pyBEB6uQOLiAQ59Eo4oOAQ8yZ6tIKDreonTPKy','y4rU[)*bD,$49$7R7@L+,9lSYd9~A/',NULL,2,1,'Захарова Наталья'),(6,'engeneer','$2y$10$Q0lId7NElxVlgKqq.PTL2uFRA2Yp/pOn9aySrP2XApwuDYolOAHRG','[!PYgO0e<.n1%<8C+{>G@^czyMaBZu',NULL,6,6,'Тест 1'),(7,'carpark','$2y$10$vFLczkgbAxrJDwzaOcy.dOE.PF6ybh/7QzpZgBTyCmfqBgYJq.Ocy','jt+2p%/t3FReNh2)k8GpgNNMba!k|{',NULL,4,2,'Тест 2'),(8,'rmc','$2y$10$79/LgUC8gVJp4j8mC5o3COJC9Y2ZYet.6ww2pkORezz43aY04yddi','v3cGZ@b4+BbjV|aNh7d-PUDXyHs8y[',NULL,4,3,'Тест 3');
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

-- Dump completed on 2018-02-13 12:58:18
