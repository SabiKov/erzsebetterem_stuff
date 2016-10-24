-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2016 at 12:24 PM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `erzsebetterem`
--
CREATE DATABASE IF NOT EXISTS `erzsebetterem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `erzsebetterem`;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'aki', 'aki'),
(2, 'szabi', 'szabi');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `membership_start_date` date DEFAULT NULL,
  `membership_expire_date` date DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `key`, `membership_start_date`, `membership_expire_date`, `modified`, `phone_number`, `comment`) VALUES
(1, 'Kovács Szabolcs', '11655666561516515655fsf15155', '2016-06-02', '2016-07-01', '2016-07-19 15:30:02', '0870657536', 'gekko kottás'),
(2, 'Gergyesi Ákos', '4665445453667681023f44', '2016-06-22', '2016-07-21', '2016-07-19 15:30:02', '0620256984', 'öreg trotty'),
(3, 'Sebaj Tóbiás', '4879846d87ad79779787ad9', '2016-07-12', '2016-08-11', '2016-07-19 15:30:02', '0875466645', 'áéűüóúí'),
(4, 'Albert Béla', '4454fs6sf65fs6f4546s', '2016-07-22', '2016-08-21', '2016-07-21 23:12:06', '365478966', 'dadadadadad'),
(5, 'Kiss Imre', '654645465654454565', '2016-06-24', '2016-07-23', '2016-07-22 23:16:44', '+36548484848', 'Mindig később akar fizetni'),
(6, 'Toth Lajos', '42255235235', '2016-07-14', '2016-07-13', '2016-07-23 23:39:29', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
