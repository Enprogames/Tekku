-- MariaDB dump 10.19  Distrib 10.5.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: marie    Database: csci311h_tekku
-- ------------------------------------------------------
-- Server version	10.1.48-MariaDB-0+deb9u2

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `userID` int(11) NOT NULL,
  `topicID` varchar(4) NOT NULL,
  `givenAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (77,'tec','2023-03-30 22:51:41'),(84,'del','2023-03-30 17:09:08');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banned`
--

DROP TABLE IF EXISTS `banned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banned` (
  `userID` int(11) NOT NULL,
  `topicID` varchar(4) NOT NULL,
  `givenAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `duration` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`userID`,`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banned`
--

LOCK TABLES `banned` WRITE;
/*!40000 ALTER TABLE `banned` DISABLE KEYS */;
/*!40000 ALTER TABLE `banned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `topicID` varchar(4) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(256) DEFAULT NULL,
  `content` text,
  `title` varchar(100) DEFAULT NULL,
  `postRef` int(11) DEFAULT NULL,
  `activity` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,NULL,'am','2023-03-29 21:39:11','1679341849.6199-ethan.jpg','my favourite anime character :)','',NULL,0),(2,NULL,'tec','2023-03-29 21:39:11','1679341939.9897-ethan.jpg','bro this guy just hacked my frecking computer !!','',NULL,0),(3,NULL,'am','2023-03-29 21:39:11','1679342736.4269-saint_elmo.jpg','he&apos;s so dreamy','',1,0),(4,NULL,'tec','2023-03-29 21:39:11','1679350050.708-elektrobild_2.gif','hacked','',NULL,0),(5,NULL,'tec','2023-03-29 21:39:11',NULL,'&lt;h1&gt; I HATE THIS PLACE &lt;/h1&gt;','',2,0),(6,NULL,'am','2023-03-29 21:39:11','1679434727.6292-elektrobild_2.gif','dreamiest','',1,0),(7,NULL,'am','2023-03-29 21:39:11','1679434748.6726-elektrobild_2.gif','test2','',NULL,0),(8,NULL,'am','2023-03-29 21:39:11','1679434887.7371-NEWYORKBABY.jpg','image fail xd','',1,0),(9,NULL,'am','2023-03-29 21:39:11','1679434898.0648-saint_elmo.jpg','','',1,0),(10,NULL,'tec','2023-03-29 21:39:11','1679435082.5348-dog.jpg','the bocca on that is IN SANE','',2,0),(11,NULL,'am','2023-03-29 21:39:11','1679436188.6169-elektrobild_2.gif','a gif','',NULL,0),(12,NULL,'tec','2023-03-29 21:39:11',NULL,'ok','',4,0),(13,NULL,'tec','2023-03-29 21:39:11',NULL,'fdsafads','',2,0),(14,NULL,'tec','2023-03-29 21:39:11',NULL,'making a post','',2,0),(15,NULL,'tec','2023-03-29 21:39:11',NULL,'making a comment','',2,0),(16,NULL,'tec','2023-03-29 21:39:11',NULL,'adsfasdf','',2,0),(17,NULL,'tec','2023-03-29 21:39:11',NULL,'making a comemnt','',2,0),(18,NULL,'tec','2023-03-29 21:39:11','1679614287.643-grass.jpg','dsfasdfasdf','',NULL,0),(19,NULL,'tec','2023-03-29 21:39:11','1679614464.2564-NEWYORKBABY.jpg','','',NULL,0),(20,NULL,'out','2023-03-29 21:39:11','1679615029.9362-NEWYORKBABY.jpg','IM STUCK IN NEW YORK HELP','',NULL,0),(21,NULL,'out','2023-03-29 21:39:11',NULL,'ehhh im walking here !!','',20,0),(22,NULL,'am','2023-03-29 21:39:11','1679615533.3983-image.png','top 10 anime villains watchmojo','',NULL,0),(23,NULL,'cook','2023-03-30 21:39:41','1679616418.1808-grass.jpg','adsfasdf','',NULL,2),(24,NULL,'cook','2023-03-29 21:39:11','1679616470.0215-grass.jpg','adsfasdf','',NULL,0),(25,NULL,'cook','2023-03-30 21:39:24','1679616585.6767-NEWYORKBABY.jpg','asdfasdfasdfasdfa','',NULL,2),(26,NULL,'out','2023-03-29 21:39:11','1679616824.057-grass.jpg','help','',NULL,0),(27,NULL,'out','2023-03-29 21:39:11','1679616902.8184-saint_elmo.jpg','wrong','',NULL,0),(28,NULL,'am','2023-03-29 21:39:11',NULL,'i love this!','',22,0),(29,NULL,'am','2023-03-29 21:39:11','1679622351.9306-NEWYORKBABY.jpg','fuck you','',NULL,0),(30,NULL,'am','2023-03-29 21:39:11',NULL,'test','',29,0),(31,NULL,'tec','2023-03-29 21:39:11',NULL,'posting from the emacs terminal baby, yeah\n','',2,0),(32,NULL,'tec','2023-03-29 21:39:11','1679630730.0117-grass.jpg','hey im making a post','',NULL,0),(33,NULL,'tec','2023-03-29 21:39:11',NULL,'hasdkljfhklajshdflkjahsdkljf','',32,0),(34,NULL,'tec','2023-03-29 21:39:11','1680120135.9765-elektrobild_2.gif','just making a new post','',NULL,0),(35,NULL,'tec','2023-03-29 21:39:11','1680120156.3992-dog.jpg','how many can i fit?','',NULL,0),(36,NULL,'tec','2023-03-29 21:39:11','1680120172.8961-ethan.jpg','one more?','',NULL,0),(37,NULL,'tec','2023-03-29 21:39:11','1680120632.9969-grass.jpg','ive got an account','',NULL,0),(38,77,'out','2023-03-29 21:39:11','1680121026.2651-dog.jpg','found this','',NULL,0),(39,77,'tec','2023-03-29 21:39:11','1680121355.1554-peepee.jpg','still logged in','',NULL,0),(40,77,'tec','2023-03-29 21:39:11',NULL,'comment while logged in','',39,0),(41,0,'tec','2023-03-29 21:39:11',NULL,'comment while logged out','',39,0),(42,0,'tec','2023-03-29 21:39:11',NULL,'creating a comment from lynx 2.0','',2,0),(43,0,'tec','2023-03-29 21:39:11','1680122804.4995-screenshot3.jpg','something new','',NULL,0),(44,0,'tec','2023-03-29 21:51:56','1680122968.4017-screenshot1.png','','',NULL,2),(45,0,'tec','2023-03-29 21:42:47',NULL,'i like this :)','',44,NULL),(46,0,'tec','2023-03-29 21:43:17',NULL,'asdfasdf','',44,NULL),(47,0,'tec','2023-03-29 21:44:11',NULL,'asdfasdf','',44,NULL),(48,0,'cook','2023-03-29 21:45:16',NULL,'nice one','',23,NULL),(49,0,'tec','2023-03-29 21:48:24',NULL,'this. this is good','',44,NULL),(50,0,'tec','2023-03-29 21:49:48','1680126588.7656-screenshot3.jpg','something better','',NULL,1),(51,0,'tec','2023-03-30 23:15:07','1680126686.0358-ethan.jpg','something even better','',NULL,3),(52,0,'tec','2023-03-29 21:51:56','1680126716.8023-dog.jpg','','',44,NULL),(53,0,'cook','2023-03-30 21:39:04',NULL,'oh this sucks','',25,NULL),(54,0,'cook','2023-03-30 21:39:24',NULL,'again','',25,NULL),(55,0,'cook','2023-03-30 21:39:41',NULL,'hate this','',23,NULL),(56,0,'tec','2023-03-30 23:15:07','1680218107.6239-self-portrait-september2021.jpg','not better. worse.','',51,NULL),(79,84,'del','2023-03-31 03:07:50','1680231386.9347-477-200x300.jpg','432','432',NULL,7),(84,84,'del','2023-03-31 03:07:39',NULL,'423','423',79,NULL),(85,84,'del','2023-03-31 03:07:50',NULL,'423','423',79,NULL);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic` (
  `topicID` varchar(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `rules` text,
  PRIMARY KEY (`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES ('am','Anime and Manga',NULL,NULL),('cc','Cartoons and Comics',NULL,NULL),('cook','Cooking',NULL,NULL),('del','delete me','I am not here to stay',NULL),('out','Outdoor Activities','Board related to all things outside.',NULL),('scma','Sciences and Math','siE-mA: All things related to the science and mathematics',NULL),('tec','Technology',NULL,NULL),('tgam','Table Top Games',NULL,NULL),('vgam','Video Games',NULL,NULL);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `profilePic` blob,
  `description` text,
  `creationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (76,'polar','$2y$10$OJqgAdQSiyKxOZydrXUBY.kCNVjZAHymtSUBpks7.a9VdVeEazb8i','norm@thenorth.com',NULL,NULL,'2023-03-25 03:19:22'),(77,'nil','$2y$10$8MO6qh2zo80TWCWMPwQIv.OWDIc4DHpuzGcSxLzxzUVh7iGA2Qs8O','fake@email.org',NULL,NULL,'2023-03-29 20:09:55'),(78,'n00b','$2y$10$9ox0mQU0Y0ugUryJizwapeL35/M7lmoLspafqIymH53ZaIxP/3A.C','noob@user.gorg',NULL,NULL,'2023-03-30 23:23:10'),(80,'rewq','$2y$10$kbl4IN0tazXqIPxrzVsjrOMmAjt7ItQfn5UJ3jV.E0eWu0FrK1sBa','qwer',NULL,NULL,'2023-03-30 23:35:39'),(84,'admin','$2y$10$mjozs9B3/eQdE9xA29ZoA.RF1SGiYAONhVavua7S8f1K7qhjy.E7u','admin@amin.com',NULL,NULL,'2023-03-31 00:49:47'),(92,'bill','$2y$10$flxPOKXzPdFH5EdauVTyeOzEQz6wplT4T6uJYWtiHDQWt1xohUwNy','',NULL,NULL,'2023-03-31 01:34:14'),(93,'jason','$2y$10$J8I/kon7O.3uO5iXEDMWI.31tayeld0AHWTiAx/D7Fi8I63qn5C9a','',NULL,NULL,'2023-03-31 01:36:54'),(94,'','$2y$10$boYQqCmPzYB0oH78Zu6acekLPzef8r7XDq52pJCbjDASSsp7u3XL.','',NULL,NULL,'2023-03-31 01:43:01'),(95,'fred','$2y$10$g66xKYNOXIoEaNe.ChNtWOQ6diBC8MKhCTslF2O4tGVHQ4pRM8Gfm','',NULL,NULL,'2023-03-31 02:43:02'),(96,'bob','$2y$10$qlbzNzNKO8iUx2yaZi5CcOX6eoSrVtjGUpGMNMLEogfjcRTmhHhPu','',NULL,NULL,'2023-03-31 02:57:12');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-31 15:48:20
