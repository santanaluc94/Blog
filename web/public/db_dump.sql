-- MariaDB dump 10.19  Distrib 10.5.19-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 175.0.0.2    Database: blog
-- ------------------------------------------------------
-- Server version	10.11.2-MariaDB-1:10.11.2+maria~ubu2204

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Categoria de Teste','categoria-de-teste','2023-05-03 13:00:00','2023-05-03 13:00:00');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `content` longblob NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_category_id` (`category_id`),
  KEY `category_user_id` (`user_id`),
  CONSTRAINT `category_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'Where does it come from?',1,1,3,'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','2023-05-03 13:00:23','2023-05-03 13:00:23'),(2,'What is Lorem Ipsum?',1,1,3,'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.','2023-05-03 13:00:54','2023-05-03 13:00:54'),(3,'Why do we use it?',1,1,3,'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#039;lorem ipsum&#039; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).','2023-05-03 13:01:31','2023-05-03 13:01:31'),(4,'Where can I get some?',1,1,3,'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#039;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','2023-05-03 13:01:48','2023-05-03 13:01:48'),(5,'Lorem Ipsum',1,1,0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer id ligula et leo cursus posuere. In vel velit eu risus maximus semper. Donec at pellentesque diam. Praesent elementum quis elit et porta. Integer volutpat mollis tincidunt. Fusce hendrerit nunc ut dui iaculis, id ullamcorper leo porttitor. Sed quis libero a nunc molestie rhoncus eget quis tellus. Fusce tincidunt pharetra mauris at sodales. Morbi condimentum sodales ligula nec rutrum. Sed et tempor mi. Fusce convallis fringilla molestie. Curabitur at tincidunt ante.\r\n\r\nPellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vivamus at cursus nisl, ac blandit sem. Nulla et tortor ut diam dignissim gravida. Proin placerat nisl massa, quis vestibulum lorem dictum id. Aenean quis ante erat. Aliquam erat volutpat. Nulla facilisi. Morbi semper quam vitae felis rhoncus, fringilla tempus neque rhoncus.\r\n\r\nMaecenas ut sem sit amet justo sodales pretium. Nunc tempus diam nec pulvinar tincidunt. Nunc scelerisque efficitur risus, vel tempor dolor fermentum quis. Etiam ut felis varius, hendrerit tortor nec, sagittis diam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In condimentum feugiat molestie. Nam imperdiet nec ex non pulvinar. Integer quis massa turpis. Donec ac hendrerit lectus. Praesent justo mauris, gravida non ligula at, hendrerit gravida lectus. Cras imperdiet egestas dapibus.\r\n\r\nInteger feugiat diam sit amet rhoncus aliquet. Aenean elit nisi, cursus eget iaculis sagittis, ultrices in sem. Suspendisse arcu eros, maximus eget neque et, pellentesque suscipit metus. Proin libero nisl, gravida in euismod sed, vulputate vel mauris. Morbi in turpis facilisis, pharetra risus eu, convallis nibh. Quisque sed felis dignissim, pretium tellus eu, tristique neque. Integer in tortor eleifend, rutrum orci id, rutrum odio. Quisque convallis justo ac rutrum semper.\r\n\r\nDonec sed cursus libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec aliquam odio vitae velit ornare viverra eu vel libero. Donec nec eros ut massa efficitur consectetur. Duis in lectus risus. Donec a dui eu lorem interdum fringilla. Suspendisse quis ipsum eget felis bibendum ullamcorper. Sed vestibulum ipsum eget nisl feugiat elementum vel in ex. Mauris sapien libero, volutpat ut tristique eu, hendrerit ultrices dui. Phasellus consectetur sagittis metus. Donec a euismod odio. Cras eros sapien, consectetur non augue quis, dignissim varius eros. Morbi ac porttitor tellus, id laoreet erat. Nullam vel luctus nisi.','2023-05-03 13:02:09','2023-05-03 13:02:09');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`permissions`)),
  `is_enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin','{\"site\":true,\"admin\":{\"category\":{\"save\":true,\"delete\":true},\"post\":{\"save\":true,\"delete\":true},\"user\":{\"save\":true,\"delete\":true},\"role\":{\"save\":true,\"delete\":true}}}',1),(2,'Só Categoria','{\"admin\":{\"category\":{\"save\":true,\"delete\":true}}}',1),(3,'Só Postagem','{\"admin\":{\"post\":{\"save\":true,\"delete\":true}}}',1),(4,'Só Usuário','{\"admin\":{\"user\":{\"save\":true,\"delete\":true}}}',1),(5,'Só Papel de Usuário','{\"admin\":{\"role\":{\"save\":true,\"delete\":true}}}',1),(6,'Ex-funcionário','{\"admin\":{\"category\":{\"save\":true,\"delete\":true},\"post\":{\"save\":true,\"delete\":true},\"user\":true}}',0),(7,'Só Salvar','{\"admin\":{\"category\":{\"save\":true},\"post\":{\"save\":true},\"user\":{\"save\":true},\"role\":{\"save\":true}}}',1),(8,'Só Deletar','{\"admin\":{\"category\":{\"delete\":true},\"post\":{\"delete\":true},\"user\":{\"delete\":true},\"role\":{\"delete\":true}}}',1),(9,'Só Leitura','{\"admin\":{\"category\":true,\"post\":true,\"user\":true,\"role\":true}}',1);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_role_id` (`role_id`),
  CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Administrador','Admin','admin@admin.com',1,'$2y$10$HUt6NgRTQTjF2wH9EeNPuO.KdCNpObWwUG3lB96OrtW6JObqZYXIu','2023-05-03 12:35:52','2023-05-03 12:35:52'),(2,'Tudo','Categoria','category_tudo@test.com',2,'$2y$10$WWWAU5KN8hKzRSsdoPyGregAMoZKqGtX61eaKAUY67lipxkkKJLaa','2023-05-03 12:54:42','2023-05-03 12:54:42'),(3,'Tudo','Postagem','post_tudo@test.com',3,'$2y$10$AvevGedZh/clGTu1rkwWhejAhZRKJ/pxolYN5OoeMhBXtJ2IsTHcG','2023-05-03 12:55:18','2023-05-03 12:55:18'),(4,'Tudo','Usuário','user_tudo@test.com',4,'$2y$10$ROxJiZd7ThZz647Ko2KSB.sPNbgr6oMu1S0KVUgSTRX566W2oOuZe','2023-05-03 12:55:48','2023-05-03 12:55:48'),(5,'Tudo','Papel de Usuário','role_tudo@test.com',5,'$2y$10$GG.bfXl5UFpMuRLnCVFtuuPoo07L8zaULyF9J68w4Md7KnfrI6IgC','2023-05-03 12:56:12','2023-05-03 12:56:12'),(6,'Admin','Inativo','admin@test.com',6,'$2y$10$fswo8Vot1XoU9MRFA3P6h.8iFm6wbm1uwB4rx.VMnvDnypPTiv7mK','2023-05-03 12:57:11','2023-05-03 12:57:11'),(7,'Tudo','Salvar','save_tudo@test.com',7,'$2y$10$Uzb/h.EFYmlVw4avi0qrHuvHUASkXu2gAeWAAcRBG8XNqTC0UHI86','2023-05-03 12:57:48','2023-05-03 12:57:48'),(8,'Tudo','Deletar','delete_tudo@test.com',8,'$2y$10$FB2FIWtJbPfqewXTjil16.8RdQoIcrlzJ9b2Jt0TteobbD55XL5z.','2023-05-03 12:58:26','2023-05-03 12:58:26'),(9,'Tudo','Leitura','read_tudo@test.com',9,'$2y$10$w3JwCV3bP4CKZE3L6dkL3eTFSozkvR/eCZe5vUd6uaeuzfWgbbp7y','2023-05-03 12:59:02','2023-05-03 12:59:02');
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

-- Dump completed on 2023-05-03 15:41:33
