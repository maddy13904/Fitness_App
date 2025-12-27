-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2025 at 10:00 AM
-- Server version: 8.0.42
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `confirm_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `full_name`, `email`, `password`, `confirm_password`, `created_at`) VALUES
(1, 'saisuryha', 'saisuryha12@gmail.com', 'sidh123', 'sidh123', '2025-06-16 13:28:55'),
(2, 'sidharth', 'sidh09@gmail.com', 'sidh123456', 'sidh123456', '2025-06-16 13:38:09'),
(3, 'Admin ranjith', 'srimathi1@gmail.com', 'admin123', 'admin123', '2025-08-01 03:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `id` int NOT NULL,
  `admin_id` int DEFAULT NULL,
  `creator_user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mode` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `metric` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `admin_id`, `creator_user_id`, `title`, `description`, `start_date`, `end_date`, `created_at`, `mode`, `metric`, `duration`, `image_url`) VALUES
(1, 1, NULL, '30-Day Pushup Challenge', 'Do 100 pushups every day', '2020-07-25', '2020-08-25', '2025-06-16 13:47:15', NULL, NULL, NULL, NULL),
(2, 1, NULL, '30-Day situps Challenge', 'Do 100 situps every day', '2020-08-25', '2020-09-25', '2025-06-16 13:47:53', NULL, NULL, NULL, NULL),
(3, 2, NULL, '30-Day squats Challenge', 'Do 100 squats every day', '2020-08-25', '2020-09-25', '2025-06-16 13:48:21', NULL, NULL, NULL, NULL),
(4, NULL, 1, 'My First User Challenge', 'A fun challenge to test the app', '2025-09-08', NULL, '2025-09-07 11:53:34', 'LEADERBOARD', 'Steps', 7, NULL),
(5, NULL, 4, 'My First User Challenge', 'A fun challenge to test the app', '2025-09-08', NULL, '2025-09-07 12:09:19', 'LEADERBOARD', 'Steps', 7, NULL),
(6, NULL, 1, 'test', 'testing', '2025-09-08', NULL, '2025-09-07 13:04:29', 'LEADERBOARD', 'Steps', 7, NULL),
(7, NULL, 1, 'fgh', 'dfg', '2025-09-08', NULL, '2025-09-07 13:05:13', 'LEADERBOARD', 'Steps', 7, NULL),
(8, NULL, 1, 'testing', 'testing', '2025-09-08', NULL, '2025-09-07 13:21:14', 'LEADERBOARD', 'Steps', 7, NULL),
(9, NULL, 1, 'testing ', 'test one', '2025-09-08', NULL, '2025-09-07 14:43:07', 'LEADERBOARD', 'Steps', 7, NULL),
(10, NULL, 1, 'new', 'new', '2025-09-08', NULL, '2025-09-07 15:14:24', 'LEADERBOARD', 'Steps', 7, NULL),
(11, NULL, 1, 'kadupu', 'imp', '2025-09-08', NULL, '2025-09-07 15:19:43', 'LEADERBOARD', 'Steps', 7, NULL),
(12, NULL, 1, 'run', 'run for life', '2025-09-08', NULL, '2025-09-07 15:26:14', 'LEADERBOARD', 'Steps', 7, NULL),
(13, NULL, 1, 'walk', 'walk-in ', '2025-09-08', NULL, '2025-09-07 15:44:35', 'LEADERBOARD', 'Steps', 7, NULL),
(14, NULL, 1, 'swim', 'swimming', '2025-09-08', NULL, '2025-09-08 03:27:27', 'LEADERBOARD', 'Steps', 7, NULL),
(15, NULL, 1, 'sidh challenge', 'new', '2025-09-08', NULL, '2025-09-08 04:59:45', 'LEADERBOARD', 'Steps', 7, NULL),
(16, NULL, 1, 'sidh challenge', 'new', '2025-09-08', NULL, '2025-09-08 04:59:47', 'LEADERBOARD', 'Steps', 7, NULL),
(17, NULL, 1, 'gusnbs', 'bjshsban', '2025-09-08', NULL, '2025-09-08 05:25:49', 'LEADERBOARD', 'Steps', 7, NULL),
(18, NULL, 5, 'test 4', 'testing', '2025-09-08', NULL, '2025-09-08 05:40:40', 'LEADERBOARD', 'Steps', 7, NULL),
(19, NULL, 5, 'rgcvb', 'fhvjbk', '2025-09-08', NULL, '2025-09-08 08:16:05', 'LEADERBOARD', 'Steps', 7, NULL),
(20, NULL, 5, 'walk nithish', 'walking', '2025-09-08', NULL, '2025-09-09 03:15:29', 'LEADERBOARD', 'Steps', 7, NULL),
(21, NULL, 5, 'drdc', 'yftf', '2025-09-08', NULL, '2025-09-18 05:35:27', 'LEADERBOARD', 'Steps', 7, NULL),
(22, NULL, 10, 'run', 'running', '2025-09-20', NULL, '2025-09-20 11:23:43', 'leaderboard', 'nil', 3, NULL),
(23, NULL, 5, 'talking', 'talk for a day', '2025-09-20', NULL, '2025-09-20 11:44:13', 'LEADERBOARD', 'Steps', 3, NULL),
(24, NULL, 6, 'review', 'revieww', '2025-09-22', NULL, '2025-09-22 05:16:27', 'LEADERBOARD', 'Steps', 3, NULL),
(25, NULL, 6, 'water', 'water', '2025-09-22', NULL, '2025-09-22 05:17:06', 'DAILY HABIT', 'Read for 15 minutes', 7, NULL),
(26, NULL, 6, 'kkssj', 'hsjjs', '2025-10-11', NULL, '2025-10-11 13:26:48', 'STREAK', 'Steps', 7, NULL),
(27, NULL, 6, 'ghb', 'sfc', '2025-10-11', NULL, '2025-10-11 13:36:26', 'STREAK', 'Steps', 7, NULL),
(28, NULL, 6, 'yvjbo', 'nvjcjc', '2025-10-11', NULL, '2025-10-11 14:16:17', 'DAILY HABIT', 'Drink 8 glasses of water', 7, NULL),
(29, NULL, 6, 'run', 'hjs', '2025-10-11', NULL, '2025-10-11 14:17:48', 'VIRTUAL RACE', '2', 7, NULL),
(30, NULL, 6, 'fff', '', '2025-10-11', NULL, '2025-10-11 14:18:06', 'VIRTUAL RACE', '2', 7, NULL),
(31, NULL, 6, 'hjkm', 'eef', '2025-10-11', NULL, '2025-10-11 14:21:14', 'DAILY HABIT', 'Drink 8 glasses of water', 7, NULL),
(32, NULL, 6, 'hchc', '', '2025-10-11', NULL, '2025-10-11 14:27:57', 'STREAK', 'Steps', 7, NULL),
(33, NULL, 6, 'yxf', 'fyfg', '2025-10-14', NULL, '2025-10-14 04:35:00', 'DAILY HABIT', 'Read for 15 minutes', 7, NULL),
(34, NULL, 43, 'uejnen', 'jeinens', '2025-10-16', NULL, '2025-10-16 08:34:24', 'LEADERBOARD', 'Distance', 7, NULL),
(35, NULL, 6, 'steps', 'steps', '2025-10-22', NULL, '2025-10-22 14:25:54', 'LEADERBOARD', 'Steps', 7, NULL),
(36, NULL, 5, 'steps', 'steps', '2025-10-22', NULL, '2025-10-22 14:28:41', 'LEADERBOARD', 'Steps', 7, NULL),
(37, NULL, 5, 'steps', 'ste', '2025-10-22', NULL, '2025-10-22 14:35:29', 'LEADERBOARD', 'Steps', 7, NULL),
(38, NULL, 5, 'steps', 'steps', '2025-10-22', NULL, '2025-10-22 14:50:05', 'LEADERBOARD', 'Steps', 7, NULL),
(39, NULL, 5, 'hhh', 'hhhh', '2025-10-22', NULL, '2025-10-22 14:51:17', 'LEADERBOARD', 'Steps', 7, NULL),
(40, NULL, 5, 'uh', 'uh', '2025-10-22', NULL, '2025-10-22 14:51:39', 'LEADERBOARD', 'Steps', 7, NULL),
(41, NULL, 5, 'steps', 'steps', '2025-10-22', NULL, '2025-10-22 14:52:55', 'LEADERBOARD', 'Steps', 7, NULL),
(42, NULL, 5, 'hu', 'hu', '2025-10-22', NULL, '2025-10-22 14:59:27', 'LEADERBOARD', 'Steps', 7, NULL),
(43, NULL, 5, 'Test', 'testing', '2025-10-25', NULL, '2025-10-22 15:04:53', 'LEADERBOARD', 'Steps', 7, NULL),
(44, NULL, 5, 'Test', 'testing', '2025-10-25', NULL, '2025-10-22 15:10:03', 'LEADERBOARD', 'Steps', 7, NULL),
(45, NULL, 5, 'Test', 'testing', '2025-10-25', NULL, '2025-10-22 15:11:29', 'LEADERBOARD', 'Steps', 7, NULL),
(46, NULL, 5, 'Test', 'testing', '2025-10-25', NULL, '2025-10-22 15:14:28', 'LEADERBOARD', 'Steps', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `challenge_invites`
--

CREATE TABLE `challenge_invites` (
  `id` int NOT NULL,
  `challenge_id` int NOT NULL,
  `inviter_id` int NOT NULL,
  `invitee_id` int NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challenge_invites`
--

INSERT INTO `challenge_invites` (`id`, `challenge_id`, `inviter_id`, `invitee_id`, `status`, `created_at`) VALUES
(1, 2, 3, 1, 'pending', '2025-06-16 14:24:22'),
(2, 2, 1, 5, 'rejected', '2025-10-11 13:00:37'),
(4, 3, 1, 5, 'accepted', '2025-10-11 13:05:13'),
(5, 1, 1, 5, 'accepted', '2025-10-11 13:05:31'),
(6, 6, 6, 5, 'accepted', '2025-10-11 13:22:18'),
(7, 42, 5, 6, 'pending', '2025-10-22 15:00:04'),
(8, 42, 5, 10, 'pending', '2025-10-22 15:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `challenge_participants`
--

CREATE TABLE `challenge_participants` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `challenge_id` int NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `challenge_participants`
--

INSERT INTO `challenge_participants` (`id`, `user_id`, `challenge_id`, `joined_at`) VALUES
(1, 1, 3, '2025-06-16 13:56:03'),
(2, 1, 4, '2025-09-07 11:53:34'),
(3, 4, 5, '2025-09-07 12:09:19'),
(4, 1, 6, '2025-09-07 13:04:29'),
(5, 1, 7, '2025-09-07 13:05:13'),
(6, 1, 8, '2025-09-07 13:21:14'),
(7, 1, 9, '2025-09-07 14:43:07'),
(8, 1, 10, '2025-09-07 15:14:24'),
(9, 1, 11, '2025-09-07 15:19:43'),
(10, 1, 12, '2025-09-07 15:26:14'),
(11, 1, 13, '2025-09-07 15:44:35'),
(12, 1, 14, '2025-09-08 03:27:27'),
(13, 1, 15, '2025-09-08 04:59:45'),
(14, 1, 16, '2025-09-08 04:59:47'),
(15, 1, 17, '2025-09-08 05:25:49'),
(16, 5, 18, '2025-09-08 05:40:40'),
(17, 5, 19, '2025-09-08 08:16:05'),
(18, 5, 20, '2025-09-09 03:15:29'),
(19, 5, 21, '2025-09-18 05:35:27'),
(20, 10, 22, '2025-09-20 11:23:43'),
(21, 5, 23, '2025-09-20 11:44:13'),
(22, 6, 23, '2025-09-21 11:29:56'),
(23, 6, 1, '2025-09-21 12:26:20'),
(32, 4, 1, '2025-09-21 12:38:14'),
(42, 6, 24, '2025-09-22 05:16:27'),
(43, 6, 25, '2025-09-22 05:17:06'),
(44, 5, 1, '2025-10-11 13:06:06'),
(45, 5, 3, '2025-10-11 13:06:48'),
(46, 6, 26, '2025-10-11 13:26:48'),
(47, 6, 27, '2025-10-11 13:36:26'),
(48, 6, 28, '2025-10-11 14:16:17'),
(49, 6, 29, '2025-10-11 14:17:48'),
(50, 6, 30, '2025-10-11 14:18:06'),
(51, 6, 31, '2025-10-11 14:21:14'),
(52, 6, 32, '2025-10-11 14:27:57'),
(53, 5, 6, '2025-10-11 14:29:37'),
(55, 6, 33, '2025-10-14 04:35:00'),
(56, 43, 34, '2025-10-16 08:34:24'),
(57, 43, 2, '2025-10-16 08:45:17'),
(59, 6, 35, '2025-10-22 14:25:54'),
(60, 5, 36, '2025-10-22 14:28:41'),
(61, 5, 37, '2025-10-22 14:35:29'),
(62, 5, 38, '2025-10-22 14:50:05'),
(63, 5, 39, '2025-10-22 14:51:17'),
(64, 5, 40, '2025-10-22 14:51:39'),
(65, 5, 41, '2025-10-22 14:52:55'),
(66, 5, 42, '2025-10-22 14:59:27'),
(67, 5, 43, '2025-10-22 15:04:53'),
(68, 5, 44, '2025-10-22 15:10:03'),
(69, 5, 45, '2025-10-22 15:11:29'),
(70, 5, 46, '2025-10-22 15:14:28'),
(71, 6, 2, '2025-10-24 12:48:01'),
(84, 6, 3, '2025-10-24 13:41:55'),
(99, 10, 1, '2025-10-25 07:26:23'),
(103, 16, 1, '2025-10-25 07:53:57'),
(107, 6, 46, '2025-10-27 07:42:47'),
(108, 7, 41, '2025-11-17 15:23:06'),
(109, 7, 1, '2025-11-17 15:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `daily_steps`
--

CREATE TABLE `daily_steps` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `step_date` date NOT NULL,
  `step_count` int NOT NULL,
  `calories_burned` float NOT NULL,
  `distance_km` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_steps`
--

INSERT INTO `daily_steps` (`id`, `user_id`, `device_id`, `step_date`, `step_count`, `calories_burned`, `distance_km`) VALUES
(1, 5, '', '2025-09-05', 1000, 60, 0),
(2, 1, '', '2025-09-05', 110, 4.4, 0),
(43, 1, '', '2025-09-06', 16, 0.64, 0),
(63, 1, '', '2025-09-07', 62, 2.48, 0),
(82, 1, '', '2025-09-08', 3279, 131.16, 0),
(91, 1, '', '2025-09-09', 12, 0.48, 0),
(94, 1, '', '2025-09-18', 0, 0, 0),
(97, 1, 'b8174308d4743368', '2025-09-18', 0, 0, 0),
(107, 1, 'b9815781c7175ebd', '2025-09-18', 0, 0, 0),
(128, 1, '08e887c0600d37e4', '2025-09-18', 18, 0.72, 0),
(135, 1, '08e887c0600d37e4', '2025-09-19', 0, 0, 0),
(151, 1, '08e887c0600d37e4', '2025-09-20', 30, 1.2, 0),
(177, 1, '08e887c0600d37e4', '2025-09-21', 29, 1.16, 0),
(201, 1, '9622d324a203b185', '2025-09-22', 0, 0, 0),
(205, 1, 'b8174308d4743368', '2025-09-22', 23, 0.92, 0),
(213, 1, '08e887c0600d37e4', '2025-09-28', 0, 0, 0),
(215, 1, '08e887c0600d37e4', '2025-10-11', 0, 0, 0),
(232, 1, '08e887c0600d37e4', '2025-10-13', 0, 0, 0),
(234, 1, '7513353282d093aa', '2025-10-14', 0, 0, 0),
(241, 1, '08e887c0600d37e4', '2025-10-15', 0, 0, 0),
(242, 1, 'b9815781c7175ebd', '2025-10-16', 35, 1.4, 0),
(259, 1, '08e887c0600d37e4', '2025-10-17', 17, 0.68, 0),
(284, 1, '08e887c0600d37e4', '2025-10-18', 0, 0, 0),
(286, 1, '08e887c0600d37e4', '2025-10-22', 10, 0.4, 0),
(297, 6, '08e887c0600d37e4', '2025-10-24', 230, 9.2, 0.176923),
(316, 6, '08e887c0600d37e4', '2025-10-25', 83, 3.32, 0.0638462),
(326, 5, '08e887c0600d37e4', '2025-10-25', 11, 0.44, 0.00846154),
(329, 3, '08e887c0600d37e4', '2025-10-25', 11, 0.44, 0.00846154),
(330, 5, '7513353282d093aa', '2025-10-27', 0, 0, 0),
(332, 6, '7513353282d093aa', '2025-10-27', 0, 0, 0),
(338, 5, '08e887c0600d37e4', '2025-11-10', 0, 0, 0),
(339, 46, '08e887c0600d37e4', '2025-11-10', 25, 1, 0.0192308),
(340, 3, '4c0a086280df050c', '2025-11-17', 0, 0, 0),
(341, 7, '4c0a086280df050c', '2025-11-17', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`) VALUES
(1, 1, 3, 'accepted', '2025-06-16 13:58:52'),
(2, 3, 1, 'accepted', '2025-06-16 14:07:17'),
(3, 7, 8, 'accepted', '2025-09-18 14:57:22'),
(4, 1, 8, 'pending', '2025-09-18 14:57:31'),
(5, 1, 4, 'pending', '2025-09-18 15:31:32'),
(6, 1, 10, 'accepted', '2025-09-18 15:34:34'),
(7, 5, 10, 'accepted', '2025-09-19 11:24:46'),
(8, 3, 5, 'accepted', '2025-09-19 11:36:16'),
(9, 5, 6, 'accepted', '2025-09-19 11:47:27'),
(10, 5, 9, 'pending', '2025-09-22 04:27:56'),
(11, 6, 41, 'pending', '2025-10-17 07:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `score` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pushup_results`
--

CREATE TABLE `pushup_results` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `challenge_id` int DEFAULT NULL,
  `pushup_count` int DEFAULT NULL,
  `recorded_date` date DEFAULT NULL,
  `recorded_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pushup_results`
--

INSERT INTO `pushup_results` (`id`, `user_id`, `challenge_id`, `pushup_count`, `recorded_date`, `recorded_at`) VALUES
(1, 1, 1, 42, '2025-09-21', '2025-08-08 00:00:00'),
(2, 3, 1, 18, '2025-09-21', '2025-08-08 00:00:00'),
(3, 4, 1, 32, '2025-09-21', '2025-08-08 00:00:00'),
(6, 6, 1, 11, '2025-09-21', '2025-09-21 19:41:59'),
(8, 6, 1, 4, '2025-09-22', '2025-09-22 10:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `height` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `weight` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `fitness_level` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `weekly_goal` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_general_ci,
  `profile_photo_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_general_ci DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `phone`, `height`, `weight`, `age`, `fitness_level`, `weekly_goal`, `bio`, `profile_photo_url`, `password`, `role`, `created_at`) VALUES
(1, 'Nithish Kumar G', 'nithifit', 'nithish.kumar@gmail.com ', '+91 9876543210', '5\'9\"', '140 lbs', 21, 'Intermediate', '5 workouts per week', 'runner', 'C:\\Users\\MOHANK~1.S\\AppData\\Local\\Temp/fitness_uploads/user_1_1760182645.png', '$2y$10$sWdLTjpX5YqQv2AgkVf06.PAutFxgHbbH7eDeLF5s7EA/fd/WiLIG', 'user', '2025-06-16 13:20:24'),
(3, 'sidh', 'sidharth', 'sidh@gmail.com', '8056764242', '150', '60', 25, 'Expert', 'run', '', NULL, '123user', 'user', '2025-06-16 13:21:29'),
(4, 'sidharth', NULL, 'sidharth@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123user123', 'user', '2025-06-16 13:21:50'),
(5, 'sai', 'suryha', 'sai12@gmail.com', '8056766113', '174', '61', 21, 'Advanced', 'burn2k calories', '', NULL, '1234', 'user', '2025-08-11 05:30:43'),
(6, 'suryha', 'suryhafit', 'sai2@gmail.com ', '8056766113', '150', '60', 21, 'Intermediate', '5 workouts per week', '', 'C:\\Users\\MOHANK~1.S\\AppData\\Local\\Temp/fitness_uploads/user_6_1761549636.jpg', '1234', 'user', '2025-08-11 08:24:52'),
(7, 'ak', NULL, 'ak@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234', 'user', '2025-08-11 08:35:13'),
(8, 'ak', NULL, 'ak@gmail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234', 'user', '2025-08-11 08:35:29'),
(9, '', '', '', '', '', '', 0, '', '', '', NULL, '1234', 'user', '2025-08-11 08:37:23'),
(10, 'akak', NULL, 'q@gnail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123', 'user', '2025-08-11 08:39:00'),
(11, 'saisu', NULL, 'saisu@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$luJxPnvIJ0idtSkvtZVNSekmeC21VRh1eAsS.W13o08WnZCSBrXJW', 'user', '2025-08-20 04:05:33'),
(12, 'saisu', NULL, 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$U0F/VL2YL6yNjVwcEzQ4YuKxI6UvhtGEKxMufv9lg0uAj3zPCiG6y', 'admin', '2025-08-20 04:06:05'),
(16, 'saisu', NULL, 'admin3@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$5RBqnU5uGlCpfflYaiA/beGr54Zp4x2prO9.nEspV4ESM35EkupEW', 'admin', '2025-08-20 04:10:21'),
(20, 'saisu', NULL, 'admin53@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$KywTW6ON9BZJGUrlXqdK/OLawmFc8byR1tWj20Z.zxuBoyuSWyckS', 'admin', '2025-08-20 04:10:56'),
(21, 'saisu', NULL, 'admin54@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234', 'admin', '2025-08-20 04:12:19'),
(23, 'saisu', NULL, 'admin59@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234', 'admin', '2025-08-20 04:17:40'),
(24, 'sai', NULL, 'sai@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345', 'user', '2025-08-20 04:49:24'),
(25, 'Ranjith Kumar', NULL, 'mrbadlydevilrk@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4567', 'user', '2025-08-20 05:10:20'),
(27, 'frff', NULL, 'fff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'as', 'user', '2025-08-21 04:52:02'),
(31, 'test124', NULL, 'test@gmaul.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123', 'user', '2025-08-28 03:11:17'),
(32, 'suryha', NULL, 'suryha12@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Suryha@09', 'user', '2025-08-28 03:13:01'),
(34, 'suryha', NULL, 'admin5@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin123', 'admin', '2025-09-08 05:14:55'),
(38, 'tg', NULL, 'tg1@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Suryha@09', 'user', '2025-10-15 04:44:23'),
(39, 'gh', NULL, 'gj@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Saisuryha@09', 'user', '2025-10-15 04:57:17'),
(40, 'Kanchana Jayapragkesh', NULL, 'kanchanajayapragkesh@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sidhu@09', 'user', '2025-10-15 05:02:36'),
(41, 'suryha', NULL, 'saisuryha12@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Saisuryha@09', 'user', '2025-10-16 05:39:46'),
(42, 'suryha', NULL, 'saisuryha1222@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Suryha@00', 'user', '2025-10-16 05:40:42'),
(43, 'r54', 'dh@123', '5@g.c', '36985240', '0', '0', 1, 'Beginner', '1', '', NULL, 'Dhanush@123', 'user', '2025-10-16 08:25:15'),
(44, 'suryha', NULL, 'suri@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Suryha@09', 'user', '2025-11-10 08:04:55'),
(45, 'suryha', NULL, 'surii@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Suryha@09', 'user', '2025-11-10 08:07:18'),
(46, 'suryha', NULL, 'fj@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Suryha@09', 'user', '2025-11-10 08:46:20'),
(47, 'ranjith', NULL, 'ranjithkumar@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$XqJ/f9EKNE0SVbzxROQfCO1pL8WNQsCrveKq8RQ5MRes4pqyGQEp2', 'user', '2025-11-17 15:17:31');

-- --------------------------------------------------------

--
-- Table structure for table `user_goals`
--

CREATE TABLE `user_goals` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `progress` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_goals`
--

INSERT INTO `user_goals` (`id`, `user_id`, `title`, `progress`, `created_at`) VALUES
(1, 32, 'run 5km', 0, '2025-10-18 06:27:10'),
(3, 5, 'meditate', 0, '2025-10-18 06:29:27'),
(4, 5, 'running', 0, '2025-10-18 07:51:22'),
(5, 6, 'eat apple daily', 0, '2025-10-24 12:46:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `creator_user_id` (`creator_user_id`);

--
-- Indexes for table `challenge_invites`
--
ALTER TABLE `challenge_invites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_invite` (`challenge_id`,`invitee_id`),
  ADD KEY `inviter_id` (`inviter_id`),
  ADD KEY `invitee_id` (`invitee_id`);

--
-- Indexes for table `challenge_participants`
--
ALTER TABLE `challenge_participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_challenge` (`user_id`,`challenge_id`),
  ADD KEY `challenge_id` (`challenge_id`);

--
-- Indexes for table `daily_steps`
--
ALTER TABLE `daily_steps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_device_date_unique` (`user_id`,`device_id`,`step_date`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_request` (`sender_id`,`receiver_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pushup_results`
--
ALTER TABLE `pushup_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_goals`
--
ALTER TABLE `user_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `challenge_invites`
--
ALTER TABLE `challenge_invites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `challenge_participants`
--
ALTER TABLE `challenge_participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `daily_steps`
--
ALTER TABLE `daily_steps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pushup_results`
--
ALTER TABLE `pushup_results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_goals`
--
ALTER TABLE `user_goals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `challenges_ibfk_2` FOREIGN KEY (`creator_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `challenge_invites`
--
ALTER TABLE `challenge_invites`
  ADD CONSTRAINT `challenge_invites_ibfk_1` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`),
  ADD CONSTRAINT `challenge_invites_ibfk_2` FOREIGN KEY (`inviter_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `challenge_invites_ibfk_3` FOREIGN KEY (`invitee_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `challenge_participants`
--
ALTER TABLE `challenge_participants`
  ADD CONSTRAINT `challenge_participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `challenge_participants_ibfk_2` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`);

--
-- Constraints for table `daily_steps`
--
ALTER TABLE `daily_steps`
  ADD CONSTRAINT `daily_steps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
