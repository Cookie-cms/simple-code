-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 14, 2024 at 10:02 AM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simplecode`
--

-- --------------------------------------------------------

--
-- Table structure for table `hwids`
--

CREATE TABLE `hwids` (
  `id` bigint NOT NULL,
  `publickey` blob,
  `hwDiskId` varchar(255) DEFAULT NULL,
  `baseboardSerialNumber` varchar(255) DEFAULT NULL,
  `graphicCard` varchar(255) DEFAULT NULL,
  `displayId` blob,
  `bitness` int DEFAULT NULL,
  `totalMemory` bigint DEFAULT NULL,
  `logicalProcessors` int DEFAULT NULL,
  `physicalProcessors` int DEFAULT NULL,
  `processorMaxFreq` bigint DEFAULT NULL,
  `battery` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `uuid` varchar(256) NOT NULL,
  `accessToken` char(32) DEFAULT NULL,
  `serverID` varchar(41) DEFAULT NULL,
  `hwidId` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hwids`
--
ALTER TABLE `hwids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `publickey` (`publickey`(255));

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_hwidfk` (`hwidId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hwids`
--
ALTER TABLE `hwids`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_hwidfk` FOREIGN KEY (`hwidId`) REFERENCES `hwids` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
