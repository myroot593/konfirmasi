-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 05, 2021 at 05:05 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konfirmasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `field_pending_user`
--

CREATE TABLE `field_pending_user` (
  `uid` int(10) UNSIGNED NOT NULL COMMENT 'user id',
  `email` varchar(254) NOT NULL COMMENT 'email user pending',
  `hash` varchar(32) NOT NULL COMMENT 'hash for verification',
  `pending_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'status pengaktifkan akun'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `field_pending_user`
--

INSERT INTO `field_pending_user` (`uid`, `email`, `hash`, `pending_status`) VALUES
(1, 'usertest@mail.com', 'a9a1d5317a33ae8cef33961c34144f84', 0),
(2, 'myroot593@gmail.com', '9b04d152845ec0a378394003c96da594', 1);

-- --------------------------------------------------------

--
-- Table structure for table `field_user`
--

CREATE TABLE `field_user` (
  `uid` int(10) UNSIGNED NOT NULL COMMENT 'user id pengguna',
  `username` varchar(60) NOT NULL COMMENT 'username pengguna',
  `email` varchar(254) DEFAULT NULL COMMENT 'email pengguna',
  `pass` varchar(255) NOT NULL COMMENT 'password',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 user aktif 0 user blokir'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `field_user`
--

INSERT INTO `field_user` (`uid`, `username`, `email`, `pass`, `status`) VALUES
(1, 'user', 'usertest@mail.com', '$2y$10$cB.dHL1R0pdc34A/8ZeZT.2fk2v93gCgrfvOr7b8tx6cJpUmClyrS', 0),
(2, 'aze_', 'myroot593@gmail.com', '$2y$10$WLYIWo.I3o/JN0uKYQ5IGeodCJRcjhdnY2wj3tKDQhdLion2iuftS', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `field_pending_user`
--
ALTER TABLE `field_pending_user`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `mail` (`email`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `field_user`
--
ALTER TABLE `field_user`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `field_user`
--
ALTER TABLE `field_user`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'user id pengguna', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
