-- Adminer 4.8.1 MySQL 8.2.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `triplan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `triplan`;

DROP TABLE IF EXISTS `budget`;
CREATE TABLE `budget` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `min_budget` int NOT NULL,
  `max_budget` int NOT NULL,
  `final_price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `budget` (`id`, `min_budget`, `max_budget`, `final_price`, `created_at`, `updated_at`) VALUES
(1,	100,	200,	150,	NULL,	NULL);

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `countries` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1,	'Albania',	'AL',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(2,	'Andorra',	'AD',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(3,	'Armenia',	'AM',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(4,	'Austria',	'AT',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(5,	'Azerbaijan',	'AZ',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(6,	'Belarus',	'BY',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(7,	'Belgium',	'BE',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(8,	'Bosnia and Herzegovina',	'BA',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(9,	'Bulgaria',	'BG',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(10,	'Croatia',	'HR',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(11,	'Cyprus',	'CY',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(12,	'Czech Republic',	'CZ',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(13,	'Denmark',	'DK',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(14,	'Estonia',	'EE',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(15,	'Finland',	'FI',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(16,	'France',	'FR',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(17,	'Georgia',	'GE',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(18,	'Germany',	'DE',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(19,	'Greece',	'GR',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(20,	'Hungary',	'HU',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(21,	'Iceland',	'IS',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(22,	'Ireland',	'IE',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(23,	'Italy',	'IT',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(24,	'Kazakhstan',	'KZ',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(25,	'Kosovo',	'KS',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(26,	'Latvia',	'LV',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(27,	'Liechtenstein',	'LI',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(28,	'Lithuania',	'LT',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(29,	'Luxembourg',	'LU',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(30,	'Malta',	'MT',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(31,	'Moldova',	'MD',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(32,	'Monaco',	'MC',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(33,	'Montenegro',	'ME',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(34,	'Netherlands',	'NL',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(35,	'North Macedonia',	'MK',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(36,	'Norway',	'NO',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(37,	'Poland',	'PL',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(38,	'Portugal',	'PT',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(39,	'Romania',	'RO',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(40,	'Russia',	'RU',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(41,	'San Marino',	'SM',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(42,	'Serbia',	'RS',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(43,	'Slovakia',	'SK',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(44,	'Slovenia',	'SI',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(45,	'Spain',	'ES',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(46,	'Sweden',	'SE',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(47,	'Switzerland',	'CH',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(48,	'Turkey',	'TR',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(49,	'Ukraine',	'UA',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(50,	'United Kingdom',	'GB',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26'),
(51,	'Vatican City',	'VA',	'2025-01-24 09:19:26',	'2025-01-24 09:19:26');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10,	'0001_01_01_000001_create_cache_table',	1),
(11,	'0001_01_01_000002_create_jobs_table',	1),
(12,	'2025_01_21_115249_create_budget_table',	1),
(13,	'2025_01_21_115401_create_countries_table',	1),
(14,	'2025_01_21_115524_create_type_table',	1),
(15,	'2025_01_21_115645_create_movilities_table',	1),
(16,	'2025_01_21_115755_create_travels_table',	1),
(17,	'2025_01_22_000000_create_users_table',	1),
(18,	'2025_01_24_073324_create_personal_access_tokens_table',	1);

DROP TABLE IF EXISTS `movilities`;
CREATE TABLE `movilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('bike','car','moto','no_rent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movilities` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1,	'bike',	NULL,	NULL);

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `travels`;
CREATE TABLE `travels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_country` bigint unsigned NOT NULL,
  `id_type` bigint unsigned NOT NULL,
  `id_budget` bigint unsigned NOT NULL,
  `id_movility` bigint unsigned NOT NULL,
  `qunt_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_init` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_end` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `travels_id_country_foreign` (`id_country`),
  KEY `travels_id_type_foreign` (`id_type`),
  KEY `travels_id_budget_foreign` (`id_budget`),
  KEY `travels_id_movility_foreign` (`id_movility`),
  CONSTRAINT `travels_id_budget_foreign` FOREIGN KEY (`id_budget`) REFERENCES `budget` (`id`) ON DELETE CASCADE,
  CONSTRAINT `travels_id_country_foreign` FOREIGN KEY (`id_country`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `travels_id_movility_foreign` FOREIGN KEY (`id_movility`) REFERENCES `movilities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `travels_id_type_foreign` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `travels` (`id`, `id_country`, `id_type`, `id_budget`, `id_movility`, `qunt_date`, `date_init`, `date_end`, `description`, `created_at`, `updated_at`) VALUES
(1,	1,	1,	1,	1,	'2025-01-24',	'2025-02-01',	'2025-02-10',	'Exciting trip for a family holiday',	'2025-01-24 09:31:10',	'2025-01-24 09:31:10');

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('solo','family','friends','partner') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `type` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1,	'solo',	NULL,	NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `birth_date` year NOT NULL DEFAULT '1950',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_alternative` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone_number` int NOT NULL DEFAULT '0',
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_travel` bigint unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_id_travel_foreign` (`id_travel`),
  CONSTRAINT `users_id_travel_foreign` FOREIGN KEY (`id_travel`) REFERENCES `travels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2025-01-24 09:41:28