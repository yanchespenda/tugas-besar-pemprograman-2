-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2020 at 02:04 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_web2`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `user_id`, `username`, `message`, `created_at`) VALUES
(1, 4, 'InterstellarIII', 'HollaI', ''),
(2, 4, 'InterstellarII', 'Tester 1', '2020-05-10T15:02:14.024Z'),
(3, 4, 'InterstellarII', 'Tester 2', '2020-05-10T15:05:15.567Z'),
(4, 4, 'InterstellarII', 'Tester 3', '2020-05-11T11:19:26.663Z'),
(5, 4, 'InterstellarII', 'Kucing Desu', '2020-05-11T13:15:55.112Z'),
(6, 4, 'InterstellarII', '!@#$%^&* desune', '2020-05-11T13:20:10.829Z'),
(7, 4, 'InterstellarII', '!@#$%^&* desune', '2020-05-11T13:20:48.637Z'),
(8, 4, 'InterstellarII', 'Kucing Desu', '2020-05-11T13:21:08.836Z'),
(9, 4, 'InterstellarII', '!@#$%^&* Desu (2)', '2020-05-11T13:29:08.525Z'),
(10, 4, 'InterstellarII', '!@#$%^&* !@#$%^&* !@#$%^&* desu', '2020-05-11T13:31:35.292Z'),
(11, 3, 'yanchespenda', 'Holla', '2020-05-12T02:04:07.287Z'),
(12, 3, 'yanchespenda', 'Saki!@#$%^&*', '2020-05-12T02:04:49.806Z'),
(13, 5, 'kurosaki', 'Test', '2020-05-12T02:44:33.901Z'),
(14, 4, 'InterstellarII', '!@#$%^&*', '2020-05-12T05:11:32.216Z');

-- --------------------------------------------------------

--
-- Table structure for table `chat_filter`
--

CREATE TABLE `chat_filter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kata` varchar(255) DEFAULT NULL,
  `last_attemp_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_filter`
--

INSERT INTO `chat_filter` (`id`, `kata`, `last_attemp_at`) VALUES
(6, 'seharian', NULL),
(7, 'kecoa', '2020-05-11 06:31:35'),
(8, 'kucing', '2020-05-11 19:04:50'),
(9, 'burung', NULL),
(10, 'anjing', NULL),
(11, 'tikus', '2020-05-11 06:31:35'),
(12, 'shit', NULL),
(13, 'puck', NULL),
(14, 'damit', NULL),
(15, 'damn it', NULL),
(16, 'car', '2020-05-11 22:11:32'),
(17, 'kedua', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat_filtered`
--

CREATE TABLE `chat_filtered` (
  `id` bigint(20) NOT NULL,
  `filter_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_filtered`
--

INSERT INTO `chat_filtered` (`id`, `filter_id`, `user_id`, `created_at`) VALUES
(1, 8, 4, '2020-05-11 06:20:11'),
(2, 8, 4, '2020-05-11 06:20:48'),
(3, 8, 4, '2020-05-11 06:21:09'),
(4, 8, 4, '2020-05-11 06:29:09'),
(5, 7, 4, '2020-05-11 06:31:35'),
(6, 8, 4, '2020-05-11 06:31:35'),
(7, 11, 4, '2020-05-11 06:31:35'),
(8, 8, 3, '2020-05-11 19:04:50'),
(9, 16, 4, '2020-05-11 22:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(3, 'yanchespenda', 'denydirgantara94@gmail.com', '$2y$10$zHWS/VBf.FPDxStdPtFs0ebtotRita6LOsDSZW97WL814LWuXfiWa', 5),
(4, 'InterstellarII', 'yanchespenda007@gmail.com', '$2y$10$Kb4j.6mTlsEoDkgZFnMVgOXp/LqM1Qe.6d/mPgh4CCXv9iweFY9.i', 5),
(5, 'kurosaki', 'kurosaki@gmail.com', '$2y$10$eQYj1mx97d4mYpgOI0/vhuhj1QKFm8121yv2.Gf.TsC94rNhZWtQy', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_constraints` (`user_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `chat_filter`
--
ALTER TABLE `chat_filter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kata` (`kata`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `chat_filtered`
--
ALTER TABLE `chat_filtered`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filtered_filter_id` (`filter_id`),
  ADD KEY `filtered_user_id` (`user_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `chat_filter`
--
ALTER TABLE `chat_filter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `chat_filtered`
--
ALTER TABLE `chat_filtered`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `user_id_constraints` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chat_filtered`
--
ALTER TABLE `chat_filtered`
  ADD CONSTRAINT `filtered_filter_id` FOREIGN KEY (`filter_id`) REFERENCES `chat_filter` (`id`),
  ADD CONSTRAINT `filtered_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
