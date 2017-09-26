-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2017 at 10:36 AM
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
-- Table structure for table `AlarmWarning`
--

CREATE TABLE `AlarmWarning` (
  `DevID` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'dev_id in hex str',
  `Level` int(11) NOT NULL COMMENT 'Alarm=1, Warning=0',
  `Type` int(11) NOT NULL COMMENT 'Temp=0, Humidty=2, Pressure=4, Batt=6, RSSI=8',
  `Value` float DEFAULT NULL COMMENT 'Value what triggerd the alarm/warning',
  `TimestampUTCStart` datetime NOT NULL COMMENT 'timestamp of alarm/warning start',
  `TimestampUTCEnd` datetime DEFAULT NULL COMMENT 'timestamp of alarm/warning end'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `AlarmWarningLevel`
--

CREATE TABLE `AlarmWarningLevel` (
  `Level` int(11) NOT NULL,
  `Name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `AlarmWarningLevel`
--

INSERT INTO `AlarmWarningLevel` (`Level`, `Name`) VALUES
(0, 'Alarm'),
(1, 'Warning');

-- --------------------------------------------------------

--
-- Table structure for table `AlarmWarningLevels`
--

CREATE TABLE `AlarmWarningLevels` (
  `DevID` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'dev_id in hex str',
  `Level` int(11) DEFAULT '0' COMMENT 'Alarm=1, Warning=0',
  `TemperatureLower` float DEFAULT NULL COMMENT 'Lower limit Temperature (dgr C)',
  `TemperatureUpper` float DEFAULT NULL COMMENT 'Upper limit Temperature (dgr C)',
  `HumidityLower` float DEFAULT NULL COMMENT 'Lower limit Humidity (%)',
  `HumidityUpper` float DEFAULT NULL COMMENT 'Upper limit Humidity (%)',
  `PressureLower` float DEFAULT NULL COMMENT 'Lower limit Air pressure (mBar)',
  `PressureUpper` float DEFAULT NULL COMMENT 'Upper limit Air pressure (mBar)',
  `BattLower` float DEFAULT NULL COMMENT 'Lower limit Battery voltage (V)',
  `BattUpper` float DEFAULT NULL COMMENT 'Upper limit Battery voltage (V)',
  `RSSILower` int(11) DEFAULT NULL COMMENT 'Lower limit RSSI of the signal',
  `RSSIUpper` int(11) DEFAULT NULL COMMENT 'Upper limit RSSI of the signal',
  `Action` varchar(256) COLLATE utf8_bin DEFAULT NULL COMMENT 'Action to execute'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `AlarmWarningType`
--

CREATE TABLE `AlarmWarningType` (
  `Type` int(11) NOT NULL,
  `Name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `AlarmWarningType`
--

INSERT INTO `AlarmWarningType` (`Type`, `Name`) VALUES
(0, 'Temp Lower'),
(1, 'Temp Upper'),
(2, 'Humidity Lower'),
(3, 'Humidity Upper'),
(4, 'Pressure Lower'),
(5, 'Pressure Upper'),
(6, 'Batt Lower'),
(7, 'Batt Upper'),
(8, 'RSSI Lower'),
(9, 'RSSI Upper');

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
  `AreaID` varchar(64) COLLATE utf8_bin NOT NULL,
  `TimestampUTC` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AlarmWarning`
--
ALTER TABLE `AlarmWarning`
  ADD KEY `DevID` (`DevID`) USING BTREE;

--
-- Indexes for table `AlarmWarningLevel`
--
ALTER TABLE `AlarmWarningLevel`
  ADD UNIQUE KEY `Level` (`Level`);

--
-- Indexes for table `AlarmWarningLevels`
--
ALTER TABLE `AlarmWarningLevels`
  ADD PRIMARY KEY (`DevID`);

--
-- Indexes for table `AlarmWarningType`
--
ALTER TABLE `AlarmWarningType`
  ADD UNIQUE KEY `Type` (`Type`);

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
  ADD PRIMARY KEY (`DevID`,`AreaID`),
  ADD UNIQUE KEY `DevID` (`DevID`,`AreaID`),
  ADD KEY `AreaNodeArea` (`AreaID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AlarmWarning`
--
ALTER TABLE `AlarmWarning`
  ADD CONSTRAINT `AlarmWarningNode` FOREIGN KEY (`DevID`) REFERENCES `Node` (`DevID`);

--
-- Constraints for table `AlarmWarningLevels`
--
ALTER TABLE `AlarmWarningLevels`
  ADD CONSTRAINT `AlarmWarningLevelsNode` FOREIGN KEY (`DevID`) REFERENCES `Node` (`DevID`);

--
-- Constraints for table `NodeArea`
--
ALTER TABLE `NodeArea`
  ADD CONSTRAINT `AreaNodeArea` FOREIGN KEY (`AreaID`) REFERENCES `Area` (`AreaID`),
  ADD CONSTRAINT `NodeNodeArea` FOREIGN KEY (`DevID`) REFERENCES `Node` (`DevID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
