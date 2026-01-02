-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: localhost    Database: shuttle
-- ------------------------------------------------------
-- Server version	8.0.44-0ubuntu0.24.04.1

USE `shuttle`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sbshuttle_bookings`
--

DROP TABLE IF EXISTS `sbshuttle_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sbshuttle_bookings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) DEFAULT NULL,
  `locale_id` int unsigned DEFAULT NULL,
  `client_id` int unsigned DEFAULT NULL,
  `location_id` int unsigned DEFAULT NULL COMMENT 'Location ID',
  `dropoff_id` int unsigned DEFAULT NULL COMMENT 'Location ID',
  `line_id` int unsigned DEFAULT NULL,
  `traveling` enum('from','to') DEFAULT 'from',
  `distance` int unsigned DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `duration` int unsigned DEFAULT NULL,
  `has_return` enum('T','F') DEFAULT 'F',
  `return_date` date DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `return_line_id` int unsigned DEFAULT NULL,
  `return_duration` int unsigned DEFAULT NULL,
  `passengers` int DEFAULT NULL,
  `luggage` int DEFAULT NULL,
  `sub_total` decimal(9,2) unsigned DEFAULT NULL,
  `tax` decimal(9,2) unsigned DEFAULT NULL,
  `total` decimal(9,2) unsigned DEFAULT NULL,
  `deposit` decimal(9,2) unsigned DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` enum('confirmed','cancelled','pending') DEFAULT 'pending',
  `txn_id` varchar(255) DEFAULT NULL,
  `processed_on` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `c_title` varchar(255) DEFAULT NULL,
  `c_fname` varchar(255) DEFAULT NULL,
  `c_lname` varchar(255) DEFAULT NULL,
  `c_phone` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `c_company` varchar(255) DEFAULT NULL,
  `c_notes` text,
  `c_address` varchar(255) DEFAULT NULL,
  `c_city` varchar(255) DEFAULT NULL,
  `c_state` varchar(255) DEFAULT NULL,
  `c_zip` varchar(255) DEFAULT NULL,
  `c_country` int unsigned DEFAULT NULL,
  `c_airline_company` varchar(255) DEFAULT NULL,
  `c_departure_airline_company` varchar(255) DEFAULT NULL,
  `c_flight_number` varchar(255) DEFAULT NULL,
  `c_flight_time` varchar(255) DEFAULT NULL,
  `c_departure_flight_number` varchar(255) DEFAULT NULL,
  `c_departure_flight_time` varchar(255) DEFAULT NULL,
  `c_destination_address` varchar(255) DEFAULT NULL,
  `c_cruise_ship` varchar(255) DEFAULT NULL,
  `c_terminal` varchar(255) DEFAULT NULL,
  `cc_type` blob,
  `cc_num` blob,
  `cc_exp_month` blob,
  `cc_exp_year` blob,
  `cc_code` blob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  KEY `line_id` (`line_id`),
  KEY `location_id` (`location_id`),
  KEY `dropoff_id` (`dropoff_id`),
  KEY `return_line_id` (`return_line_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sbshuttle_bookings`
--

LOCK TABLES `sbshuttle_bookings` WRITE;
/*!40000 ALTER TABLE `sbshuttle_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `sbshuttle_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sbshuttle_bookings_payments`
--

DROP TABLE IF EXISTS `sbshuttle_bookings_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sbshuttle_bookings_payments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` int unsigned DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `amount` decimal(9,2) unsigned DEFAULT NULL,
  `status` enum('paid','notpaid') DEFAULT 'paid',
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sbshuttle_bookings_payments`
--

LOCK TABLES `sbshuttle_bookings_payments` WRITE;
/*!40000 ALTER TABLE `sbshuttle_bookings_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `sbshuttle_bookings_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sbshuttle_clients`
--

DROP TABLE IF EXISTS `sbshuttle_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sbshuttle_clients` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `foreign_id` int unsigned DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `country_id` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sbshuttle_clients`
--

LOCK TABLES `sbshuttle_clients` WRITE;
/*!40000 ALTER TABLE `sbshuttle_clients` DISABLE KEYS */;
INSERT INTO `sbshuttle_clients` VALUES (1,2,'dr',NULL,NULL,NULL,NULL,NULL,1);
