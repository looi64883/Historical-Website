-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 07:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `23_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_username` varchar(30) NOT NULL,
  `admin_password` varchar(60) NOT NULL,
  `admin_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_username`, `admin_password`, `admin_email`) VALUES
('admin', '66a917f2b9e01215cf1995521aa7e681346e32a6', '23_web@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forgot`
--

CREATE TABLE `tbl_forgot` (
  `bil` int(100) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_otp` int(6) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_forgot`
--

INSERT INTO `tbl_forgot` (`bil`, `user_email`, `user_otp`, `time`) VALUES
(1, 'heykiat750@gmail.com', 446478, '2024-01-09 00:36:40'),
(2, 'heykiat750@gmail.com', 375538, '2024-01-09 00:37:11'),
(4, 'heykiat750@gmail.com', 433279, '2024-01-09 00:51:53'),
(5, 'heykiat750@gmail.com', 342425, '2024-01-09 11:16:42'),
(6, 'heykiat750@gmail.com', 354744, '2024-01-09 11:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(5) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_phone` varchar(12) NOT NULL,
  `user_password` varchar(40) NOT NULL,
  `user_datereg` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `game` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_email`, `user_name`, `user_phone`, `user_password`, `user_datereg`, `game`) VALUES
(14, 'heykiat756@gmail.com', 'Thomas5', '0185767390', 'b7c40b9c66bc88d38a59e554c639d743e77f1b65', '2023-11-27 14:17:50.000000', 0),
(16, 'heykiat7576@gmail.com', 'Thomas24', '01857673934', '612a672b59f16322da42ffd2e76c82f028fafef1', '2023-11-27 15:07:02.000000', 0),
(19, 'heykiat751@gmail.com', 'Thomas1325', '7647634256', '434c878a311fb6781e3bfcd6652f11888dc25ac9', '2023-11-27 15:07:45.000000', 0),
(22, 'heykiat75765434@gmail.com', 'Thomas1', '764544', 'f1f42618adfd7589d3ca5ac17d05440a2bfbf26a', '2023-11-27 15:08:19.000000', 0),
(23, 'heykiat7eqrfa1@gmail.com', 'Thomas1ersvs', '7654534257', '5562e53e023d26b9ff3b99637acb718f0189a753', '2023-11-27 15:08:48.000000', 0),
(24, 'heerthdbfnmt750@gmail.com', 'Thomas231tiuuj', '754352', '7b97c5c61d8f489ee85929b74bcf7597e7db2ad9', '2023-11-27 15:09:02.000000', 0),
(25, 'aewfat751@gmail.com', 'Thomas1wefasvz', '43565342536', '654bd913ef03091bdcb7692594cbef23e4e7777f', '2023-11-27 15:09:22.000000', 0),
(26, 'awefc751@gmail.com', 'Thomas1325awe', '21547542', '1640b0325c1c36e499c757240e037fba45fb712b', '2023-11-27 15:09:38.000000', 0),
(27, '09fdst750@gmail.com', 'Thomas231qweasf', '14367654146', '1cb2b6b44982dac37e34d1d9e3267c669098ab2b', '2023-11-27 15:09:57.000000', 0),
(28, 'aghh1@gmail.com', 'Tho7etrsgf', '56543124567', 'f7493a29b583c8430b6ed8476714f852b1c5c5fa', '2023-11-27 15:10:12.000000', 0),
(29, '978ytgfbsa750@gmail.com', 'Tbsdhosfbsfb1qweasf', '543245567865', '4f55d265ac62dec6b67eb5de0cdb86a5f75d8af4', '2023-11-27 15:10:30.000000', 0),
(30, '0asopl@gmail.com', 'weagvsvs231qweasf', '542568354', '3115b5fa4da463e51153b9652ba36162cf8f3a71', '2023-11-27 15:10:43.000000', 0),
(31, 'memedat750@gmail.com', 'Thomas', '123456789000', '20d75fe135fc3abc15aee2f6e4657c3107899d6a', '2023-11-27 16:09:47.000000', 0),
(32, 'heykiat7eqrfa1@gmail.com', 'Thomas1ersvs', '054366533', '024824a1242ad690a54a0406c04eb612e919d28c', '2023-11-27 16:21:53.000000', 0),
(33, '7564opl@gmail.com', 'aedaervdvs231qweasf', '567645343567', '687e9008e113036442048271eb25b9914d19b4de', '2023-11-27 16:22:09.000000', 0),
(34, '543yth1@gmail.com', 'Tho4536', '75843768977', '61989668ff943de23db7bc14f21e8ff495303d0d', '2023-11-27 16:22:40.000000', 0),
(35, 'h7566@gmail.com', 'segrxdfbhnjuas24536', '876254765', '3032f7fed93aae50c5557464a47c10aabbe22c6d', '2023-11-27 16:24:26.000000', 0),
(36, 'ggscnu1@gmail.com', 'Th42', '9874587', 'c1ace689fdd0e2beafd34c2a2b10b1a76f63af4d', '2023-11-27 16:25:10.000000', 0),
(38, 'heykiat755@gmail.com', 'Thomashaha', '0185767335', '8cb2237d0679ca88db6464eac60da96345513964', '2023-12-19 04:33:37.000000', 0),
(39, 'thomas08251020@gmail.com', 'waikiat', '0185767433', '8cb2237d0679ca88db6464eac60da96345513964', '2024-01-03 14:15:36.000000', 1),
(40, 'heykiat750@gmail.com', 'Thomas', '0185767392', '8cb2237d0679ca88db6464eac60da96345513964', '2024-01-05 14:16:46.000000', 1),
(41, 'sthenocw@gmail.com', 'LOOI', '0169084790', '66a917f2b9e01215cf1995521aa7e681346e32a6', '2024-01-13 06:50:35.000000', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_forgot`
--
ALTER TABLE `tbl_forgot`
  ADD PRIMARY KEY (`bil`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_forgot`
--
ALTER TABLE `tbl_forgot`
  MODIFY `bil` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
