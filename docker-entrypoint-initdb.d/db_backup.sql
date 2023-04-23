-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: tekku
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

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
  `givenAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
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
  `givenAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`userID`,`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
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
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(256) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `activity` int(10) unsigned zerofill DEFAULT NULL,
  `postRef` int(11) DEFAULT NULL,
  PRIMARY KEY (`topicID`,`postID`),
  KEY `userID` (`userID`),
  KEY `postRef` (`postRef`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
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
  `description` text DEFAULT NULL,
  `rules` text DEFAULT NULL,
  PRIMARY KEY (`topicID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES ('am','Anime and Manga',NULL,NULL),('cc','Cartoons and Comics',NULL,NULL),('cook','Cooking',NULL,NULL),('del','delete me','I am not here to stay',NULL),('out','Outdoor Activities','Board related to all things outside.',NULL),('phot', 'Photography',NULL,NULL),('scma','Sciences and Math','siE-mA: All things related to the science and mathematics',NULL),('tec','Technology',NULL,NULL),('tgam','Table Top Games',NULL,NULL),('vgam','Video Games',NULL,NULL);
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
  `profilePic` blob DEFAULT NULL,
  `description` text DEFAULT NULL,
  `creationTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`userID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
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

-- Dump completed on 2023-04-23 13:34:18
