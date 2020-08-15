-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 11, 2020 at 01:16 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u831373601_smartedu`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assign`
--

CREATE TABLE `tbl_assign` (
  `AssignId` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `RoomId` int(11) DEFAULT NULL,
  `PeerId` varchar(45) DEFAULT NULL,
  `CDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `RoomId` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `PeerId` varchar(100) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `RoomName` varchar(100) DEFAULT NULL,
  `RoomType` varchar(100) DEFAULT NULL,
  `VideoName` varchar(100) DEFAULT NULL,
  `VideoPath` varchar(500) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `SDate` datetime DEFAULT NULL,
  `CDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `UserId` int(11) NOT NULL,
  `PeerId` varchar(100) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `UserType` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Mobile` varchar(100) DEFAULT NULL,
  `Username` varchar(100) DEFAULT NULL,
  `PasswordHash` varchar(500) DEFAULT NULL,
  `CDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`UserId`, `PeerId`, `FullName`, `Gender`, `UserType`, `Email`, `Mobile`, `Username`, `PasswordHash`, `CDate`) VALUES
(21, '1778b3', 'Orange School', NULL, 'Admin', 'ksenthilorange@gmail.com', NULL, 'orangeadmin', '$2y$10$pTn87McAMvFJBZG71fklJeOAXx8zRxASCFWijplnhmoqIGtE4Qkr6', '2020-08-10 13:28:38'),
(22, 'ff5da9', 'sachin', NULL, 'Student', 'saravan375@gmail.com', NULL, 'Sachin375', '$2y$10$mlGYKePe5uGOoGUJJbptsewR4JqVvbqwUx48UKuxHz7DhWZk4k0dC', '2020-08-11 07:57:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_assign`
--
ALTER TABLE `tbl_assign`
  ADD PRIMARY KEY (`AssignId`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`RoomId`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `PeerId_UNIQUE` (`PeerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_assign`
--
ALTER TABLE `tbl_assign`
  MODIFY `AssignId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `RoomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
