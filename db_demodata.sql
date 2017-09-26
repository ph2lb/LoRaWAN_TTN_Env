-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2017 at 10:44 AM
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

--
-- Dumping data for table `AlarmWarningLevels`
--

INSERT INTO `AlarmWarningLevels` (`DevID`, `Level`, `TemperatureLower`, `TemperatureUpper`, `HumidityLower`, `HumidityUpper`, `PressureLower`, `PressureUpper`, `BattLower`, `BattUpper`, `RSSILower`, `RSSIUpper`, `Action`) VALUES
('demonode', 0, 5, 30, 25, 99, 1000, NULL, 2.5, 3.7, -110, -25, 'Send email');

--
-- Dumping data for table `Area`
--

INSERT INTO `Area` (`AreaID`, `Longitude`, `Latitude`, `Description`, `TimestampUTC`) VALUES
('Demo', 6.66849, 52.367, 'Demo area', '2017-09-26 00:00:00');

--
-- Dumping data for table `Node`
--

INSERT INTO `Node` (`DevID`, `Longitude`, `Latitude`, `Owner`, `Description`, `TimestampUTC`) VALUES
('demonode', 6.6604, 52.3716, 'Demo user', 'Use https://www.gps-latitude-longitude.com/address-to-longitude-latitude-gps-coordinates to get you\'re lat/lon', '2017-01-01 00:00:00');

--
-- Dumping data for table `NodeArea`
--

INSERT INTO `NodeArea` (`DevID`, `AreaID`, `TimestampUTC`) VALUES
('demonode', 'Demo', '2017-09-26 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
