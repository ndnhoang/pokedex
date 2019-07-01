-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 01, 2019 at 05:57 PM
-- Server version: 5.7.22-0ubuntu0.17.10.1
-- PHP Version: 7.1.17-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pokedex`
--
CREATE DATABASE IF NOT EXISTS `pokedex` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pokedex`;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=986 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pokemons`
--

DROP TABLE IF EXISTS `pokemons`;
CREATE TABLE IF NOT EXISTS `pokemons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pokemons_name_unique` (`name`),
  UNIQUE KEY `pokemons_slug_unique` (`slug`),
  KEY `pokemons_avatar_foreign` (`avatar`),
  KEY `pokemons_original_foreign` (`original`)
) ENGINE=InnoDB AUTO_INCREMENT=980 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `pokemons`
--
DROP TRIGGER IF EXISTS `before_delete_pokemon`;
DELIMITER $$
CREATE TRIGGER `before_delete_pokemon` BEFORE DELETE ON `pokemons` FOR EACH ROW DELETE FROM images WHERE `value` = old.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pokemon_pokemon_type`
--

DROP TABLE IF EXISTS `pokemon_pokemon_type`;
CREATE TABLE IF NOT EXISTS `pokemon_pokemon_type` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pokemon_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pokemon_pokemon_type_pokemon_id_foreign` (`pokemon_id`),
  KEY `pokemon_pokemon_type_type_id_foreign` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1511 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pokemon_types`
--

DROP TABLE IF EXISTS `pokemon_types`;
CREATE TABLE IF NOT EXISTS `pokemon_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weakness` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pokemon_types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

DROP TABLE IF EXISTS `statistics`;
CREATE TABLE IF NOT EXISTS `statistics` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pokemon_id` bigint(20) UNSIGNED NOT NULL,
  `hp` int(11) NOT NULL DEFAULT '0',
  `attack` int(11) NOT NULL DEFAULT '0',
  `defense` int(11) NOT NULL DEFAULT '0',
  `special_attack` int(11) NOT NULL DEFAULT '0',
  `special_defense` int(11) NOT NULL DEFAULT '0',
  `speed` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `statistics_pokemon_id_unique` (`pokemon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pokemons`
--
ALTER TABLE `pokemons`
  ADD CONSTRAINT `pokemons_avatar_foreign` FOREIGN KEY (`avatar`) REFERENCES `images` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pokemons_original_foreign` FOREIGN KEY (`original`) REFERENCES `pokemons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pokemon_pokemon_type`
--
ALTER TABLE `pokemon_pokemon_type`
  ADD CONSTRAINT `pokemon_pokemon_type_pokemon_id_foreign` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pokemon_pokemon_type_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `pokemon_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_pokemon_id_foreign` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemons` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
