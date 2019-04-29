-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 24, 2019 at 05:27 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `algu_aprekina_sistema` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `algu_aprekina_sistema`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `algu_aprekina_sistema`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bruto` float NOT NULL,
  `taxes_employee` float NOT NULL,
  `taxes_employer` float NOT NULL,
  `neto` float NOT NULL,
  `dependents` int(2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `personal_code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `personal_code`, `email`, `role`, `password`, `created_at`) VALUES
(24, 'Janis', 'Berzins', '080187-12345', 'admin@b.lv', 'admin', '$2y$10$UiKGf8ofeQnVij6qq.hYouyg4do5Y0emsdlSSUS/g99OT6LwZ7r96', '2019-03-24 19:23:34'),
(25, 'Kristine', 'Liepa', '090180-12345', 'gramatvedis@b.lv', 'edit', '$2y$10$dWbKLWso3uCdd8DrLmJv/OQSdlMos6YKFDrZLmoJ6EwDMdvfrE99e', '2019-03-24 19:24:48'),
(26, 'Liga', 'Vanaga', '021187-12345', 'liga@b.lv', 'view', '$2y$10$oqgPEuDINjS9tA26YSxUKucV58jFqDhPtANfefkyHGZ6.PUJhpQyi', '2019-03-24 19:25:40'),
(27, 'Andra', 'Vesma', '210888-12035', 'andra@b.lv', 'view', '$2y$10$oLoA9W02erleBX8BOv8MUOgJrPX0YvVGphYl/DgyZUXueg/WWYLZa', '2019-03-25 14:15:06'),
(28, 'Lauris', 'Kleins', '110175-11039', 'lauris@b.lv', 'view', '$2y$10$QGFAhJzvLOQXEkycOucsYeTQlE6PtS88vVednYlfpgrYII7HnMKnW', '2019-03-26 11:58:21'),
(29, 'Zane', 'Vasa', '050580-10101', 'zane@b.lv', 'view', '$2y$10$LnEt3fsudTFn91hZhnGiseYfwoKwaqd7v3eBrJgmswLa6xKIceAgW', '2019-03-27 16:03:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
  
ALTER TABLE `data` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `data` (`id`, `user_id`, `bruto`, `taxes_employee`, `taxes_employer`, `neto`, `dependents`, `created_at`) VALUES
(1, 26, 886, 255.17, 213.44, 630.83, 0, '2019-04-15 11:04:28'),
(2, 27, 561, 161.57, 135.14, 399.43, 2, '2019-04-16 12:38:45'),
(3, 28, 782.5, 225.36, 188.5, 557.14, 1, '2019-04-17 16:25:31'),
(4, 29, 1240, 357.12, 298.72, 882.88, 0, '2019-04-18 09:56:00');

