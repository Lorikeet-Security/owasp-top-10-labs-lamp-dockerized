-- Create ncis database and users table
CREATE DATABASE IF NOT EXISTS `ncis`;
USE `ncis`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` int DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` VALUES (1,'abby','68qFYA3bMIpFF2MthBIDADakKaWuk0'),(2,'mcgee','password123');
