-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 14, 2017 at 11:20 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttn_enviromental_beacon`
--

-- --------------------------------------------------------

--
-- Table structure for table `Area`
--

CREATE TABLE `Area` (
  `AreaID` varchar(64) COLLATE utf8_bin NOT NULL,
  `Longitude` float NOT NULL,
  `Latitude` float NOT NULL,
  `Description` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `TimestampUTC` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Measurement`
--

CREATE TABLE `Measurement` (
  `TimestampUTC` datetime NOT NULL COMMENT 'timestamp of measurement',
  `DevID` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'dev_id in hex str',
  `Temperature` float DEFAULT NULL COMMENT 'Temperature (dgr C)',
  `Humidity` float DEFAULT NULL COMMENT 'Humidity (%)',
  `Pressure` float DEFAULT NULL COMMENT 'Air pressure (mBar)',
  `Batt` float DEFAULT NULL COMMENT 'Battery voltage (V)',
  `RSSI` int(11) NOT NULL COMMENT 'RSSI of the signal',
  `Raw` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Node`
--

CREATE TABLE `Node` (
  `DevID` varchar(64) COLLATE utf8_bin NOT NULL,
  `Longitude` float NOT NULL,
  `Latitude` float NOT NULL,
  `Owner` varchar(128) COLLATE utf8_bin NOT NULL,
  `Description` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `TimestampUTC` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `NodeArea`
--

CREATE TABLE `NodeArea` (
  `DevID` varchar(64) COLLATE utf8_bin NOT NULL,
  `AeraID` varchar(64) COLLATE utf8_bin NOT NULL,
  `TimestampUTC` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Area`
--
ALTER TABLE `Area`
  ADD PRIMARY KEY (`AreaID`),
  ADD KEY `AeraID` (`AreaID`);

--
-- Indexes for table `Measurement`
--
ALTER TABLE `Measurement`
  ADD UNIQUE KEY `TimestampUtcDevID` (`TimestampUTC`,`DevID`);

--
-- Indexes for table `Node`
--
ALTER TABLE `Node`
  ADD PRIMARY KEY (`DevID`),
  ADD UNIQUE KEY `DevID` (`DevID`);

--
-- Indexes for table `NodeArea`
--
ALTER TABLE `NodeArea`
  ADD PRIMARY KEY (`DevID`,`AeraID`),
  ADD UNIQUE KEY `DevID` (`DevID`,`AeraID`),
  ADD KEY `AreaNodeArea` (`AeraID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `NodeArea`
--
ALTER TABLE `NodeArea`
  ADD CONSTRAINT `AreaNodeArea` FOREIGN KEY (`AeraID`) REFERENCES `Area` (`AreaID`),
  ADD CONSTRAINT `NodeNodeArea` FOREIGN KEY (`DevID`) REFERENCES `Node` (`DevID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
