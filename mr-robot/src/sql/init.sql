-- MySQL 5.7 compatible init for mr-robot
USE `ourdatabase`;

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` VALUES ('evilcorp','djuhghdsgjhsdjkghsdkjghksjdhgjksndjusg');
