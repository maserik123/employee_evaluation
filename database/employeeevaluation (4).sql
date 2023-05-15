-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2023 at 06:37 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employeeevaluation`
--

-- --------------------------------------------------------

--
-- Table structure for table `calc_criteria_employee`
--

CREATE TABLE `calc_criteria_employee` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calc_criteria_employee`
--

INSERT INTO `calc_criteria_employee` (`id`, `employee_id`, `criteria_id`, `value`) VALUES
(85, 4, 2, 5),
(86, 4, 3, 4),
(87, 4, 4, 3),
(88, 4, 5, 2),
(89, 4, 6, 2),
(90, 4, 7, 3),
(91, 5, 2, 3),
(92, 5, 3, 3),
(93, 5, 4, 2),
(94, 5, 5, 3),
(95, 5, 6, 2),
(96, 5, 7, 2),
(133, 6, 2, 4),
(134, 6, 3, 1),
(135, 6, 4, 3),
(136, 6, 5, 1),
(137, 6, 6, 1),
(138, 6, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `calc_max_weight_normalization`
--

CREATE TABLE `calc_max_weight_normalization` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `value` char(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calc_max_weight_normalization`
--

INSERT INTO `calc_max_weight_normalization` (`id`, `employee_id`, `value`) VALUES
(38, 4, '0.075'),
(39, 5, '0.2'),
(40, 6, '0.2');

-- --------------------------------------------------------

--
-- Table structure for table `calc_normalization`
--

CREATE TABLE `calc_normalization` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `value` char(45) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calc_normalization`
--

INSERT INTO `calc_normalization` (`id`, `employee_id`, `criteria_id`, `value`, `create_date`) VALUES
(241, 4, 2, '0', '2023-05-14 08:19:02'),
(242, 4, 3, '0', '2023-05-14 08:19:02'),
(243, 4, 4, '0', '2023-05-14 08:19:02'),
(244, 4, 5, '0.5', '2023-05-14 08:19:02'),
(245, 4, 6, '0', '2023-05-14 08:19:02'),
(246, 4, 7, '0', '2023-05-14 08:19:02'),
(247, 5, 2, '1', '2023-05-14 08:19:02'),
(248, 5, 3, '0.33333333333333', '2023-05-14 08:19:02'),
(249, 5, 4, '1', '2023-05-14 08:19:02'),
(250, 5, 5, '0', '2023-05-14 08:19:02'),
(251, 5, 6, '0', '2023-05-14 08:19:02'),
(252, 5, 7, '1', '2023-05-14 08:19:02'),
(253, 6, 2, '0.5', '2023-05-14 08:19:02'),
(254, 6, 3, '1', '2023-05-14 08:19:02'),
(255, 6, 4, '0', '2023-05-14 08:19:02'),
(256, 6, 5, '1', '2023-05-14 08:19:02'),
(257, 6, 6, '1', '2023-05-14 08:19:02'),
(258, 6, 7, '0', '2023-05-14 08:19:02');

-- --------------------------------------------------------

--
-- Table structure for table `calc_total_weight_normalization`
--

CREATE TABLE `calc_total_weight_normalization` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `value` char(45) NOT NULL,
  `year` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calc_total_weight_normalization`
--

INSERT INTO `calc_total_weight_normalization` (`id`, `employee_id`, `value`, `year`) VALUES
(33, 4, '0.075', '2023'),
(34, 5, '0.55', '2022'),
(35, 6, '0.6000000000000001', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `calc_weight_normalization`
--

CREATE TABLE `calc_weight_normalization` (
  `id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `value` char(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calc_weight_normalization`
--

INSERT INTO `calc_weight_normalization` (`id`, `criteria_id`, `employee_id`, `value`) VALUES
(236, 2, 4, '0'),
(237, 3, 4, '0'),
(238, 4, 4, '0'),
(239, 5, 4, '0.075'),
(240, 6, 4, '0'),
(241, 7, 4, '0'),
(242, 2, 5, '0.2'),
(243, 3, 5, '0.05'),
(244, 4, 5, '0.15'),
(245, 5, 5, '0'),
(246, 6, 5, '0'),
(247, 7, 5, '0.15'),
(248, 2, 6, '0.1'),
(249, 3, 6, '0.15'),
(250, 4, 6, '0'),
(251, 5, 6, '0.15'),
(252, 6, 6, '0.2'),
(253, 7, 6, '0');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int(11) NOT NULL,
  `criteria_code` varchar(12) NOT NULL,
  `criteria_detail` text NOT NULL,
  `crt_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `criteria_code`, `criteria_detail`, `crt_date`) VALUES
(2, 'C1', 'Complementary Team', '2023-04-10 15:10:53'),
(3, 'C2', 'Integrity', '2023-04-10 15:11:26'),
(4, 'C3', 'Ownership', '2023-04-10 15:12:07'),
(5, 'C4', 'Responsibility', '2023-04-10 15:12:55'),
(6, 'C5', 'Agibility', '2023-04-10 15:13:21'),
(7, 'C6', 'Presentation', '2023-04-10 15:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `e_name` varchar(115) NOT NULL,
  `e_phone` varchar(15) NOT NULL,
  `e_address` text NOT NULL,
  `e_email` varchar(75) NOT NULL,
  `crt_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `e_name`, `e_phone`, `e_address`, `e_email`, `crt_date`) VALUES
(3, 'Ajeng', '082366553423', 'Pekanbaru', 'ajeng@gmail.com', '2023-04-10 15:07:52'),
(4, 'Ezza Jati Pertiwi', '082344552233', 'Pekanbaru Jl Uka', 'ezza@gmail.com', '2023-04-10 15:09:04'),
(5, 'Sulaiman', '089877663322', 'Jl Bukit Barisan Pekanbaru Riau', 'sule@gmail.com', '2023-04-10 15:09:47'),
(6, 'Deasy', '082233445533', 'Pangkalan Kerinci', 'desy@gmail.com', '2023-04-10 15:10:26'),
(7, 'Fitra', '082288383066', 'Pkl Kerinci', 'fitra@gmail.com', '2023-05-06 13:57:52'),
(8, 'Lisnawati', '082333445566', 'Kota Padang', 'lisna@gmail.com', '2023-05-06 15:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `full_name` varchar(115) NOT NULL,
  `nick_name` varchar(115) NOT NULL,
  `initial` text NOT NULL,
  `NIP` text NOT NULL,
  `email` varchar(115) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `picture` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `full_name`, `nick_name`, `initial`, `NIP`, `email`, `address`, `phone_number`, `picture`, `create_date`) VALUES
(4, 'Fitra Arrafiq', 'Fitra', 'FAR', '20017861', 'fitraarrafiq@gmail.com', 'medan pekanbaru', '082233445566', '', '2022-07-26 22:18:55'),
(5, 'Benget Manahan Siregar', 'Benget', 'BMS', '20088334', 'benget@globalnet.lcl', 'Serapung', '09334455666', '', '2022-07-30 04:45:48'),
(6, 'Samsul Rizal', 'Sam', 'SRZ', '23344551', 'samsul@kerinci.lcl', 'medan', '08233445566', '', '2022-07-30 04:46:02'),
(7, 'User1', 'user satu', 'U1', '12345', 'fitraarrafiq@gmail.com', 'Indonesia', '09334455666', '', '2022-08-05 23:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` int(11) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `jenis_aksi` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `userid` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `user_login_id` int(11) NOT NULL,
  `oauth_provider` varchar(15) NOT NULL,
  `oauth_uid` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  `username` varchar(115) NOT NULL,
  `password` varchar(115) NOT NULL,
  `link` varchar(255) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `block_status` varchar(15) NOT NULL,
  `access_status` varchar(15) NOT NULL,
  `online_status` varchar(12) DEFAULT NULL,
  `time_online` timestamp NULL DEFAULT NULL,
  `time_offline` timestamp NULL DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`user_login_id`, `oauth_provider`, `oauth_uid`, `userid`, `username`, `password`, `link`, `user_role_id`, `block_status`, `access_status`, `online_status`, `time_online`, `time_offline`, `create_date`) VALUES
(4, '', '', 4, 'sys_manager', 'ad248d72422d9efc5bde0620401bd1d9', '', 7, '0', '', 'offline', '2023-05-15 16:25:39', NULL, '2023-05-15 16:25:39'),
(7, '', '', 6, 'supervisor', '88ba8b1c154d017e2691de682cc0bf0d', '', 9, '0', '', 'offline', '2023-05-15 16:29:51', NULL, '2023-05-15 16:35:51'),
(8, '', '', 5, 'administrator', 'ad248d72422d9efc5bde0620401bd1d9', '', 10, '0', '', 'online', '2023-05-15 16:30:01', NULL, '2023-05-15 16:30:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_role_id` int(11) NOT NULL,
  `role` text NOT NULL,
  `description` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_role_id`, `role`, `description`, `create_date`) VALUES
(7, 'sys_manager', 'System Manager', '2022-07-24 11:26:40'),
(9, 'supervisor', 'Menginput nilai karyawan dan yang bisa mengubah kriteria yang berhubungan dengan perhitungan, bisa melihat data karyawan tapi tidak dapat mengubah data karyawan', '2023-05-15 16:24:11'),
(10, 'admin', 'admin melakukan perhitungan serta mencetak piagam penghargaan', '2023-05-15 15:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `weight`
--

CREATE TABLE `weight` (
  `weight_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `weight_value` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weight`
--

INSERT INTO `weight` (`weight_id`, `criteria_id`, `weight_value`) VALUES
(16, 2, '0.2'),
(17, 3, '0.15'),
(18, 4, '0.15'),
(19, 5, '0.15'),
(20, 6, '0.2'),
(21, 7, '0.15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calc_criteria_employee`
--
ALTER TABLE `calc_criteria_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calc_max_weight_normalization`
--
ALTER TABLE `calc_max_weight_normalization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calc_normalization`
--
ALTER TABLE `calc_normalization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calc_total_weight_normalization`
--
ALTER TABLE `calc_total_weight_normalization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calc_weight_normalization`
--
ALTER TABLE `calc_weight_normalization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`user_login_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role_id`);

--
-- Indexes for table `weight`
--
ALTER TABLE `weight`
  ADD PRIMARY KEY (`weight_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calc_criteria_employee`
--
ALTER TABLE `calc_criteria_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `calc_max_weight_normalization`
--
ALTER TABLE `calc_max_weight_normalization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `calc_normalization`
--
ALTER TABLE `calc_normalization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `calc_total_weight_normalization`
--
ALTER TABLE `calc_total_weight_normalization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `calc_weight_normalization`
--
ALTER TABLE `calc_weight_normalization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `user_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `weight`
--
ALTER TABLE `weight`
  MODIFY `weight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
