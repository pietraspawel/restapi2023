-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               8.0.35 - MySQL Community Server - GPL
-- Serwer OS:                    Linux
-- HeidiSQL Wersja:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Zrzut struktury tabela restapi2023.language
CREATE TABLE IF NOT EXISTS `language` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbr` (`abbr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Eksport danych został odznaczony.

-- Zrzut struktury tabela restapi2023.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `price` int unsigned NOT NULL DEFAULT '0',
  `quantity` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Eksport danych został odznaczony.

-- Zrzut struktury tabela restapi2023.product_name
CREATE TABLE IF NOT EXISTS `product_name` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `language_id` int unsigned NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_name_language` (`language_id`),
  KEY `FK_product_name_product` (`product_id`),
  CONSTRAINT `FK_product_name_language` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_product_name_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Eksport danych został odznaczony.

-- Zrzut struktury tabela restapi2023.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` bit(1) NOT NULL DEFAULT b'0',
  `write` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Eksport danych został odznaczony.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
