-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2025 at 08:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_vila`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_vila` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `jumlah_tamu` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_booking` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `id_user`, `id_vila`, `check_in`, `check_out`, `jumlah_tamu`, `total_harga`, `status_booking`, `created_at`) VALUES
(20, 2, 17, '2025-11-26', '2025-11-28', 4, 1800000, 'confirmed', '2025-11-26 23:52:48'),
(21, 6, 15, '2025-11-26', '2025-11-29', 90, 3000000, 'cancelled', '2025-11-26 23:55:52'),
(22, 2, 18, '2025-11-27', '2025-11-28', 2, 980000, 'cancelled', '2025-11-27 01:16:00'),
(23, 2, 15, '2025-11-27', '2025-11-28', 2, 1000000, 'confirmed', '2025-11-27 01:16:13'),
(24, 6, 15, '2025-11-27', '2025-11-29', 2, 2000000, 'confirmed', '2025-11-27 01:17:41'),
(25, 2, 14, '2025-11-28', '2025-11-29', 4, 850000, 'confirmed', '2025-11-28 00:32:19'),
(26, 2, 11, '2025-11-30', '2025-12-02', 5, 3400000, 'confirmed', '2025-11-28 00:33:34'),
(27, 2, 11, '2025-11-28', '2025-11-29', 3, 1700000, 'confirmed', '2025-11-28 00:58:15'),
(28, 2, 15, '2025-12-15', '2025-12-17', 2, 2000000, 'pending', '2025-12-15 01:28:50');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `aktivitas` varchar(255) DEFAULT NULL,
  `waktu` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_user`, `aktivitas`, `waktu`, `ip_address`, `user_agent`) VALUES
(1, 4, 'Logout dari sistem', '2025-11-27 01:15:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(2, 2, 'Login ke sistem', '2025-11-27 01:15:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(3, 2, 'Logout dari sistem', '2025-11-27 01:16:33', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(4, 6, 'Login ke sistem', '2025-11-27 01:17:18', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(5, 6, 'Logout dari sistem', '2025-11-27 01:17:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(6, 4, 'Login ke sistem', '2025-11-27 01:18:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(7, 4, 'Logout dari sistem', '2025-11-27 01:21:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(8, 4, 'Login ke sistem', '2025-11-27 01:22:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(9, 4, 'Logout dari sistem', '2025-11-27 01:54:43', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(10, 2, 'Login ke sistem', '2025-11-27 01:55:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(11, 2, 'Melihat detail vila ID: 18', '2025-11-27 01:55:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(12, 2, 'Melihat detail vila ID: 14', '2025-11-27 01:55:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(13, 2, 'Melihat detail vila ID: 13', '2025-11-27 01:55:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(14, 2, 'Melihat detail vila ID: 15', '2025-11-27 01:55:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(15, 2, 'Memberi review untuk vila ID: 15', '2025-11-27 01:57:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(16, 2, 'Melihat detail vila ID: 15', '2025-11-27 01:57:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(17, 2, 'Logout dari sistem', '2025-11-27 01:57:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(18, 4, 'Login ke sistem', '2025-11-27 01:57:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(19, 4, 'Login ke sistem', '2025-11-27 21:47:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(20, 4, 'Logout dari sistem', '2025-11-28 00:31:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(21, 2, 'Login ke sistem', '2025-11-28 00:31:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(22, 2, 'Melihat detail vila ID: 12', '2025-11-28 00:31:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(23, 2, 'Logout dari sistem', '2025-11-28 00:33:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(24, 4, 'Login ke sistem', '2025-11-28 00:33:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(25, 4, 'Menyetujui booking ID: 26', '2025-11-28 00:34:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(26, 4, 'Menyetujui booking ID: 25', '2025-11-28 00:34:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(27, 4, 'Logout dari sistem', '2025-11-28 00:34:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(28, 2, 'Login ke sistem', '2025-11-28 00:35:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(29, 2, 'Logout dari sistem', '2025-11-28 00:59:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(30, 4, 'Login ke sistem', '2025-11-28 01:00:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(31, 4, 'Menyetujui booking ID: 27', '2025-11-28 01:00:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(32, 4, 'Logout dari sistem', '2025-11-28 01:00:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(33, 2, 'Login ke sistem', '2025-11-28 01:00:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(34, 2, 'Logout dari sistem', '2025-11-28 01:16:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(35, 4, 'Login ke sistem', '2025-11-28 01:17:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(36, 4, 'Logout dari sistem', '2025-11-28 01:28:32', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(37, 2, 'Login ke sistem', '2025-11-28 01:28:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(38, 2, 'Melihat detail vila ID: 11', '2025-11-28 01:29:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(39, 2, 'Memberi review untuk vila ID: 11', '2025-11-28 01:29:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(40, 2, 'Melihat detail vila ID: 11', '2025-11-28 01:29:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(41, 2, 'Melihat detail vila ID: 14', '2025-11-28 01:30:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(42, 2, 'Memberi review untuk vila ID: 14', '2025-11-28 01:30:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(43, 2, 'Melihat detail vila ID: 14', '2025-11-28 01:30:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(44, 2, 'Melihat detail vila ID: 18', '2025-11-28 01:45:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(45, 4, 'Login ke sistem', '2025-12-01 08:53:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36'),
(46, 4, 'Login ke sistem', '2025-12-14 21:36:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36'),
(47, 4, 'Login ke sistem', '2025-12-14 21:48:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(48, 4, 'Melihat detail vila ID: 16', '2025-12-14 21:52:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(49, 4, 'Melihat detail vila ID: 16', '2025-12-14 21:57:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(50, 4, 'Melihat detail vila ID: 16', '2025-12-14 22:06:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(51, 4, 'Menambah vila: vila abal-abal', '2025-12-14 23:30:13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(52, 4, 'Menghapus vila: vila abal-abal (ID: 19)', '2025-12-14 23:35:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(53, 4, 'Menambah vila: vila abal-abal', '2025-12-14 23:39:19', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(54, 4, 'Menghapus vila: vila abal-abal (ID: 20)', '2025-12-14 23:43:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(55, 4, 'Menambah vila: vila abal-abal', '2025-12-14 23:48:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(56, 4, 'Melihat detail vila ID: 21', '2025-12-14 23:49:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(57, 4, 'Melihat detail vila ID: 21', '2025-12-14 23:57:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(58, 4, 'Menghapus vila: vila abal-abal (ID: 21)', '2025-12-15 00:07:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(59, 4, 'Menambah vila: vila abal-abal', '2025-12-15 00:13:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(60, 4, 'Menghapus vila: vila abal-abal (ID: 22)', '2025-12-15 00:13:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(61, 4, 'Menambah vila: vila abal-abal', '2025-12-15 00:14:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(62, 4, 'Mengedit vila: vila abal-abal (ID: )', '2025-12-15 00:20:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(63, 4, 'Mengedit vila: vila abal-abal (ID: 23)', '2025-12-15 00:20:54', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(64, 4, 'Mengedit vila: vila abal-abal (ID: )', '2025-12-15 00:27:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(65, 4, 'Mengedit vila: vila abal-abal (ID: 23)', '2025-12-15 00:27:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(66, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:31:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(67, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:35:47', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(68, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:35:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(69, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:35:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(70, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:42:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(71, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:50:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(72, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:55:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(73, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:56:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(74, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:56:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(75, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:57:23', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(76, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:57:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(77, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:58:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(78, 4, 'Melihat detail vila ID: 23', '2025-12-15 00:59:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(79, 4, 'Melihat detail vila ID: 11', '2025-12-15 00:59:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(80, 4, 'Melihat detail vila ID: 11', '2025-12-15 01:00:57', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(81, 4, 'Melihat detail vila ID: 11', '2025-12-15 01:01:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(82, 4, 'Melihat detail vila ID: 11', '2025-12-15 01:01:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(83, 4, 'Melihat detail vila ID: 11', '2025-12-15 01:02:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(84, 4, 'Melihat detail vila ID: 12', '2025-12-15 01:02:25', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(85, 4, 'Melihat detail vila ID: 18', '2025-12-15 01:02:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(86, 4, 'Melihat detail vila ID: 23', '2025-12-15 01:02:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(87, 4, 'Melihat detail vila ID: 23', '2025-12-15 01:03:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(88, 4, 'Melihat detail vila ID: 10', '2025-12-15 01:27:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(89, 4, 'Logout dari sistem', '2025-12-15 01:28:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(90, 2, 'Login ke sistem', '2025-12-15 01:28:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(91, 2, 'Logout dari sistem', '2025-12-15 01:31:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(92, 4, 'Login ke sistem', '2025-12-15 01:31:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(93, 4, 'Menghapus vila: vila abal-abal (ID: 23)', '2025-12-15 02:08:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0'),
(94, 4, 'Melihat detail vila ID: 11', '2025-12-15 02:09:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_vila` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id_review`, `id_user`, `id_vila`, `rating`, `review`, `created_at`) VALUES
(4, 2, 17, 4, 'ini adalah vila yang sangat bagus', '2025-11-26 23:57:49'),
(5, 2, 15, 4, 'fasilitas yang di berikan sangat baik dan ini salah satu yang terbaik di tawangmangu', '2025-11-27 01:57:15'),
(6, 2, 11, 5, 'sangat bagus dan menenangkan', '2025-11-28 01:29:47'),
(7, 2, 14, 4, 'tamannya sangat bagus', '2025-11-28 01:30:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Naufal Ajwa Nurfarros', 'naufal09@gmail.com', '$2y$10$eAL./vZAAjowvAn3FLpiOuM.hmQPAcIBKWDjFf/tu8/r0EavTlZ/y', 'user', '2025-11-21 15:47:29'),
(4, 'Admin Vila', 'admin@sewavila.test', '$1$.MbtpOMK$SyQKHDnFDHHQ9wYmpoQ5H0', 'admin', '2025-11-21 15:54:18'),
(6, 'Ravelino Bagas', 'bagas08@gmail.com', '$2y$10$finvQNFdneJGiFGY8e2pOerIAIZklrAuoh7ej2L1MgZ0zPs3RSrOa', 'user', '2025-11-26 23:55:23');

-- --------------------------------------------------------

--
-- Table structure for table `vila`
--

CREATE TABLE `vila` (
  `id_vila` int(11) NOT NULL,
  `nama_vila` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `fasilitas` text DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `latitude` decimal(20,16) DEFAULT NULL,
  `longitude` decimal(20,16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vila`
--

INSERT INTO `vila` (`id_vila`, `nama_vila`, `lokasi`, `harga`, `deskripsi`, `fasilitas`, `rating`, `gambar`, `latitude`, `longitude`) VALUES
(10, 'villa kusuma tawangamangu', 'tawangmangu', 1700000, 'Villa Kusuma Tawangmangu adalah sebuah vila luas yang menawarkan penginapan dengan 4 kamar tidur, kolam renang pribadi, dan fasilitas lengkap seperti dapur, Wi-Fi gratis, serta area keluarga dengan karaoke. Lokasinya strategis di dekat objek wisata seperti Air Terjun Grojogan Sewu dan Bukit Sekipan, serta menawarkan pemandangan pegunungan dan kota dari balkonnya. ', 'wifi, tempat parkir, dapur setiap kamar, bebas asap rokok', 4.5, '1764150022_villa kusuma tawangmangu.jpg', -7.6589470473113140, 111.1423733106797400),
(11, 'Villa puncak bukit hijau', 'tawangmangu', 1700000, 'Villa Puncak Bukit Hijau adalah sebuah vila yang terletak di daerah Tawangmangu, Kabupaten Karanganyar, Jawa Tengah, menawarkan suasana yang sejuk dan pemandangan alam yang indah. Vila ini merupakan tempat yang cocok untuk liburan keluarga atau kegiatan rekreasi karena suasananya yang tenang dan fasilitas yang memadai. ', 'kolam renang, area parkir yang luas, dapur dengan peralatan memasak lengkap, ruang keluarga, kamar tidur yang nyaman,pemanas air di kamar mandi, wifi gratis (di beberapa properti), taman atau area hijau di sekitarnya ', 5, '1764150485_villa puncak bukit hijau .jpg', -7.6591158316603245, 111.1419829787208300),
(12, 'Villa Matahari Tawangmangu', 'tawangmangu', 900000, 'Villa Matahari adalah salah satu akomodasi vila yang terletak di Tawangmangu, Karanganyar, Jawa Tengah. Vila ini sering direkomendasikan karena suasananya yang nyaman, asri, dan harganya yang dianggap terjangkau.', 'ruang tamu, tv, area barsantai, tempat parkir, BBQ', 5, '1764150609_villa matahari tawangmangu.jpg', -7.6582030472628140, 111.1420124654546400),
(13, 'Villa pikasa', 'tawangmangu', 950000, 'Meskipun Tawangmangu memiliki banyak pilihan vila, dan beberapa hasil pencarian menunjukkan daftar vila lain di Tawangmangu, hanya ada satu sebutan mengenai Villa Pikasa, Tawangmangu dalam konteks acara atau kegiatan, yang menunjukkan bahwa vila tersebut memang berada di daerah Tawangmangu.', 'dapur, area santai, area parkir, lantai parket kayu, kamar supir terpisah', 4.9, '1764150727_villa pikasa.jpg', -7.6574055608509340, 111.1424738053814600),
(14, 'Villa Teras Syariah', 'tawangmangu', 850000, 'Villa Teras Syariah Tawangmangu berlokasi di Desa Pancor Kalisoro, Tawangmangu, Karanganyar. Akomodasi ini menawarkan konsep syariah yang berfokus pada kenyamanan dan suasana kekeluargaan. Daya tarik utamanya adalah suasana yang tenang dan asri, yang sangat cocok bagi wisatawan yang ingin menikmati waktu berkualitas di alam terbuka di Tawangmangu.', 'kamar tidur luas, dapur, wifi, balkon pribadi, BBQ, area barmain anak', 4, '1764150798_villa teras syariah.jpg', -7.6598033321133850, 111.1434394006468100),
(15, 'Villa Yasalam', 'tawangmangu', 1000000, 'Villa Yassalam adalah akomodasi yang sangat direkomendasikan untuk rombongan keluarga besar atau acara kelompok, dengan kapasitas yang cukup besar. Vila ini menawarkan suasana yang sejuk khas Tawangmangu dan dilengkapi dengan fasilitas modern untuk menjamin kenyamanan.', 'kolam renang, 2 ruang keluarga, rooftop, balkon, wifi, area parkir', 4, '1764150860_villa yasalam.jpg', -7.6583412780833380, 111.1429941539591500),
(16, 'Villa kustati', 'tawangmangu', 850000, 'Dari segi tampilan, Villa Kustati menampilkan gaya yang bersahaja dan homey dengan dominasi warna kuning cerah pada eksteriornya. Bangunan ini terlihat memiliki teras yang cukup luas dengan pagar yang kokoh, ideal untuk menikmati udara pagi Tawangmangu. Dikelilingi oleh pepohonan dan tanaman hijau, vila ini menawarkan suasana yang asri dan nyaman untuk beristirahat.', 'ruang tamu, teras, area parkir, pemandangan alam, kamar mandi air panas, wifi', 4.2, '1764150921_villa kustati.jpg', -7.6605041160357720, 111.1459410935091500),
(17, 'Villa bunda hana', 'tawangmangu', 900000, 'Villa Bunda Hana adalah akomodasi vila yang terletak di daerah Blumbang, Tawangmangu, menawarkan tempat menginap yang nyaman dengan akses yang mudah ke pusat keramaian dan tempat wisata.', 'ruang keluarga, area parkir, dapur, balkon, pemandangan indah', 4, '1764151014_villa bunda hana.jpg', -7.6593132089052700, 111.1476738005215600),
(18, 'Villa Bougenville', 'tawangmangu', 980000, 'Villa Bougenville adalah salah satu pilihan akomodasi yang terkenal di Tawangmangu, menawarkan pengalaman menginap yang mewah dengan suasana yang tenang dan arsitektur unik.', 'kolam renang pribadi, tungku perapian, BBQ, wifi, jacuzzi, tanah lapang', 4.4, '1764151085_villa bougenvile.jpg', -7.6585050914591900, 111.1468047648179200);

-- --------------------------------------------------------

--
-- Table structure for table `vila_gambar`
--

CREATE TABLE `vila_gambar` (
  `id_gambar` int(11) NOT NULL,
  `id_vila` int(11) DEFAULT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vila_gambar`
--

INSERT INTO `vila_gambar` (`id_gambar`, `id_vila`, `nama_file`, `created_at`) VALUES
(1, 10, '1764150022_villa kusuma tawangmangu.jpg', '2025-12-14 15:35:47'),
(2, 11, '1764150485_villa puncak bukit hijau .jpg', '2025-12-14 15:35:47'),
(3, 12, '1764150609_villa matahari tawangmangu.jpg', '2025-12-14 15:35:47'),
(4, 13, '1764150727_villa pikasa.jpg', '2025-12-14 15:35:47'),
(5, 14, '1764150798_villa teras syariah.jpg', '2025-12-14 15:35:47'),
(6, 15, '1764150860_villa yasalam.jpg', '2025-12-14 15:35:47'),
(7, 16, '1764150921_villa kustati.jpg', '2025-12-14 15:35:47'),
(8, 17, '1764151014_villa bunda hana.jpg', '2025-12-14 15:35:47'),
(9, 18, '1764151085_villa bougenvile.jpg', '2025-12-14 15:35:47'),
(26, 10, 'vila_693f016f4862b2.32803924.jpg', '2025-12-14 18:26:55'),
(27, 10, 'vila_693f0178f418a7.85163383.png', '2025-12-14 18:27:05'),
(28, 10, 'vila_693f01800efa67.22603508.png', '2025-12-14 18:27:12'),
(29, 11, 'vila_693f055d81f8d0.26862906.png', '2025-12-14 18:43:41'),
(30, 11, 'vila_693f05619277a0.54342606.png', '2025-12-14 18:43:45'),
(31, 12, 'vila_693f060af246e0.75298986.png', '2025-12-14 18:46:34'),
(32, 12, 'vila_693f06109b2169.49607027.png', '2025-12-14 18:46:40'),
(33, 13, 'vila_693f073f367f52.89549648.png', '2025-12-14 18:51:43'),
(34, 13, 'vila_693f07439f2bd8.94935536.png', '2025-12-14 18:51:47'),
(35, 13, 'vila_693f0749427657.79305249.png', '2025-12-14 18:51:53'),
(36, 14, 'vila_693f07d534b915.75137563.png', '2025-12-14 18:54:13'),
(37, 14, 'vila_693f07da178fc1.15009189.png', '2025-12-14 18:54:18'),
(38, 14, 'vila_693f07de585907.34421489.png', '2025-12-14 18:54:22'),
(39, 15, 'vila_693f08f3631f63.67858398.png', '2025-12-14 18:58:59'),
(40, 15, 'vila_693f08f7c67c51.70752533.png', '2025-12-14 18:59:03'),
(41, 15, 'vila_693f08fca642a2.69647584.png', '2025-12-14 18:59:08'),
(42, 16, 'vila_693f09b13a2d20.80385786.png', '2025-12-14 19:02:09'),
(43, 16, 'vila_693f09b6f1b071.56640451.png', '2025-12-14 19:02:14'),
(44, 16, 'vila_693f09bbee5a96.09254624.png', '2025-12-14 19:02:19'),
(45, 17, 'vila_693f0a4d206aa0.34130166.png', '2025-12-14 19:04:45'),
(46, 17, 'vila_693f0a5217ffb1.86973519.png', '2025-12-14 19:04:50'),
(47, 17, 'vila_693f0a58783cc8.04219326.png', '2025-12-14 19:04:56'),
(48, 18, 'vila_693f0b1c885a30.92987362.png', '2025-12-14 19:08:12'),
(49, 18, 'vila_693f0b280f7330.34064719.png', '2025-12-14 19:08:24'),
(50, 18, 'vila_693f0b2f45c807.31204984.png', '2025-12-14 19:08:31'),
(51, 18, 'vila_693f0b33dc7a76.28422563.png', '2025-12-14 19:08:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_vila` (`id_vila`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_vila` (`id_vila`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vila`
--
ALTER TABLE `vila`
  ADD PRIMARY KEY (`id_vila`);

--
-- Indexes for table `vila_gambar`
--
ALTER TABLE `vila_gambar`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `id_vila` (`id_vila`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vila`
--
ALTER TABLE `vila`
  MODIFY `id_vila` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `vila_gambar`
--
ALTER TABLE `vila_gambar`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_vila`) REFERENCES `vila` (`id_vila`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_vila`) REFERENCES `vila` (`id_vila`);

--
-- Constraints for table `vila_gambar`
--
ALTER TABLE `vila_gambar`
  ADD CONSTRAINT `vila_gambar_ibfk_1` FOREIGN KEY (`id_vila`) REFERENCES `vila` (`id_vila`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
