/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 10.4.28-MariaDB : Database - blog_managent_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`blog_managent_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `blog_managent_system`;

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `Added_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `posts` */

insert  into `posts`(`id`,`title`,`summary`,`description`,`Added_by`) values 
(27,'Hyderabad Quotes','Hyderabad Quotes','Fill this city of mine with people as,\nYou filled the river with fishes O Lord.',NULL),
(33,'captions for city','Streets filled with dreams and endless possibilities.','Where skyscrapers touch the sky.',NULL),
(34,'Jamshoro','The city is a hub for the university and its campus, with a history rooted in the region\'s cultural and agricultural significance.','Exploring Jamshoro, the heart of Sindh\'s educational landscape.\"\n\"Jamshoro: Where history, culture, and learning converge.\"\n\"A city with a story to tell, a place of academia and tradition.\"\n\"Discovering the beauty of Jamshoro, a vibrant part of Sindh.',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role_type` enum('admin','editor','user') DEFAULT 'user',
  `added_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`user_role_type`,`added_by`) values 
(1,'adil','','1212','user',NULL),
(4,'adil','aaadi5362@gmail.com','1234','user',NULL),
(5,'adil','adil_12@gmail.com','1234','user',NULL),
(6,'Ambreen koondhar','koondhar_ambr12@gmail.com','1111','admin',NULL),
(7,'Salim ','salim12@gmail.com','2222','user',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
