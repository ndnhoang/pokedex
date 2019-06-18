-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2019 at 06:01 PM
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

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `url`, `table`, `meta`, `value`, `created_at`, `updated_at`) VALUES
(1, 'public/images/pokemon/001.png', 'pokemons', 'avatar', 1, '2019-06-17 21:43:45', '2019-06-17 21:43:45'),
(2, 'public/images/pokemon/002.png', 'pokemons', 'avatar', 2, '2019-06-17 21:43:55', '2019-06-17 21:43:55'),
(3, 'public/images/pokemon/003.png', 'pokemons', 'avatar', 3, '2019-06-17 21:44:28', '2019-06-17 21:44:28'),
(4, 'public/images/pokemon/004.png', 'pokemons', 'avatar', 4, '2019-06-17 21:44:50', '2019-06-17 21:44:51'),
(5, 'public/images/pokemon/005.png', 'pokemons', 'avatar', 5, '2019-06-17 21:45:07', '2019-06-17 21:45:07'),
(6, 'public/images/pokemon/006.png', 'pokemons', 'avatar', 6, '2019-06-17 21:45:36', '2019-06-17 21:45:36'),
(7, 'public/images/pokemon/007.png', 'pokemons', 'avatar', 7, '2019-06-17 21:45:55', '2019-06-17 21:45:55'),
(8, 'public/images/pokemon/008.png', 'pokemons', 'avatar', 8, '2019-06-17 21:47:25', '2019-06-17 21:47:26'),
(9, 'public/images/pokemon/009.png', 'pokemons', 'avatar', 9, '2019-06-17 21:47:41', '2019-06-17 21:47:41'),
(10, 'public/images/pokemon/010.png', 'pokemons', 'avatar', 10, '2019-06-17 21:48:27', '2019-06-17 21:48:27'),
(11, 'public/images/pokemon/011.png', 'pokemons', 'avatar', 11, '2019-06-17 21:49:07', '2019-06-17 21:49:08'),
(12, 'public/images/pokemon/012.png', 'pokemons', 'avatar', 12, '2019-06-17 21:49:33', '2019-06-17 21:49:33'),
(13, 'public/images/pokemon/013.png', 'pokemons', 'avatar', 13, '2019-06-18 01:06:21', '2019-06-18 01:06:21'),
(14, 'public/images/pokemon/014.png', 'pokemons', 'avatar', 14, '2019-06-18 01:06:38', '2019-06-18 01:06:38'),
(15, 'public/images/pokemon/015.png', 'pokemons', 'avatar', 15, '2019-06-18 01:06:53', '2019-06-18 01:06:53'),
(16, 'public/images/pokemon/016.png', 'pokemons', 'avatar', 16, '2019-06-18 01:07:06', '2019-06-18 01:07:06'),
(17, 'public/images/pokemon/017.png', 'pokemons', 'avatar', 17, '2019-06-18 01:07:25', '2019-06-18 01:07:25'),
(18, 'public/images/pokemon/018.png', 'pokemons', 'avatar', 18, '2019-06-18 01:07:50', '2019-06-18 01:07:50'),
(19, 'public/images/pokemon/019.png', 'pokemons', 'avatar', 19, '2019-06-18 01:08:04', '2019-06-18 01:08:04'),
(20, 'public/images/pokemon/020.png', 'pokemons', 'avatar', 20, '2019-06-18 01:08:19', '2019-06-18 01:08:19'),
(21, 'public/images/pokemon/021.png', 'pokemons', 'avatar', 21, '2019-06-18 01:08:30', '2019-06-18 01:08:30'),
(22, 'public/images/pokemon/022.png', 'pokemons', 'avatar', 22, '2019-06-18 01:08:43', '2019-06-18 01:08:43'),
(23, 'public/images/pokemon/023.png', 'pokemons', 'avatar', 23, '2019-06-18 01:08:57', '2019-06-18 01:08:57'),
(24, 'public/images/pokemon/024.png', 'pokemons', 'avatar', 24, '2019-06-18 01:09:11', '2019-06-18 01:09:11'),
(25, 'public/images/pokemon/025.png', 'pokemons', 'avatar', 25, '2019-06-18 01:09:22', '2019-06-18 01:09:22'),
(26, 'public/images/pokemon/026.png', 'pokemons', 'avatar', 26, '2019-06-18 01:09:37', '2019-06-18 01:09:37'),
(27, 'public/images/pokemon/027.png', 'pokemons', 'avatar', 27, '2019-06-18 01:09:48', '2019-06-18 01:09:48'),
(28, 'public/images/pokemon/028.png', 'pokemons', 'avatar', 28, '2019-06-18 01:10:06', '2019-06-18 01:10:06'),
(29, 'public/images/pokemon/029.png', 'pokemons', 'avatar', 29, '2019-06-18 01:10:40', '2019-06-18 01:10:41'),
(30, 'public/images/pokemon/030.png', 'pokemons', 'avatar', 30, '2019-06-18 01:11:01', '2019-06-18 01:11:01'),
(31, 'public/images/pokemon/031.png', 'pokemons', 'avatar', 31, '2019-06-18 01:20:29', '2019-06-18 01:20:29');

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_06_17_092053_create_images_table', 1),
(4, '2019_06_17_092144_create_pokemons_table', 1);

--
-- Dumping data for table `pokemons`
--

INSERT INTO `pokemons` (`id`, `number`, `name`, `avatar`, `created_at`, `updated_at`) VALUES
(1, '001', 'Bulbasaur', 1, '2019-06-17 21:43:45', '2019-06-17 21:43:45'),
(2, '002', 'Ivysaur', 2, '2019-06-17 21:43:55', '2019-06-17 21:43:55'),
(3, '003', 'Venusaur', 3, '2019-06-17 21:44:28', '2019-06-17 21:44:28'),
(4, '004', 'Charmander', 4, '2019-06-17 21:44:50', '2019-06-17 21:44:50'),
(5, '005', 'Charmeleon', 5, '2019-06-17 21:45:07', '2019-06-17 21:45:07'),
(6, '006', 'Charizard', 6, '2019-06-17 21:45:36', '2019-06-17 21:45:36'),
(7, '007', 'Squirtle', 7, '2019-06-17 21:45:55', '2019-06-17 21:45:55'),
(8, '008', 'Wartortle', 8, '2019-06-17 21:47:25', '2019-06-17 21:47:25'),
(9, '009', 'Blastoise', 9, '2019-06-17 21:47:41', '2019-06-17 21:47:41'),
(10, '010', 'Caterpie', 10, '2019-06-17 21:48:27', '2019-06-17 21:48:27'),
(11, '011', 'Metapod', 11, '2019-06-17 21:49:07', '2019-06-17 21:49:07'),
(12, '012', 'Butterfree', 12, '2019-06-17 21:49:33', '2019-06-17 21:49:33'),
(13, '013', 'Weedle', 13, '2019-06-18 01:06:21', '2019-06-18 01:06:21'),
(14, '014', 'Kakuna', 14, '2019-06-18 01:06:38', '2019-06-18 01:06:38'),
(15, '015', 'Beedrill', 15, '2019-06-18 01:06:53', '2019-06-18 01:06:53'),
(16, '016', 'Pidgey', 16, '2019-06-18 01:07:06', '2019-06-18 01:07:06'),
(17, '017', 'Pidgeotto', 17, '2019-06-18 01:07:25', '2019-06-18 01:07:25'),
(18, '018', 'Pidgeot', 18, '2019-06-18 01:07:50', '2019-06-18 01:07:50'),
(19, '019', 'Rattata', 19, '2019-06-18 01:08:04', '2019-06-18 01:08:04'),
(20, '020', 'Raticate', 20, '2019-06-18 01:08:19', '2019-06-18 01:08:19'),
(21, '021', 'Spearow', 21, '2019-06-18 01:08:30', '2019-06-18 01:08:30'),
(22, '022', 'Fearow', 22, '2019-06-18 01:08:43', '2019-06-18 01:08:43'),
(23, '023', 'Ekans', 23, '2019-06-18 01:08:57', '2019-06-18 01:08:57'),
(24, '024', 'Arbok', 24, '2019-06-18 01:09:11', '2019-06-18 01:09:11'),
(25, '025', 'Pikachu', 25, '2019-06-18 01:09:22', '2019-06-18 01:09:22'),
(26, '026', 'Raichu', 26, '2019-06-18 01:09:37', '2019-06-18 01:09:37'),
(27, '027', 'Sandshrew', 27, '2019-06-18 01:09:48', '2019-06-18 01:09:48'),
(28, '028', 'Sandslash', 28, '2019-06-18 01:10:06', '2019-06-18 01:10:06'),
(29, '029', 'Nidoran♀', 29, '2019-06-18 01:10:40', '2019-06-18 01:10:40'),
(30, '030', 'Nidorina', 30, '2019-06-18 01:11:01', '2019-06-18 01:11:01'),
(31, '031', 'Nidoqueen', 31, '2019-06-18 01:20:29', '2019-06-18 01:20:29');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nhat Hoang', 'hnguyen@nlstech.net', NULL, '$2y$10$PLvfqtKvqwsCDEo3S4iOA.wQ7FIm6OBOrbDx4LOR7YJp1xjM5Yt5K', NULL, '2019-06-17 21:43:00', '2019-06-17 21:43:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
