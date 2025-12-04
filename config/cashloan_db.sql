SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `super_users` (
  `id`    INT   AUTO_INCREMENT PRIMARY KEY
, `first_name`  VARCHAR(100)    DEFAULT NULL
, `last_name`  VARCHAR(100)    DEFAULT NULL
, `email`  VARCHAR(255)    DEFAULT NULL
, `cred_id`   INT
);

CREATE TABLE IF NOT EXISTS `borrowers` (
  `id`    INT   AUTO_INCREMENT PRIMARY KEY
, `first_name`   VARCHAR(100)
, `last_name`   VARCHAR(100)
, `email`       VARCHAR(255)
, `cred_id`   INT
);

CREATE TABLE IF NOT EXISTS `credentials` (
  `id`     INT             NOT NULL AUTO_INCREMENT PRIMARY KEY
, `username`    VARCHAR(255)    NOT NULL  UNIQUE
, `password`    VARCHAR(255)    NOT NULL
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `partners` (
  `id`     INT             NOT NULL AUTO_INCREMENT PRIMARY KEY
, `business_name`     VARCHAR(150)
, `owner_name`        VARCHAR(100)
, `owner_last_name`   VARCHAR(100)
, `owner_email`       VARCHAR(255)
, `trade_name`        VARCHAR(150)
, `reg_num`           VARCHAR(30)
, `income_tax`        VARCHAR(30)
, `ss_num`            VARCHAR(30)
, `namfisa_reg`       VARCHAR(150)
, `phone`             VARCHAR(20)
, `cell`              VARCHAR(20)
, `postal`            VARCHAR(100)
, `physical`          VARCHAR(100)
, `street`            VARCHAR(70)
, `town`              VARCHAR(70)
, `country`           VARCHAR(70)
, `zip_code`          INT(5)
, `status`            VARCHAR(10)   NOT NULL DEFAULT 'Inactive'
, `cred_id`           INT
);

CREATE TABLE IF NOT EXISTS `loan_employees` (
  `id`     INT             NOT NULL AUTO_INCREMENT PRIMARY KEY
, `first_name`  VARCHAR(100)    DEFAULT NULL
, `last_name`  VARCHAR(100)    DEFAULT NULL
, `email`      VARCHAR(255)     DEFAULT NULL
, `bus_id`      INT
, `cred_id`     INT
);

INSERT INTO `credentials` (`username`, `password`) VALUES
('manfred', 'shifafure123'), -- 1
('hero', 'shivute123'), -- 2
('kris', 'marrier123'), -- 3
('minna', 'amigon123'), -- 4
('tony', 'stark123'), -- 5
('gravaton', 'gravaton123'); -- 6

INSERT INTO `super_users` (`first_name`, `last_name`, `email`, `cred_id`) VALUES
('Manfred', 'Shifafure', 'manfred@gestured.com.na', 1);

INSERT INTO `partners` (`business_name`, `owner_name`, `owner_last_name`, `owner_email`, `cred_id`) VALUES
('HNZ Industries', 'Hero', 'Shivute', 'hero@hnz.org', (SELECT id FROM credentials WHERE username = 'hero'));

INSERT INTO `loan_employees` (`first_name`, `last_name`, `email`, `bus_id`, `cred_id`) VALUES
('Kris', 'Marrier', 'kris@gmail.com', 1, 3),
('Minna', 'Amigon', 'minna@yahoo.com', 1, 4);

INSERT INTO `borrowers` (`first_name`, `last_name`, `email`, `cred_id`) VALUES
('Tony', 'Stark', 'tony@stark.industries.com', 5),
('Gravaton', 'Gravitate', 'gravaton@outlook.com', 6);
