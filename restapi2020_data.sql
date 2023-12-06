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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Zrzucanie danych dla tabeli restapi2023.language: ~3 rows (około)
DELETE FROM `language`;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` (`id`, `abbr`) VALUES
	(2, 'en'),
	(1, 'pl');
/*!40000 ALTER TABLE `language` ENABLE KEYS */;

-- Zrzut struktury tabela restapi2023.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `price` int unsigned NOT NULL DEFAULT '0',
  `quantity` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Zrzucanie danych dla tabeli restapi2023.product: ~3 rows (około)
DELETE FROM `product`;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `price`, `quantity`) VALUES
	(1, 34850, 45),
	(2, 72100, 72),
	(3, 54630, 19),
	(4, 25780, 84),
	(5, 61090, 36),
	(6, 46710, 58),
	(7, 28210, 91),
	(8, 85360, 13),
	(9, 89370, 45),
	(10, 39870, 80),
	(11, 12720, 24),
	(12, 74190, 11),
	(13, 47630, 35),
	(14, 85720, 95),
	(15, 65940, 68),
	(16, 86280, 77),
	(17, 90760, 8),
	(18, 98220, 61),
	(19, 86240, 42),
	(20, 20930, 57),
	(21, 100050, 34),
	(22, 29750, 79),
	(23, 24540, 86),
	(24, 67010, 73),
	(25, 36220, 29);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Zrzucanie danych dla tabeli restapi2023.product_name: ~8 rows (około)
DELETE FROM `product_name`;
/*!40000 ALTER TABLE `product_name` DISABLE KEYS */;
INSERT INTO `product_name` (`id`, `product_id`, `language_id`, `name`, `description`) VALUES
	(1, 1, 1, 'ekologiczne mleko uht', 'Świeże, ekologiczne mleko UHT.'),
	(3, 3, 1, 'kawa arabica ziarnista', 'Wysokiej jakości kawa arabica, idealna do parzenia espresso.'),
	(4, 4, 1, 'naturalny jogurt grecki', 'Gęsty i kremowy jogurt grecki bez dodatku cukru.'),
	(5, 5, 1, 'ekologiczne jaja kurze', 'Jajka od kur hodowanych ekologicznie.'),
	(6, 6, 1, 'extra virgin olej oliwkowy', NULL),
	(7, 7, 1, 'quinoa ekstra', 'Quinoa, doskonałe źródło białka i składników odżywczych.'),
	(8, 8, 1, 'dorsz filet świeży', NULL),
	(9, 9, 1, 'dżem malinowy bez dodatku cukru', 'Dżem malinowy bez dodatku sztucznych substancji słodzących.'),
	(10, 10, 1, 'jabłka gala', 'Słodkie i soczyste jabłka odmiany Gala.'),
	(11, 11, 1, 'ser feta z oliwkami', 'Ser feta z dodatkiem aromatycznych oliwek.'),
	(12, 12, 1, 'makaron penne pełnoziarnisty', NULL),
	(13, 13, 1, 'miod pitny akacjowy', 'Naturalny miód pitny akacjowy o delikatnym smaku.'),
	(14, 14, 1, 'pomidory san marzano', 'Pomidory San Marzano, idealne do sosów i potraw kuchni włoskiej.'),
	(15, 15, 1, 'otręby pszenne', 'Otręby pszenne, bogate w błonnik.'),
	(16, 16, 1, 'mleko migdałowe bez cukru', NULL),
	(17, 17, 1, 'pesto bazyliowe', 'Pesto bazyliowe, idealne do makaronów i sałatek.'),
	(18, 18, 1, 'miód manuka', 'Miód Manuka o unikalnych właściwościach zdrowotnych.'),
	(19, 19, 1, 'kukurydza mrożona', 'Kukurydza mrożona, łatwa w przygotowaniu i pyszna.'),
	(20, 20, 1, 'kawa rozpuszczalna premium', 'Kawa rozpuszczalna najwyższej jakości.'),
	(21, 21, 1, 'czosnek świeży', 'Świeży czosnek, idealny do wielu potraw.'),
	(22, 22, 1, 'kiełbasa wieprzowa krakowska', 'Tradycyjna kiełbasa wieprzowa Krakowska.'),
	(23, 23, 1, 'jogurt naturalny bez dodatku cukru', 'Jogurt naturalny bez dodatku cukru, doskonały dla zdrowia.'),
	(24, 24, 1, 'mąka pszenna pełnoziarnista', NULL),
	(25, 25, 1, 'suszone morele', 'Suszone morele, pełne naturalnej słodyczy i witamin.'),
	(26, 1, 2, 'Organic UHT Milk', 'Fresh, organic UHT milk.'),
	(27, 2, 2, 'Fresh Whole Grain Bread', 'Whole grain bread, perfect for healthy sandwiches.'),
	(28, 3, 2, 'Arabica Whole Bean Coffee', NULL),
	(29, 4, 2, 'Natural Greek Yogurt', 'Thick and creamy Greek yogurt without added sugar.'),
	(30, 5, 2, 'Organic Free-Range Eggs', 'Eggs from free-range, organically raised hens.'),
	(31, 6, 2, 'Extra Virgin Olive Oil', 'Highest quality cold-pressed extra virgin olive oil.'),
	(32, 7, 2, 'Extra Quinoa', 'Quinoa, an excellent source of protein and nutrients.'),
	(33, 8, 2, 'Fresh Cod Fillet', 'Fresh cod fillet, ready for frying.');
/*!40000 ALTER TABLE `product_name` ENABLE KEYS */;

-- Zrzut struktury tabela restapi2023.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` bit(1) NOT NULL DEFAULT b'0',
  `write` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Zrzucanie danych dla tabeli restapi2023.user: ~2 rows (około)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `hash`, `read`, `write`) VALUES
	(1, 'testuser', '$2y$10$QvgdQjCv3JVKSf67p9flUOo73ZLT1wlkRMmsZ6M4N0V42M3PpZHqW', b'1', b'1'),
	(2, 'reader', '$2y$10$QvgdQjCv3JVKSf67p9flUOo73ZLT1wlkRMmsZ6M4N0V42M3PpZHqW', b'1', b'0');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
