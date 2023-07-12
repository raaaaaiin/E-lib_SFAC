-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table lara-lib.dewey_decimals
CREATE TABLE IF NOT EXISTS `dewey_decimals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL,
  `dewey_no` double(7,4) unsigned DEFAULT NULL,
  `shelf_no` int(11) NOT NULL DEFAULT '0',
  `image` text COLLATE utf8mb4_unicode_ci,
  `bg_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '#000000',
  `txt_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '#ffffff',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lara-lib.dewey_decimals: ~15 rows (approximately)
DELETE FROM `dewey_decimals`;
/*!40000 ALTER TABLE `dewey_decimals` DISABLE KEYS */;
INSERT INTO `dewey_decimals` (`id`, `cat_name`, `parent`, `dewey_no`, `shelf_no`, `image`, `bg_color`, `txt_color`, `created_at`, `updated_at`) VALUES
	(1, 'Computer science, information & general works', 0, 0.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:04:36', '2021-02-24 07:17:08'),
	(2, 'Philosophy & psychology', 0, 100.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:04:43', '2021-02-24 05:04:43'),
	(3, 'Religion', 0, 200.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:04:50', '2021-02-24 05:04:50'),
	(4, 'Social sciences', 0, 300.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:04:57', '2021-02-24 05:04:57'),
	(5, 'Language', 0, 400.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:05:05', '2021-02-24 05:05:05'),
	(6, 'Science', 0, 500.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:05:15', '2021-02-24 05:05:15'),
	(7, 'Technology', 0, 600.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:05:23', '2021-02-24 05:05:23'),
	(8, 'Arts & recreation', 0, 700.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:05:31', '2021-02-24 05:05:31'),
	(9, 'Literature', 0, 800.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:05:39', '2021-02-24 05:05:39'),
	(10, 'History & geography', 0, 900.0000, 0, NULL, '#000000', '#ffffff', '2021-02-24 05:05:49', '2021-02-24 05:05:49'),
	(12, 'Unassigned', 1, NULL, 2, NULL, '#000000', '#ffffff', '2021-02-24 05:54:06', '2021-02-24 07:17:09'),
	(14, 'Unassigned', 2, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:17:57', '2021-02-24 07:17:57'),
	(15, 'Unassigned', 3, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:18:09', '2021-02-24 07:18:09'),
	(16, 'Unassigned', 4, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:21:04', '2021-02-24 07:21:04'),
	(17, 'Unassigned', 5, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:21:12', '2021-02-24 07:21:12'),
	(18, 'Unassigned', 6, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:21:18', '2021-02-24 07:21:18'),
	(19, 'Unassigned', 7, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:21:28', '2021-02-24 07:21:28'),
	(20, 'Unassigned', 8, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:21:41', '2021-02-24 07:21:41'),
	(21, 'Unassigned', 9, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:26:20', '2021-02-24 07:26:20'),
	(22, 'Unassigned', 10, NULL, 0, NULL, '#000000', '#ffffff', '2021-02-24 07:26:28', '2021-02-24 07:26:28');
/*!40000 ALTER TABLE `dewey_decimals` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
