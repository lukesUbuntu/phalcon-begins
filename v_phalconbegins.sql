-- phpMyAdmin SQL Dump
-- version 3.3.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2015 at 01:02 AM
-- Server version: 1.0.16
-- PHP Version: 5.6.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `v_phalconbegins`
--

-- --------------------------------------------------------

--
-- Table structure for table `ws_session_data`
--

CREATE TABLE IF NOT EXISTS `ws_session_data` (
  `session_id` varchar(35) NOT NULL,
  `data` text NOT NULL,
  `created_at` int(15) unsigned NOT NULL,
  `modified_at` int(15) unsigned DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ws_session_data`
--

INSERT INTO `ws_session_data` (`session_id`, `data`, `created_at`, `modified_at`) VALUES
('kphhg3kk9o01706aj847d7pl65', 'phalconbegins$PHALCON/CSRF$|s:32:"a7e7a32c65d8912b8fb8dd4a84ef13f0";phalconbegins$PHALCON/CSRF/KEY$|s:15:"anXx72P9AuqlgCt";', 1427266070, 1427306388);

-- --------------------------------------------------------

--
-- Table structure for table `ws_test`
--

CREATE TABLE IF NOT EXISTS `ws_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ws_test`
--

INSERT INTO `ws_test` (`id`, `name`, `address`) VALUES
(1, '&lt;strong&gt;Vee&lt;/strong&gt;', '123 addr &lt;p&gt;some road&lt;/p&gt;'),
(2, 'Vee', '123 addr'),
(3, 'ฟหกด', '321 กกกก'),
(4, 'กดดดกaaa', '213 หกฟหฟก'),
(5, 'พกด', '222 ฟฟ'),
(6, 'ฟสหว', '233 ฟาสสว'),
(7, 'ฟะพว', '233 ฟีสสว'),
(8, 'นรรย', '556 ผปแ'),
(9, 'นนจต', '244 ภถคตจ'),
(10, 'ผปอ', '331 ฝมฝมวส'),
(11, 'ฟนนร', '232 ฟฟหก'),
(14, '&lt;strong&gt;name&lt;/strong&gt;', '&lt;p&gt;address road&lt;/p&gt;');
