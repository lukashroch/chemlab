-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2016 at 10:38 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `czchemlab`
--

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `temp_min` smallint(6) NOT NULL,
  `temp_max` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `parent_id`, `name`, `abbr`, `department_id`, `temp_min`, `temp_max`, `description`, `created_at`, `updated_at`) VALUES
(1, 38, 'Lednice', '', 1, 2, 8, 'Lednice - Laboratoř chemicé syntézy', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 38, 'Mrazák', '', 1, -30, -15, 'Mrazák - Laboratoř chemické syntézy', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 38, 'Skříň', '', 1, 25, 25, 'Skříň - Laboratoř chemicé syntézy', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 41, 'Organika Pevné', '', 1, 25, 25, 'Hlavní sklad chemikálií a rozpouštědel', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 42, 'Mrazák', '', 1, -20, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 43, 'Bezp. skříně', '', 2, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 43, 'Lednice', '', 2, 2, 8, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 45, 'Organika Pevné', '', 2, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 43, 'Mrazák', '', 2, -20, -4, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 37, 'Lednice', '', 1, 2, 8, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 37, 'Mrazák', '', 1, -4, -20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 37, 'Skříně', '', 1, 20, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 39, 'Prosklená skříň', '', 1, 25, 25, 'RT', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 39, 'Lednice', '', 1, 2, 8, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 39, 'Mrazák', '', 1, -20, -20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 40, 'Mrazák', '', 1, -10, -20, 'Miniaturní skladiště chemikálií pro HPLC analýzy', '0000-00-00 00:00:00', '2016-02-21 21:53:47'),
(17, 45, 'Organika Tekuté', '', 2, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 45, 'Anorganika', '', 2, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 45, 'Velké Objemy', '', 2, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 41, 'Anorganika', '', 1, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 41, 'Organika Tekuté', '', 1, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 44, 'Lednice', '', 2, 2, 8, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 44, 'Bezp. skříně', '', 2, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 44, 'Mrazák', '', 2, -20, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 43, 'Lednice Mareček', '', 2, -10, 8, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 46, 'Lednice', '', 3, 2, 8, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 46, 'Skříň', '', 3, 20, 26, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 46, 'Mrazak', '', 3, -30, -15, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 41, '(An)Organika T+', '', 1, 25, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 44, 'Skříň', '', 2, 20, 25, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 47, 'Skříň', '', 3, -30, 26, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 40, 'Lednice', '', 1, 0, 0, '', '2015-11-12 14:03:27', '2015-11-12 14:03:27'),
(34, NULL, 'Centrum Biomedicínského výzkumu', 'CBV', 1, 0, 0, '', '2016-03-14 22:39:56', '2016-03-16 21:54:35'),
(35, NULL, 'Katedra toxikologie a vojenské farmacie', 'KTVF', 2, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, NULL, 'Katedra Chemie PrF UHK', 'KCh-UHK', 3, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 34, 'Biochemie', 'BioCh', 1, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 34, 'Chemická laboratoř', 'ChL', 1, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 34, 'Proteomika', '', 1, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 34, 'Adjuvans', 'Adj', 1, 20, 20, '', '0000-00-00 00:00:00', '2016-03-16 22:37:46'),
(41, 34, 'Sklad', '', 1, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 34, 'Chodba', '', 1, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 35, 'Chemická laboratoř', 'ChL', 2, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 35, 'Biochemie', 'BioCh', 2, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 35, 'Sklad', '', 2, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 36, 'Laboratoř Chemie 3', 'LCh3', 3, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 36, 'Laboratoř Chemie 6', 'LCh6', 3, 20, 20, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stores_department_id_foreign` (`department_id`),
  ADD KEY `stores_name_index` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
