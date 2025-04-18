-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela scrapper-google-maps.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.cache: ~0 rows (aproximadamente)
DELETE FROM `cache`;

-- Copiando estrutura para tabela scrapper-google-maps.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.cache_locks: ~0 rows (aproximadamente)
DELETE FROM `cache_locks`;

-- Copiando estrutura para tabela scrapper-google-maps.configs
CREATE TABLE IF NOT EXISTS `configs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `value` varchar(50) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configs_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.configs: ~10 rows (aproximadamente)
DELETE FROM `configs`;
INSERT INTO `configs` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
	(1, 'max_profit', '200', NULL, '2025-02-21 23:14:50'),
	(2, 'max_donate', '30', NULL, '2025-02-21 23:14:50'),
	(3, 'max_receive', '40', NULL, '2025-02-21 23:14:50'),
	(4, 'max_time_to_donate', '120', NULL, '2025-02-21 23:14:50'),
	(5, 'min_payment_days', '7', NULL, '2025-02-21 23:14:50'),
	(6, 'max_payment_days', '8', NULL, '2025-02-21 23:14:50'),
	(7, 'common_bonus', '5', NULL, '2025-02-21 23:14:50'),
	(8, 'master_bonus', '5', NULL, '2025-02-21 23:14:50'),
	(9, 'indications_to_master', '11', NULL, '2025-02-21 23:14:50'),
	(10, 'min_bonus_request', '10', NULL, '2025-02-21 23:14:50'),
	(11, 'api_key_serper', '3e8360a4f83131178084c6b840beb4d0ed46b779', NULL, '2025-02-21 23:16:03'),
	(12, 'whatsapp_support', 'https://wa.me/SUPORTE', NULL, '2025-02-21 23:16:03');

-- Copiando estrutura para tabela scrapper-google-maps.countries
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.countries: ~1 rows (aproximadamente)
DELETE FROM `countries`;
INSERT INTO `countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
	(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, '+55');

-- Copiando estrutura para tabela scrapper-google-maps.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.failed_jobs: ~0 rows (aproximadamente)
DELETE FROM `failed_jobs`;

-- Copiando estrutura para tabela scrapper-google-maps.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.jobs: ~0 rows (aproximadamente)
DELETE FROM `jobs`;

-- Copiando estrutura para tabela scrapper-google-maps.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.job_batches: ~0 rows (aproximadamente)
DELETE FROM `job_batches`;

-- Copiando estrutura para tabela scrapper-google-maps.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.migrations: ~19 rows (aproximadamente)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2018_11_07_102223_create_countries_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_17_144331_create_plans_table', 1),
	(6, '2019_12_18_140634_create_user_plans_table', 1),
	(7, '2019_12_18_201320_create_wallets_table', 1),
	(8, '2019_12_26_142450_create_configs_table', 1),
	(9, '2019_12_26_150900_create_donations_table', 1),
	(10, '2019_12_30_142339_create_transactions_table', 1),
	(11, '2020_03_14_133226_create_bonuses_table', 1),
	(12, '2020_03_20_141457_create_bonus_requests_table', 1),
	(13, '2020_03_26_134506_add_google2fa_column_to_users', 1),
	(14, '2020_05_24_055942_add_code_disabled2fa_column_to_users', 2),
	(15, '2020_05_25_021454_add_disabled_2fa_column_to_users', 2),
	(16, '2020_09_11_143110_add_unique_hash_column_to_transactions', 3),
	(17, '2020_09_07_170757_add_api_token_column_to_users', 4),
	(18, '2021_01_05_000353_add_description_column_to_bonuses', 5),
	(19, '2025_01_10_162829_create_personal_access_tokens_table', 6);

-- Copiando estrutura para tabela scrapper-google-maps.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.password_resets: ~0 rows (aproximadamente)
DELETE FROM `password_resets`;

-- Copiando estrutura para tabela scrapper-google-maps.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.password_reset_tokens: ~0 rows (aproximadamente)
DELETE FROM `password_reset_tokens`;
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
	('felipe1@gmail.com', '$2y$12$pmnZSvswp9ND9Tn7uiz4Q.MULyhGsKSuTEBT15OygBuWpgJXYMQM6', '2025-02-28 19:23:18');

-- Copiando estrutura para tabela scrapper-google-maps.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.personal_access_tokens: ~0 rows (aproximadamente)
DELETE FROM `personal_access_tokens`;

-- Copiando estrutura para tabela scrapper-google-maps.plans
CREATE TABLE IF NOT EXISTS `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `search_value` float NOT NULL DEFAULT 0,
  `plan_value` float NOT NULL DEFAULT 0,
  `link_checkout` varchar(191) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.plans: ~5 rows (aproximadamente)
DELETE FROM `plans`;
INSERT INTO `plans` (`id`, `name`, `search_value`, `plan_value`, `link_checkout`, `active`, `created_at`, `updated_at`) VALUES
	(18, 'Iniciante', 5, 25, 'https://pay.celetus.com/TZLQJY21', 1, '2025-02-19 14:16:03', '2025-02-20 05:59:10'),
	(19, 'Básico', 3.3, 50, 'https://pay.celetus.com/1M81QUYJ', 1, '2025-02-19 14:16:32', '2025-02-20 05:59:23'),
	(20, 'Intermediário', 2.5, 100, 'https://pay.celetus.com/RRP49RJ0', 1, '2025-02-19 14:16:49', '2025-02-20 05:59:30'),
	(21, 'Avançado', 1.5, 250, 'https://pay.celetus.com/YKS8FBRW', 1, '2025-02-19 14:17:05', '2025-02-20 05:59:41'),
	(22, 'Pro', 1, 500, 'https://pay.celetus.com/10XBUTVB', 1, '2025-02-19 14:17:18', '2025-02-20 05:59:52');

-- Copiando estrutura para tabela scrapper-google-maps.requests
CREATE TABLE IF NOT EXISTS `requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `term` varchar(191) DEFAULT NULL,
  `filename` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `requests_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.requests: ~6 rows (aproximadamente)
DELETE FROM `requests`;
INSERT INTO `requests` (`id`, `user_id`, `term`, `filename`, `created_at`, `updated_at`) VALUES
	(1, 69, 'termoaqu id 1i', '1740558083_Dados', '2025-02-26 11:24:23', '2025-02-26 11:24:23'),
	(2, 69, 'termoaqui', '1740558084_Dados', '2025-02-26 11:21:23', '2025-02-26 11:21:23'),
	(3, 69, 'termoaqui', '1740558085_Dados', '2025-02-26 11:21:23', '2025-02-26 11:21:23'),
	(4, 69, 'termoaqui', '1740558086_Dados', '2025-02-26 11:21:23', '2025-02-26 11:21:23'),
	(5, 3232, 'termoaqui', '1740558087_Dados', '2025-02-26 11:21:23', '2025-02-26 11:21:23'),
	(6, 69, 'termoaqui', '1740562052_Dados', '2025-02-26 12:27:32', '2025-02-26 12:27:32'),
	(7, 69, NULL, '1740753736_Relatorio_Brasil_espiritosanto_VilaVelha_NA_dentista_Mobile', '2025-02-28 17:42:17', '2025-02-28 17:42:17'),
	(8, 69, NULL, '1740753912_Relatorio_Brasil_espiritosanto_VilaVelha_NA_dentista_Mobile', '2025-02-28 17:45:12', '2025-02-28 17:45:12'),
	(9, 69, NULL, '1740754468_Relatorio_Brasil_sãopaulo_NA_NA_dentista_Mobile', '2025-02-28 17:54:28', '2025-02-28 17:54:28'),
	(10, 69, NULL, '1740754535_Relatorio_Brasil_saopaulo_NA_NA_dentista_Mobile', '2025-02-28 17:55:35', '2025-02-28 17:55:35'),
	(11, 69, NULL, '1740755649_Relatorio_Brasil_sãopaulo_NA_garulhos_dentista_Mobile', '2025-02-28 18:14:09', '2025-02-28 18:14:09'),
	(12, 69, NULL, '1740756566_Relatorio_Brasil_sãopaulo_NA_garulhos_dentista_Mobile', '2025-02-28 18:29:26', '2025-02-28 18:29:26'),
	(13, 69, NULL, '1740756660_Relatorio_Brasil_NA_NA_NA_dentista_Mobile', '2025-02-28 18:31:00', '2025-02-28 18:31:00');

-- Copiando estrutura para tabela scrapper-google-maps.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.sessions: ~1 rows (aproximadamente)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('TjsnXqpx4DKSWa4Pizi6gpbA25Aayend88tQT9Di', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiazhVNVFkblpXWkpkcGxGeTM4UVBXTjhydng4a1h3WG9RQ2VOck9KdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6MzAwNi9sb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6MzAwNi9ob21lIjt9fQ==', 1740760158),
	('W0O4Fx245fQwnOjjDc4sgawuu1guPmKzQGn7TbXO', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUkxiQ2tqZ0VXeUxabDJjT2hNZjE4Uk1GT2lldldJeFY3ZG1NWFNFbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNjoiaHR0cDovL2xvY2FsaG9zdDozMDA2L2hvbWUiO31zOjUwOiJsb2dpbl93ZWJfM2RjN2E5MTNlZjVmZDRiODkwZWNhYmUzNDg3MDg1NTczZTE2Y2Y4MiI7aToxO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vbG9jYWxob3N0OjMwMDYvYWRtaW4iO319', 1740752720);

-- Copiando estrutura para tabela scrapper-google-maps.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_plan_id` bigint(20) unsigned DEFAULT NULL COMMENT 'if null admin is donating, plan from who is donating',
  `to_user_id` bigint(20) unsigned NOT NULL,
  `value` float(10,2) NOT NULL,
  `hash` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Waiting Payment, 1 - Confirmed, 2 - expired',
  `who_requested` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_hash_unique` (`hash`),
  KEY `transactions_user_plan_id_foreign` (`user_plan_id`),
  KEY `transactions_to_user_id_foreign` (`to_user_id`),
  KEY `transactions_who_requested_foreign` (`who_requested`),
  CONSTRAINT `transactions_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `transactions_user_plan_id_foreign` FOREIGN KEY (`user_plan_id`) REFERENCES `user_plans` (`id`),
  CONSTRAINT `transactions_who_requested_foreign` FOREIGN KEY (`who_requested`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=178368 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.transactions: ~0 rows (aproximadamente)
DELETE FROM `transactions`;

-- Copiando estrutura para tabela scrapper-google-maps.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `indication_id` bigint(20) unsigned DEFAULT NULL,
  `country_code` varchar(191) NOT NULL,
  `phone_number` varchar(191) NOT NULL,
  `authy_id` varchar(191) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `api_token` varchar(80) DEFAULT NULL,
  `level` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google2fa_secret` text DEFAULT NULL,
  `code_disabled2fa` varchar(6) DEFAULT NULL,
  `disabled_2fa` tinyint(1) NOT NULL DEFAULT 1,
  `is_20` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`),
  KEY `users_indication_id_foreign` (`indication_id`),
  CONSTRAINT `users_indication_id_foreign` FOREIGN KEY (`indication_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3236 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.users: ~25 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `name`, `email`, `indication_id`, `country_code`, `phone_number`, `authy_id`, `verified`, `email_verified_at`, `password`, `api_token`, `level`, `remember_token`, `created_at`, `updated_at`, `google2fa_secret`, `code_disabled2fa`, `disabled_2fa`, `is_20`) VALUES
	(1, 'asol1', 'ASOL 1', 'admin@asol.com.br', NULL, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$12$FVGKwb0w8OsDlE/Lin1bxe.pdiyjIMYMP9J5xab0tHqohhLyPk3mC', 'cbx3FShIgPWp87CmLJjf80SKcIykM6ML8JFrpuQhoDQUVG0JzosFZ9MiCYs4', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 16:10:56', NULL, NULL, 1, 0),
	(2, 'asol2', 'ASOL 2', 'fgadmin@asol.com.br', 1, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'MZ43TN3shvQuVp3cQfCwlMVHKBzr1EWBoe862mIb3zpFaXHASmLbnF1L3d9v', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(3, 'asol3', 'ASOL 3', 'smadmin@asol.com.br', 2, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'YKXTJNlDN7qRcJTyHmXSwqk6gHRX6Kin4qcjcyPlQVvrSJaQx2qC9N6SPt9s', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(4, 'asol4', 'ASOL 4', 'cadmin@asol.com.br', 3, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', '3af6Sfcs6YlB5t5x9oapNokbmJWfmwZZRJhCTIcjS7jXyYjMeqxUfKGZ06UT', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(5, 'asol5', 'ASOL 5', 'gradmin@asol.com.br', 4, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'VE6F9JtD8G64UYuz8szp4OPKgoBzZPtbgUhUJcfCNtGvMeLZlg1Ob3sSGzTr', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(6, 'asol6', 'ASOL 6', 'apadmin@asol.com.br', 5, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'VnJPZTQsxyawqvZYW6f0caXZw1nojgWL2BZ3t0MHdH4Eu1PrLHApt2WkUpn8', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(7, 'asol7', 'ASOL 7', 'psadmin@asol.com.br', 6, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'TioG8sgEX1Llp6re71yHjYIDDvI4P16N4vmbWRBJ2pmMDRU6C9rlPS8ODoFQ', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(8, 'asol8', 'ASOL 8', 'mjadmin@asol.com.br', 7, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:13', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'gK7hOFTPxuCG9tBIZgvUS5BcuelaWN890kNoHtGK7iMH8A37MsJnN4nsf05j', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(9, 'asol9', 'ASOL 9', 'fladmin@asol.com.br', 8, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'WlYjCTQjXBIqjwxAu6cGzr8VpogiVMQkvQrNXNSi2nxgDH0DVFrD7TGMCdjo', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(10, 'asol10', 'ASOL 10', 'aladmin@asol.com.br', 9, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'gBhFY6MS8XE3ziETGE80QukeGRF4SpOEp7l9bhSm5MJLPKs01piNBtYSXBAU', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(11, 'asol11', 'ASOL 11', 'radmin@asol.com.br', 10, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'K5Cl5YoAS7KLr12QU3oAEzDk0UnpDx32C68HLGTI37lcei2FglNK9GORrSag', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(12, 'asol12', 'ASOL 12', 'chadmin@asol.com.br', 11, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', '2OnqHruYj3YkAXoRx6LyyGlp1BHlTMlYW7ISPYNt0lWxTyCQlZeYnQhnV129', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(13, 'asol13', 'ASOL 13', 'phadmin@asol.com.br', 12, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'wZiHsiifEeYmW3LZ4FoH6U7ZL5LGbrdtq4kKUuf4yaFT34F57sK0o9mYtk1d', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(14, 'asol14', 'ASOL 14', 'rfadmin@asol.com.br', 13, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', '2NtZB5t2ZnuTIMBBMQmOIuJnssEFrOkU9Y2z1TpeYOW3HwcbBtl7frdeIhra', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(15, 'asol15', 'ASOL 15', 'wcadmin@asol.com.br', 14, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'XImUL6MFZA5QIz6KbuPSKUj8AonT0Xtqex9lUecC2H7jYzGGaI696BDqSCBm', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(16, 'asol16', 'ASOL 16', 'wsadmin@asol.com.br', 15, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'gC8kjrvzy4QXNw1RhGJ5Xjelwn2TXnPvbhyqLu7qa0G5GaBhOkRwIIkv21KI', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(17, 'asol17', 'ASOL 17', 'hcadmin@asol.com.br', 16, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'shIJqRe10hne58iyjD6iBTwv3NTsUbkTWRn2QIWIm9DB6oxQsR5XrIchx06p', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(18, 'asol18', 'ASOL 18', 'ctadmin@asol.com.br', 17, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', '5K9BcQzGy5FfbawYMNubER532Xc5JXhg05HVBpHDIhNSxYwPIvO9CByzXKiR', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(19, 'asol19', 'ASOL 19', 'dnadmin@asol.com.br', 18, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', '9rUs8V2w1w9iAmNBcT9urcZw1tSyFZrDxseeKyOJq6AyZklULJNp5hZhktfw', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(20, 'asol20', 'ASOL 20', 'tbadmin@asol.com.br', 19, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', '8bp24t6YvkSNht1ZCjQiEQJJQgVcC3EG7WFD610AjP9cJLySVwqq76Q7ta0n', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(21, 'asol21', 'ASOL 21', 'jsadmin@asol.com.br', 20, '+55', '62123456789', NULL, 0, '2020-05-08 12:14:14', '$2y$10$HIgv5C/C9n6p.5.UrOUi4.Puutjy/qj2cGLTWP6a0GpI0fRgbflsS', 'YQU3vqwhUfeqUI0OvTKvvH1Hc7MaYZ3fyEAfXT6v5BjDknxVgRJmMEt9SSUa', 1, NULL, '2025-01-11 18:13:27', '2025-01-11 18:13:27', NULL, NULL, 1, 0),
	(69, 'felipe', 'Felipe Monteiro', 'felipe.fpc@outlook.com', 21, '+1', '62123456789', NULL, 0, NULL, '$2y$12$xHksloboneBUJ6OIy9tv/OWszhxm0jG13YWnuKrQhmOOKJ9W2j1BO', 'JiNdhu7ecUPX3TJkozwxEFHzFIs6Xcv6o9wu0L5LRH6ejRJ7NDIDrefEccUh', 0, 'jxXuEhn7LTUm1HN1EhQHEuLFW5bjoqIGK0Uru4MjLFhXKXRVrwdfzTAlkd2U', '2025-01-11 18:13:27', '2025-02-28 19:29:02', 'eyJpdiI6Ik9qcjNtKzhIdllCekNpNmh6NTg1eWc9PSIsInZhbHVlIjoiZ20yQ01vRUV2WEJFUmtvMlhVeG1JQT09IiwibWFjIjoiYjlkYzhmMWMyMTY4OThkNGZmYzUyNjMyZDEwN2JiNTJmNzY0YzA4ZjJkOTA1NjM4NjRkNjExNWQ2ZmM3NDRkYiIsInRhZyI6IiJ9', NULL, 1, 0),
	(3232, 'felipe1', 'Felipe 1', 'felipe1@gmail.com', 69, '+93', '62993474312', NULL, 0, NULL, '$2y$12$dfTJyoNxjxEpuA3pz2K1ouSlkbpuKa66OR5HxOF.rtCFoQZW6XZNi', 'H6tXnYtobWpPVXXj7bvv7SmHxBQORXxfmscMA1evlDJC7btHAnkyDjpUnH5h', 0, NULL, '2025-01-12 02:11:57', '2025-01-12 02:11:57', NULL, NULL, 1, 1),
	(3234, 'felipeadm', 'Felipe adm', 'felipeadm@gmail.com', NULL, '+55', '62993474312', NULL, 0, NULL, '$2y$12$URmYK1WaZpvnleK.hZOeluXdFI/qeSv1JzobnSwL18epRtRWiyzTK', NULL, 0, NULL, '2025-02-26 20:58:57', '2025-02-26 20:58:57', NULL, NULL, 1, 1),
	(3235, 'felipe2025', 'Felipe Monteiro', 'felipe.fpc2@gmail.com', NULL, '+55', '62993474312', NULL, 0, NULL, '$2y$12$LXIXp/LNDfQPlZ/hQslrOe9.yth9VblA2cWErNI03PALJyK4k/LlS', '1NCWOsTBgXAG5qIH0D5ssih14DLRSH9hz3YoHNbgLUO3RIpicpys8slRzwLG', 0, NULL, '2025-02-26 23:19:29', '2025-02-26 23:26:49', NULL, NULL, 1, 1);

-- Copiando estrutura para tabela scrapper-google-maps.user_plans
CREATE TABLE IF NOT EXISTS `user_plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `plan_id` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - created, 1 - active, 2 - canceled, 3 - ended',
  `movimentation` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - must donate, 1 - must receive, 2-donating',
  `requests_left` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of transactions left to confirm',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_plans_user_id_foreign` (`user_id`),
  KEY `user_plans_plan_id_foreign` (`plan_id`),
  CONSTRAINT `user_plans_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `user_plans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10855 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela scrapper-google-maps.user_plans: ~5 rows (aproximadamente)
DELETE FROM `user_plans`;
INSERT INTO `user_plans` (`id`, `user_id`, `plan_id`, `status`, `movimentation`, `requests_left`, `created_at`, `updated_at`) VALUES
	(10850, 69, 18, 1, 0, 0, '2025-02-26 09:21:37', '2025-02-28 17:55:35'),
	(10851, 69, 19, 1, 0, 17, '2025-02-26 09:21:42', '2025-02-28 18:31:00'),
	(10852, 69, 21, 1, 0, 50, '2025-02-26 09:21:43', '2025-02-26 09:21:44'),
	(10853, 3232, 18, 1, 0, 0, '2025-02-26 22:11:57', '2025-02-26 22:27:57'),
	(10854, 3232, 18, 0, 0, 3, '2025-02-26 22:27:01', '2025-02-26 22:27:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
