-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2026 at 09:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`) VALUES
(1, 8, 'ab', 'sdfghjklkjh'),
(2, 8, 'ab', 'sdfghjklkjh'),
(3, 8, 'dkfbvf', 'kdhbckdv'),
(4, 8, 'dkfbvf', 'kdhbckdv'),
(5, 8, 'ho', 'hihihi'),
(6, 8, 'jsdbv', 'kjdb'),
(7, 8, 'jsdbv', 'kjdb'),
(8, 8, 'jsdbv', 'kjdb'),
(11, 18, 'qwertyu', 'sdfghjk');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `th_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_failed_login` datetime DEFAULT NULL,
  `locked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `s_name`, `th_name`, `l_name`, `email`, `phone`, `password`, `birth_date`, `role`, `created_at`, `last_login`, `profile_photo`, `failed_attempts`, `last_failed_login`, `locked_until`) VALUES
(2, 'hosni', 'mohammad', 'hosni', 'snobar', 'hosni@gmail.com', '01010101010101', '$2y$10$u8QKuMHPYOCi9cmoZy/LFe0Ks5FXezN8bLMbKK2zXqJ3QkaiNd.CC', '2003-06-24', 'user', NULL, NULL, NULL, 0, NULL, NULL),
(5, 'ahmad', 'd', 'dd', 'dddd', 'ahmad@gmail.com', '12345678901234', '$2y$10$07RhQnR/YICk91ylokK9zuxTnfAwog.PLJwzfnNQzA9jRTVkI08Pa', '2007-06-01', 'user', NULL, NULL, NULL, 0, NULL, NULL),
(6, 'Admin', 'Test', 'Account', 'User', 'admin@gmail.com', '07900000000000', '$2y$10$JpwEI1HnYdz2eK3m7LghteuunRt3FSaHBO7HswytI5iyGGsGYAgWC', '1990-01-01', 'admin', NULL, NULL, NULL, 0, NULL, NULL),
(8, 'Admin', 'Test', 'Account', 'User', 'hossni@gmail.com', '07900000000000', '$2y$10$E6flju3GwlsNDtht/46ubu31uI8hqUw6.f5Q5yNsP4BdmcdGi4kQK', '1990-01-01', 'admin', NULL, '2026-10-04 11:47:43', NULL, 0, NULL, NULL),
(9, 'khaled', 'ahmad', 'adel', 'naser', 'khaled@gmail.com', '10101010101010', '$2y$10$ypNoR.BXp2nz3AQQvD3DduZryxwD5wjUchmFh5OJVgK/TZbYzVeES', '1998-06-30', 'user', '2026-09-30 15:10:26', NULL, NULL, 0, NULL, NULL),
(11, 'khaledd', 'ahmad', 'adel', 'naser', 'khalid@gmail.com', '10101010101010', '$2y$10$o2g34GQTmEjnIhDv8MiJO.2TPLCRVOvuttEVNyxhc.bJQPfRm3ysK', '1997-08-30', 'user', '2026-09-30 15:14:11', NULL, NULL, 0, NULL, NULL),
(12, 'omar', 'hamed', 'ahmad', 'omar', 'omar@gmail.com', '01010101010101', '$2y$10$grl9G51ua9N0Wvx4byRsR.fiT.7ajAU4bcPOH6cLFSOPyE85/K70e', '1997-03-28', 'user', '2026-09-30 20:12:09', '2026-10-03 10:17:31', NULL, 0, NULL, NULL),
(13, 'yazan', 'ahmad', 'mohammad', 'hamed', 'yazan@gmail.com', '09090909090909', '$2y$10$apuKQTQyvrcBNO0QvrhCfeQk544mFy3U6IZd2m2RN.cfvx.aAL80C', '1995-09-01', 'user', '2026-10-01 08:24:38', '2026-10-01 08:25:20', NULL, 5, '2026-10-03 20:25:03', '2026-10-03 20:30:03'),
(15, 'os', 'ahmad', 'ahmad', 'ahmad', 'Osama@gmail.com', '09090909090909', '$2y$10$0O1Hrb7/jCGpF/lMVuUyEuTM0onbjpO52oPHx/NxmqDv84XmXCbXu', '2007-06-01', 'admin', '2026-10-01 09:50:22', '2026-10-02 14:20:09', NULL, 0, NULL, NULL),
(16, 'salem', 'ahmad', 'naser', 'saleem', 'salem@gmail.com', '09090909090909', '$2y$10$y5ffJE2A3Z2aH.Bq3LC7g.vzJBeYkvUgouEyeHpXxb11E2jX2D2Ra', '1992-01-14', 'user', '2026-10-02 14:20:01', NULL, NULL, 0, NULL, NULL),
(17, 'Fares', 'maher', 'ahmad', 'majed', 'fares@gmail.com', '09876543218707', '$2y$10$nAIkyByEqAJlWhYbe16b9eS3UXnX4UtwTCDZxx/W1CJcolc/WXw3G', '2002-05-03', 'user', '2026-10-03 11:20:23', '2026-10-03 14:49:41', NULL, 0, NULL, NULL),
(18, 'hosni', 'mohammad', 'hosni', 'snobarrrrrrrrr', 'hossni03@gmail.com', '00000788704086', '$2y$10$bUNckhqAlwQITQFHIvfjIOjYRlTfphjCxOpfMekdegqkv/yM0.aGu', '2003-06-24', 'user', '2026-10-04 08:37:59', '2026-10-04 11:47:07', '1791139643_Image.png', 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
