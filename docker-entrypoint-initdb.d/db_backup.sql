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
  `image` varchar(256),
  `content` text,
  `title` varchar(100) DEFAULT NULL,
  `postRef` int(11) DEFAULT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,NULL,'tec','2023-03-01 22:33:21',NULL,'haha lol this is awersome!','new post',NULL),(2,NULL,'tec','2023-03-01 22:40:00',NULL,'hoping to go back','',NULL),(3,NULL,'tec','2023-03-01 23:14:38',NULL,'inserting the third post','',NULL),(5,NULL,'tec','2023-03-03 02:03:06',NULL,'this is a comment',NULL,4),(6,NULL,'tec','2023-03-03 02:03:58',NULL,'the above comment is stoopid',NULL,4),(7,NULL,'tec','2023-03-03 02:41:22',NULL,'enter','test',NULL),(8,NULL,'tec','2023-03-03 03:42:56',NULL,'new post baby  yeah !!!','',NULL),(9,NULL,'tec','2023-03-03 03:47:06',NULL,'hi ethan','',NULL),(10,NULL,'tec','2023-03-03 03:59:38',NULL,'fasdfasdfasdf','',NULL),(11,NULL,'','2023-03-03 18:01:21',NULL,'hey i HATE computers','',NULL),(12,NULL,'','2023-03-03 22:58:12',NULL,'insert always','',NULL),(13,NULL,'tec','2023-03-04 06:04:10',NULL,'hey buddy you stink!','',4),(16,NULL,'tec','2023-03-04 06:24:59',NULL,'adding a comment','',4),(17,NULL,'tec','2023-03-09 23:33:03',NULL,'does this work','',4),(18,NULL,'tec','2023-03-09 23:34:48',NULL,'does this work','',4),(19,NULL,'tec','2023-03-10 01:02:39',NULL,'this is me just typing what comes ot my mind. yknow, i guess i could\'ve done lorm ipsum but now i\'m typing it still. don\'t you just hate compueters !!! me too man, me too. i am still typinggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg','long post',NULL),(20,NULL,'tec','2023-03-10 01:03:02',NULL,'i hate you','',19),(21,NULL,'tec','2023-03-10 03:18:13',NULL,'dsafasdf','',9),(22,NULL,'tec','2023-03-10 03:18:41',NULL,'second !','',9),(23,NULL,'tec','2023-03-10 03:18:59',NULL,'ffffff','',8),(24,NULL,'tec','2023-03-10 03:19:14',NULL,'ffffff','',8),(25,NULL,'tec','2023-03-10 03:19:30',NULL,'t','',8),(26,NULL,'tec','2023-03-10 03:19:42',NULL,'please','',1),(27,NULL,'tec','2023-03-10 03:21:15',NULL,'please please','',1),(28,NULL,'tec','2023-03-10 03:25:02',NULL,'one more','',10),(29,NULL,'tec','2023-03-10 03:30:15',NULL,'hope you do\r\n','',2),(30,NULL,'tec','2023-03-10 04:15:16',NULL,'gaming !','',9),(31,NULL,'tec','2023-03-13 16:03:42',NULL,'sadface','',19),(32,NULL,'tec','2023-03-13 16:03:47',NULL,'sadface','',19),(33,NULL,'tec','2023-03-13 16:04:35',NULL,'` drop table post --','',19),(34,NULL,'tec','2023-03-13 19:56:03',NULL,'sfdgsdfgsdfg','',9),(35,NULL,'tec','2023-03-13 22:04:49',NULL,'fjhasdflkhaskldjfhlkasdhfoq3','',8),(36,NULL,'tec','2023-03-13 22:05:10',NULL,'<h1> test </h1>','',8),(37,NULL,'tec','2023-03-13 22:06:14',NULL,'<img src=\'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Gull_portrait_ca_usa.jpg/1280px-Gull_portrait_ca_usa.jpg\'>','',8),(38,NULL,'tec','2023-03-13 22:07:09',NULL,'<script> alert(\'hey\') </script>','',8),(39,NULL,'tec','2023-03-16 21:10:27',NULL,'This is me posting from the terminal. Yes!\n','',3);
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
INSERT INTO `topic` VALUES ('am','Anime and Manga',NULL,NULL),('cc','Cartoons and Comics',NULL,NULL),('cook','Cooking',NULL,NULL),('out','Outdoor Activities','Board related to all things outside.',NULL),('scma','Sciences and Math','siE-mA: All things related to the science and mathematics',NULL),('tec','Technology',NULL,NULL),('tgam','Table Top Games',NULL,NULL),('vgam','Video Games',NULL,NULL);
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
  `name` varchar(40) NOT NULL unique,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `profilePic` varchar(256),
  `description` text,
  `creationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'example_u','example_p','example_e',NULL,NULL,'2023-03-05 23:44:54'),(2,'one','two','three',NULL,NULL,'2023-03-05 23:46:45'),(3,'one1','two1','three1',NULL,NULL,'2023-03-05 23:47:24'),(4,'one12','two12','three12',NULL,NULL,'2023-03-05 23:48:37'),(5,'123','321','432',NULL,NULL,'2023-03-06 04:14:14'),(6,'a','b','c',NULL,NULL,'2023-03-06 05:52:57'),(7,'9','8','7',NULL,NULL,'2023-03-06 20:02:40'),(8,'test0','test0','test0',NULL,NULL,'2023-03-06 20:07:53'),(9,'final','f','f',NULL,NULL,'2023-03-06 22:28:55'),(10,'1','1','1',NULL,NULL,'2023-03-07 01:45:03'),(11,'nil','icanseemypassword','yourmotehr@myhouse.org',NULL,NULL,'2023-03-07 03:53:45');
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

-- Dump completed on 2023-03-16 17:09:02
