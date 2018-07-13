-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2018 at 03:48 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nikooma`
--

-- --------------------------------------------------------

--
-- Table structure for table `dastrasi`
--

CREATE TABLE `dastrasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grup_id` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `dastrasi` varchar(5000) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `dastrasi`
--

INSERT INTO `dastrasi` (`id`, `grup_id`, `dastrasi`) VALUES
(1, '1', ';R01S01;R01S02;R23S06;R23S02;R23S04;R23S05;R02S01;R02S02;R02S03;R02S04;R02S05;R03S02;R03S03;R03S04;R03S05;R04S01;R04S02;R05S01;R05S02;R05S03;R05S04;R05S05;R06S01;R06S02;R07S01;R07S02;R07S03;R07S04;R07S05;R08S01;R09S01;R09S02;R10S01;R10S02;R10S03;R10S04;R10S05;R11S01;R11S02;R12S01;R12S02;R13S01;R13S02;R14S01;R14S02;R14S03;R14S04;R14S05;R14S06;R14S07;R14S08;R15S01;R15S02;R15S03;R15S04;R15S05;R16S01;R16S02;R16S03;R16S04;R16S05;R17S01;R17S02;R17S03;R17S04;R17S05;R18S01;R18S03;R18S04;R18S05;R19S01;R19S02;R19S03;R19S04;R19S05;R20S01;R20S02;R20S03;R20S04;R20S05;R21S01;R21S02;R21S03;R21S04;R21S05;R22S01;R22S02;R22S03;R22S04;R22S05;R24S01;R24S02;R24S03;R24S04;R24S05;R25S01;R25S02;R26S01;R26S02;R23S03;R23S01;R01S01;R03S01;');

-- --------------------------------------------------------

--
-- Table structure for table `group_khayerin`
--

CREATE TABLE `group_khayerin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `users_id` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grup`
--

CREATE TABLE `grup` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `group_id` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `grup`
--

INSERT INTO `grup` (`id`, `name`, `group_id`, `create_at`, `updated_at`) VALUES
(1, 'مدیر سیستم', '1', '2018-06-17 00:23:01', '0000-00-00 00:00:00'),
(2, 'خیرین', '2', '2018-06-17 18:53:43', '2018-06-17 18:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `heyat_omana`
--

CREATE TABLE `heyat_omana` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kheyrie_id` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khayerin`
--

CREATE TABLE `khayerin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `address` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `shoghl` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kheyrie`
--

CREATE TABLE `kheyrie` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `onvan` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `maharat_code` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `mahdoode` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maharat_kheyrie`
--

CREATE TABLE `maharat_kheyrie` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kheyrie_id` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `modir_name` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manabe_kheyrie`
--

CREATE TABLE `manabe_kheyrie` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kheyrie_id` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tajhizat_kheyrie`
--

CREATE TABLE `tajhizat_kheyrie` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kheyrie_id` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_khayer`
--

CREATE TABLE `tbl_khayer` (
  `kh_name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `kh_family` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `kh_id` mediumint(9) NOT NULL,
  `kh_mobile` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `kh_address` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `kh_shoghl` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `kh_jensiat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_khayer`
--

INSERT INTO `tbl_khayer` (`kh_name`, `kh_family`, `kh_id`, `kh_mobile`, `kh_address`, `kh_shoghl`, `kh_jensiat`) VALUES
('مجید', 'ظهراب بیگی', 1, '244334', 'اراک', 'کارمندمخابرات', 1),
('محمد', 'بخشی', 2, '09183683829', 'اراک مسچد امام حسین', 'پاسدار', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_khayergroup`
--

CREATE TABLE `tbl_khayergroup` (
  `kg_id` mediumint(9) NOT NULL,
  `kg_khayerid` mediumint(9) NOT NULL,
  `kg_groupid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_niazgroups`
--

CREATE TABLE `tbl_niazgroups` (
  `ng_id` bigint(20) NOT NULL,
  `ng_niazmand` bigint(20) NOT NULL,
  `ng_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_niazmandan`
--

CREATE TABLE `tbl_niazmandan` (
  `n_id` bigint(20) NOT NULL,
  `n_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `n_family` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `n_pedar` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `n_shenasnameh` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `n_meli` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `n_tarikhtavalod` timestamp NULL DEFAULT NULL,
  `n_mahaltavalod` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `n_shoghl` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `n_daramad` int(11) NOT NULL,
  `n_bimeh` int(11) NOT NULL,
  `n_mizantahsilat` int(11) NOT NULL,
  `n_maharat` varchar(1000) COLLATE utf8_persian_ci NOT NULL,
  `n_yaraneh` int(11) NOT NULL,
  `n_hamsar` tinyint(1) NOT NULL,
  `n_melihamsar` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `n_shoghlhamsar` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `n_noemanzel` int(11) NOT NULL,
  `n_addressmanzel` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `n_codeposti` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `n_telephone` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `n_mobile` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `n_elateniaz` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `n_vaziatejesmani` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `n_jensiat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_niazmandtakafol`
--

CREATE TABLE `tb_niazmandtakafol` (
  `nt_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `nt_family` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `nt_pedar` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `nt_meli` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `nt_tavalod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nt_tahsil` int(11) NOT NULL,
  `nt_taahol` int(11) NOT NULL,
  `nt_codesarparast` bigint(20) NOT NULL,
  `nt_jesmani` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `nt_maharat` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL,
  `nt_jensiat` int(11) NOT NULL,
  `nt_mahaltahsil` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `nt_dorehamoozeshi` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL,
  `nt_daramad` mediumint(9) NOT NULL DEFAULT '0',
  `nt_bimeh` int(11) NOT NULL,
  `nt_shoghl` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `nt_sepordehbanki` mediumint(9) NOT NULL DEFAULT '0',
  `nt_yaraneh` int(11) NOT NULL DEFAULT '0',
  `nt_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tb_niazmandtakafol`
--

INSERT INTO `tb_niazmandtakafol` (`nt_name`, `nt_family`, `nt_pedar`, `nt_meli`, `nt_tavalod`, `nt_tahsil`, `nt_taahol`, `nt_codesarparast`, `nt_jesmani`, `nt_maharat`, `nt_jensiat`, `nt_mahaltahsil`, `nt_dorehamoozeshi`, `nt_daramad`, `nt_bimeh`, `nt_shoghl`, `nt_sepordehbanki`, `nt_yaraneh`, `nt_id`) VALUES
('الینا', 'ظهراب بیگی', 'مجید', '4342234432', '2014-12-31 20:30:00', 1, 2, 1, 'سالم', 'ندارد', 2, NULL, NULL, 1, 2, 'بیکار', 0, 45500, 1),
('علی', 'بخشی', 'محمد', '1111111111', '2007-12-31 20:30:00', 2, 2, 2, 'سالم', 'ندارد', 1, NULL, NULL, 1, 3, 'محصل', 0, 45500, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `u_lname` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `u_image` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `lastlogip` varchar(100) DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `u_mobilenumber` varchar(15) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `email`, `password`, `remember_token`, `lastlogin`, `u_lname`, `u_image`, `lastlogip`, `username`, `u_mobilenumber`, `updated_at`, `created_at`, `id`) VALUES
('مجید', 'majidmjz2012@gmail.com', '$2y$10$KLvW0yTrxG2saO/n6jIcgOwHC2bvD.P3CGKiB5YDmg8zc.LWYHjVi', 'vF74otfUlzEVOtdFDIg5aFISOtSnP3DwBuiyah4zzmTOTLme8a5idxtQXK3M', '2018-06-16 23:47:58', 'ظهراب بیگی', NULL, NULL, 'majidmjz', '09185997865', '2018-06-16 23:47:58', '2018-06-16 23:47:58', 1),
('محمد', 'm@m.ir', '$2y$10$SwKfkwPBx3.MI1W0niFHBea4...R3HUODz8x8HyK7u2/B1KJHr0.y', 'ijbccKqWV3PaNZb8Min9Qk2z8d7tV0YYDsEoT0NYcH9IyeHr9h15lZJYHbY0', '2018-06-19 03:39:50', 'بخشی', '../images/avatar.png', NULL, 'alamdar', '09183683829', '2018-06-19 03:39:50', '2018-06-19 03:39:50', 2),
('سعید', 'saeedzolfali.z@gmail.com', '$2y$10$KUAij6vnVg3AyeJGRtD6.OCQ5FAJ0bW3z7yItg.a9bmEdA0YOQX5u', 'Coq46E9NrHpamkmxwXNRinWcjczsHSzMeiKGcqCZlGzpSi6WauK9jIvsR8Wr', '2018-06-21 05:14:29', 'زلفعلی', '../images/avatar.png', NULL, 's.313', '09397311933', '2018-06-21 05:14:29', '2018-06-21 05:14:29', 3),
('مسجد', 'm1@m.ir', '$2y$10$yit9vFfJxkEYr9SA6C5QT.7ww4JpLGZiML7stl0wiZZ0YTDBdl6J.', NULL, '2018-06-23 22:22:05', 'امام حسن عسکری', '../images/avatar.png', NULL, 'امام حسن عسکری', '0918', '2018-06-23 22:22:05', '2018-06-23 22:22:05', 4),
('مسجد', 'hoj@gmail.com', '$2y$10$2lfyxB8SY./Nw94dZ4WhFeavPRm7bOYnRrkumTCBqFLbjvBZ6hOHW', 'G40LRZtIOtDtg5IbuBJRXz38OoUt4mAysanOB2CQSANPCCpNbXLltuevCyUH', '2018-07-07 14:31:06', 'حجت بن الحسن', '../images/avatar.png', NULL, 'حجت بن الحسن', '0918', '2018-07-07 14:31:06', '2018-07-07 14:31:06', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users_group`
--

CREATE TABLE `users_group` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `group_id` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users_group`
--

INSERT INTO `users_group` (`id`, `user_id`, `group_id`) VALUES
(1, '1', '1'),
(2, '2', '1'),
(3, '3', '1'),
(4, '4', '2'),
(5, '5', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dastrasi`
--
ALTER TABLE `dastrasi`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `group_khayerin`
--
ALTER TABLE `group_khayerin`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `grup`
--
ALTER TABLE `grup`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `heyat_omana`
--
ALTER TABLE `heyat_omana`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `khayerin`
--
ALTER TABLE `khayerin`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `kheyrie`
--
ALTER TABLE `kheyrie`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `maharat_kheyrie`
--
ALTER TABLE `maharat_kheyrie`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `manabe_kheyrie`
--
ALTER TABLE `manabe_kheyrie`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tajhizat_kheyrie`
--
ALTER TABLE `tajhizat_kheyrie`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tbl_khayergroup`
--
ALTER TABLE `tbl_khayergroup`
  ADD PRIMARY KEY (`kg_id`);

--
-- Indexes for table `tbl_niazgroups`
--
ALTER TABLE `tbl_niazgroups`
  ADD PRIMARY KEY (`ng_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_group`
--
ALTER TABLE `users_group`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dastrasi`
--
ALTER TABLE `dastrasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_khayerin`
--
ALTER TABLE `group_khayerin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grup`
--
ALTER TABLE `grup`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `heyat_omana`
--
ALTER TABLE `heyat_omana`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `khayerin`
--
ALTER TABLE `khayerin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kheyrie`
--
ALTER TABLE `kheyrie`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maharat_kheyrie`
--
ALTER TABLE `maharat_kheyrie`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manabe_kheyrie`
--
ALTER TABLE `manabe_kheyrie`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tajhizat_kheyrie`
--
ALTER TABLE `tajhizat_kheyrie`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_khayergroup`
--
ALTER TABLE `tbl_khayergroup`
  MODIFY `kg_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_niazgroups`
--
ALTER TABLE `tbl_niazgroups`
  MODIFY `ng_id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
