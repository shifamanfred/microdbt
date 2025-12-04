-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for loan
CREATE DATABASE IF NOT EXISTS `loan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `loan`;

-- Dumping structure for table loan.borrowers
CREATE TABLE IF NOT EXISTS `borrowers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cred_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan.borrowers: ~2 rows (approximately)
INSERT INTO `borrowers` (`id`, `first_name`, `last_name`, `email`, `cred_id`) VALUES
	(1, 'Tony', 'Stark', 'tony@stark.industries.com', 5),
	(2, 'Gravaton', 'Gravitate', 'gravaton@outlook.com', 6);

-- Dumping structure for table loan.credentials
CREATE TABLE IF NOT EXISTS `credentials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table loan.credentials: ~6 rows (approximately)
INSERT INTO `credentials` (`id`, `username`, `password`) VALUES
	(1, 'manfred', 'shifafure123'),
	(2, 'hero', 'shivute123'),
	(3, 'kris', 'marrier123'),
	(4, 'minna', 'amigon123'),
	(5, 'tony', 'stark123'),
	(6, 'gravaton', 'gravaton123');

-- Dumping structure for table loan.invoice_order
CREATE TABLE IF NOT EXISTS `invoice_order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_receiver_name` varchar(250) NOT NULL,
  `order_receiver_address` text NOT NULL,
  `order_total_before_tax` decimal(10,2) NOT NULL,
  `order_total_tax` decimal(10,2) NOT NULL,
  `order_tax_per` varchar(250) NOT NULL,
  `order_total_after_tax` double(10,2) NOT NULL,
  `order_amount_paid` decimal(10,2) NOT NULL,
  `order_total_amount_due` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table loan.invoice_order: ~0 rows (approximately)

-- Dumping structure for table loan.invoice_order_item
CREATE TABLE IF NOT EXISTS `invoice_order_item` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `item_code` varchar(250) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `order_item_quantity` decimal(10,2) NOT NULL,
  `order_item_price` decimal(10,2) NOT NULL,
  `order_item_final_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table loan.invoice_order_item: ~0 rows (approximately)

-- Dumping structure for table loan.loan_employees
CREATE TABLE IF NOT EXISTS `loan_employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `bus_id` int DEFAULT NULL,
  `cred_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan.loan_employees: ~2 rows (approximately)
INSERT INTO `loan_employees` (`id`, `first_name`, `last_name`, `email`, `bus_id`, `cred_id`) VALUES
	(1, 'Kris', 'Marrier', 'kris@gmail.com', 1, 3),
	(2, 'Minna', 'Amigon', 'minna@yahoo.com', 1, 4);

-- Dumping structure for table loan.partners
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `business_name` varchar(150) DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `owner_last_name` varchar(100) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `trade_name` varchar(150) DEFAULT NULL,
  `reg_num` varchar(30) DEFAULT NULL,
  `income_tax` varchar(30) DEFAULT NULL,
  `ss_num` varchar(30) DEFAULT NULL,
  `namfisa_reg` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cell` varchar(20) DEFAULT NULL,
  `postal` varchar(100) DEFAULT NULL,
  `physical` varchar(100) DEFAULT NULL,
  `street` varchar(70) DEFAULT NULL,
  `town` varchar(70) DEFAULT NULL,
  `country` varchar(70) DEFAULT NULL,
  `zip_code` int DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Inactive',
  `cred_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan.partners: ~1 rows (approximately)
INSERT INTO `partners` (`id`, `business_name`, `owner_name`, `owner_last_name`, `owner_email`, `trade_name`, `reg_num`, `income_tax`, `ss_num`, `namfisa_reg`, `phone`, `cell`, `postal`, `physical`, `street`, `town`, `country`, `zip_code`, `status`, `cred_id`) VALUES
	(1, 'HNZ Industries', 'Hero', 'Shivute', 'hero@hnz.org', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inactive', 2);

-- Dumping structure for table loan.super_users
CREATE TABLE IF NOT EXISTS `super_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cred_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table loan.super_users: ~1 rows (approximately)
INSERT INTO `super_users` (`id`, `first_name`, `last_name`, `email`, `cred_id`) VALUES
	(1, 'Manfred', 'Shifafure', 'manfred@gestured.com.na', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
