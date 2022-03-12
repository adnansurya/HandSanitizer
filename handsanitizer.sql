-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2022 at 04:54 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `handsanitizer`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_action`
--

CREATE TABLE `log_action` (
  `id_action` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `cairan` int(11) NOT NULL,
  `suhu` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_action`
--

INSERT INTO `log_action` (`id_action`, `waktu`, `cairan`, `suhu`) VALUES
(1, '2022-02-04 18:33:11', 102, 3.2),
(2, '2022-02-04 19:42:17', 0, 24.5),
(3, '2022-02-04 19:42:26', 0, 24.6),
(4, '2022-03-11 17:30:48', 5, 1037.55),
(5, '2022-03-11 17:30:52', 5, 1037.55),
(6, '2022-03-11 17:30:57', 5, 1037.55),
(7, '2022-03-11 17:31:21', 5, 1037.55),
(8, '2022-03-11 17:32:57', 5, 1037.55),
(9, '2022-03-11 17:33:12', 5, 1037.55),
(10, '2022-03-11 17:39:42', 4, 30.63),
(11, '2022-03-11 17:40:09', 4, 19.93),
(12, '2022-03-11 17:40:23', 5, 36.07),
(13, '2022-03-11 17:40:28', 4, 34.53),
(14, '2022-03-11 17:40:33', 5, 33.83),
(15, '2022-03-11 17:40:46', 5, 29.89),
(16, '2022-03-11 17:42:35', 5, 28.99),
(17, '2022-03-11 17:43:01', 5, 29.39),
(18, '2022-03-11 17:43:51', 5, 29.59),
(19, '2022-03-11 17:46:15', 0, 30.59),
(20, '2022-03-11 17:52:25', 0, 29.93),
(21, '2022-03-11 17:52:43', 0, 29.89),
(22, '2022-03-11 17:53:03', 0, 29.91);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_action`
--
ALTER TABLE `log_action`
  ADD PRIMARY KEY (`id_action`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_action`
--
ALTER TABLE `log_action`
  MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
