-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2013 at 11:06 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `checkemail`
--
CREATE DATABASE IF NOT EXISTS `checkemail` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `checkemail`;

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getNameCategory`(`CatID` int) RETURNS varchar(100) CHARSET utf8
BEGIN
	#Routine body goes here...
	DECLARE CatName VARCHAR(100);
	select category.`Name` INTO CatName from category where category.ID=catID;
	RETURN CatName;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `NumberContact`(`CateID` int) RETURNS int(11)
BEGIN
	#Routine body goes here...
	DECLARE num INT;
	SELECT count(id) into num from storedemail where storedemail.CategoryID=CateID and (storedemail.Deleted is null or storedemail.Deleted!=1);
	RETURN num;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `EmailUser` varchar(50) NOT NULL,
  `Deleted` tinyint(1) NOT NULL,
  `Note` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `Name`, `CreatedDate`, `UpdatedDate`, `EmailUser`, `Deleted`, `Note`) VALUES
(1, 'khách hàng VIP', '2013-10-29 12:20:09', '2013-10-31 15:27:02', 'nienn@gmail.com', 0, 'danh sách khách hàng quan trọng'),
(2, 'khách hàng mới', '2013-10-29 16:13:00', '2013-10-29 16:13:00', 'nienn@gmail.com', 0, 'khách hàng mới cần quan tâm'),
(3, 'khách hàng lâu năm', '2013-10-29 22:30:41', '2013-10-29 23:35:15', 'nienn@gmail.com', 0, ''),
(4, 'danh mục 4', '2013-11-01 22:17:59', '2013-11-16 11:08:58', 'nienn@gmail.com', 0, ''),
(5, 'danh mục 5', '2013-11-01 22:18:08', '2013-11-01 22:18:08', 'nienn@gmail.com', 0, ''),
(6, 'danh mục 6', '2013-11-01 22:18:19', '2013-11-01 22:18:19', 'nienn@gmail.com', 0, ''),
(7, 'gửi thử', '2013-11-26 20:55:09', '2013-11-26 20:55:09', 'nienn@gmail.com', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `checkemailsrecord`
--

CREATE TABLE IF NOT EXISTS `checkemailsrecord` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FromIP` varchar(50) NOT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `CheckedEmail` varchar(100) NOT NULL,
  `CheckDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Session` int(10) unsigned DEFAULT NULL,
  `DomainOfEmail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=226 ;

--
-- Dumping data for table `checkemailsrecord`
--

INSERT INTO `checkemailsrecord` (`ID`, `FromIP`, `UserName`, `CheckedEmail`, `CheckDate`, `Status`, `Session`, `DomainOfEmail`) VALUES
(1, '::1', '', 'thanhnien@hotmail.com', '2013-10-13 05:19:17', 1, NULL, NULL),
(2, '::1', '', 'thanhnien@hotmail.com', '2013-10-13 05:20:34', 1, NULL, NULL),
(3, '::1', '', 'minhhai@gmail.com', '2013-10-13 05:20:35', 1, NULL, NULL),
(4, '::1', '', 'hung123@yahoo.com', '2013-10-13 05:20:35', 1, NULL, NULL),
(5, '::1', '', 'vnyahoo@yahoo.com', '2013-10-13 05:20:35', 1, NULL, NULL),
(6, '::1', '', 'phamminhhai@gmail.com', '2013-10-13 05:20:38', 1, NULL, NULL),
(7, '::1', '', 'thanhnien@hotmail.com', '2013-10-13 05:22:23', 1, NULL, NULL),
(8, '::1', '', 'vnyahoo@yahoo.com', '2013-10-13 05:22:23', 1, NULL, NULL),
(9, '::1', '', 'hung123@yahoo.com', '2013-10-13 05:22:24', 1, NULL, NULL),
(10, '::1', '', 'minhhai@gmail.com', '2013-10-13 05:22:26', 1, NULL, NULL),
(11, '::1', '', 'phamminhhai@gmail.com', '2013-10-13 05:22:27', 1, NULL, NULL),
(12, '::1', '', 'hung@gmail.com', '2013-10-13 05:22:27', 0, NULL, NULL),
(13, '::1', '', 'liberty042@mail.ru', '2013-10-13 05:22:28', 0, NULL, NULL),
(14, '::1', '', 'tienphong@gmail.com', '2013-10-13 05:38:52', 1, NULL, NULL),
(15, '::1', '', 'minhhai@gmail.com', '2013-10-13 05:40:07', 1, NULL, NULL),
(16, '::1', '', 'thanhnien@hotmail.com', '2013-10-13 05:40:07', 1, NULL, NULL),
(17, '::1', '', 'hung123@yahoo.com', '2013-10-13 05:40:08', 1, NULL, NULL),
(18, '::1', '', 'vnyahoo@yahoo.com', '2013-10-13 05:40:08', 1, NULL, NULL),
(19, '::1', '', 'phamminhhai@gmail.com', '2013-10-13 05:40:08', 1, NULL, NULL),
(20, '::1', '', 'liberty042@mail.ru', '2013-10-13 05:40:10', 0, NULL, NULL),
(21, '::1', '', 'hung@gmail.com', '2013-10-13 05:40:12', 0, NULL, NULL),
(22, '::1', '', 'dark-temnota1991@mail.ru', '2013-10-13 11:00:19', 0, NULL, NULL),
(23, '::1', '', 'hung@gmail.com', '2013-10-13 11:04:50', 0, NULL, NULL),
(24, '::1', '', 'minhhai@gmail.com', '2013-10-13 11:05:15', 1, NULL, NULL),
(25, '::1', '', 'liberty042@mail.ru', '2013-10-13 11:05:18', 0, NULL, NULL),
(26, '::1', '', 'phamminhhai@gmail.com', '2013-10-13 11:05:19', 1, NULL, NULL),
(27, '::1', '', 'hung123@yahoo.com', '2013-10-13 11:05:24', 1, NULL, NULL),
(28, '::1', '', 'vnyahoo@yahoo.com', '2013-10-13 11:05:24', 1, NULL, NULL),
(29, '::1', '', 'thanhnien@hotmail.com', '2013-10-13 11:05:24', 1, NULL, NULL),
(30, '::1', '', 'hung@gmail.com', '2013-10-13 11:05:27', 0, NULL, NULL),
(31, '::1', '', 'minhhai@gmail.com', '2013-10-13 12:50:30', 1, NULL, NULL),
(32, '::1', '', 'thanhnien@hotmail.com', '2013-10-13 12:50:30', 1, NULL, NULL),
(33, '::1', '', 'phamminhhai@gmail.com', '2013-10-13 12:50:30', 1, NULL, NULL),
(34, '::1', '', 'vnyahoo@yahoo.com', '2013-10-13 12:50:30', 1, NULL, NULL),
(35, '::1', '', 'hung123@yahoo.com', '2013-10-13 12:50:30', 1, NULL, NULL),
(36, '::1', '', 'hung@gmail.com', '2013-10-13 12:50:30', 0, NULL, NULL),
(37, '::1', '', 'liberty042@mail.ru', '2013-10-13 12:50:35', 0, NULL, NULL),
(38, '::1', '', 'minhhai@gmail.com', '2013-10-14 15:37:27', 1, 0, NULL),
(39, '::1', '', 'minhhai@gmail.com', '2013-10-14 15:40:45', 1, 0, NULL),
(40, '::1', '', 'minhhai@gmail.com', '2013-10-14 15:42:46', 1, 0, NULL),
(41, '::1', '', 'minhhai@gmail.com', '2013-10-14 15:43:39', 1, 0, NULL),
(42, '::1', '', 'minhhai@gmail.com', '2013-10-14 15:45:27', 1, 1, NULL),
(43, '::1', '', 'hung@gmail.com', '2013-10-14 15:46:06', 0, 2, NULL),
(44, '::1', '', 'minhhai@gmail.com', '2013-10-14 16:33:48', 1, 3, NULL),
(45, '::1', '', 'thanhnien@hotmail.com', '2013-10-14 16:33:48', 1, 3, NULL),
(46, '::1', '', 'vnyahoo@yahoo.com', '2013-10-14 16:33:50', 1, 3, NULL),
(47, '::1', '', 'phamminhhai@gmail.com', '2013-10-14 16:33:51', 1, 3, NULL),
(48, '::1', '', 'hung123@yahoo.com', '2013-10-14 16:33:51', 1, 3, NULL),
(49, '::1', '', 'liberty042@mail.ru', '2013-10-14 16:33:51', 0, 3, NULL),
(50, '::1', '', 'hung@gmail.com', '2013-10-14 16:33:53', 0, 3, NULL),
(51, '::1', '', 'thanhnien@hotmail.com', '2013-10-14 16:45:14', 1, 4, NULL),
(52, '::1', '', 'minhhai@gmail.com', '2013-10-14 16:45:16', 1, 4, NULL),
(53, '::1', '', 'vnyahoo@yahoo.com', '2013-10-14 16:45:16', 1, 4, NULL),
(54, '::1', '', 'phamminhhai@gmail.com', '2013-10-14 16:45:16', 1, 4, NULL),
(55, '::1', '', 'hung123@yahoo.com', '2013-10-14 16:45:16', 1, 4, NULL),
(56, '::1', '', 'liberty042@mail.ru', '2013-10-14 16:45:16', 0, 4, NULL),
(57, '::1', '', 'hung@gmail.com', '2013-10-14 16:45:19', 0, 4, NULL),
(58, '::1', '', 'thanhnien@hotmail.com', '2013-10-14 16:47:08', 1, 5, NULL),
(59, '::1', '', 'hung123@yahoo.com', '2013-10-14 16:47:09', 1, 5, NULL),
(60, '::1', '', 'vnyahoo@yahoo.com', '2013-10-14 16:47:09', 1, 5, NULL),
(61, '::1', '', 'minhhai@gmail.com', '2013-10-14 16:47:11', 1, 5, NULL),
(62, '::1', '', 'phamminhhai@gmail.com', '2013-10-14 16:47:11', 1, 5, NULL),
(63, '::1', '', 'liberty042@mail.ru', '2013-10-14 16:47:11', 0, 5, NULL),
(64, '::1', '', 'hung@gmail.com', '2013-10-14 16:47:12', 0, 5, NULL),
(65, '::1', '', 'thanhnien@hotmail.com', '2013-10-14 16:49:02', 1, 6, NULL),
(66, '::1', '', 'hung123@yahoo.com', '2013-10-14 16:49:03', 1, 6, NULL),
(67, '::1', '', 'vnyahoo@yahoo.com', '2013-10-14 16:49:04', 1, 6, NULL),
(68, '::1', '', 'minhhai@gmail.com', '2013-10-14 16:49:03', 1, 6, NULL),
(69, '::1', '', 'phamminhhai@gmail.com', '2013-10-14 16:49:04', 1, 6, NULL),
(70, '::1', '', 'liberty042@mail.ru', '2013-10-14 16:49:05', 0, 6, NULL),
(71, '::1', '', 'hung@gmail.com', '2013-10-14 16:49:06', 0, 6, NULL),
(72, '::1', '', 'thanhnien@hotmail.com', '2013-10-14 16:53:26', 1, 7, NULL),
(73, '::1', '', 'hung123@yahoo.com', '2013-10-14 16:53:27', 1, 7, NULL),
(74, '::1', '', 'minhhai@gmail.com', '2013-10-14 16:53:27', 1, 7, NULL),
(75, '::1', '', 'vnyahoo@yahoo.com', '2013-10-14 16:53:27', 1, 7, NULL),
(76, '::1', '', 'phamminhhai@gmail.com', '2013-10-14 16:53:27', 1, 7, NULL),
(77, '::1', '', 'liberty042@mail.ru', '2013-10-14 16:53:29', 0, 7, NULL),
(78, '::1', '', 'hung@gmail.com', '2013-10-14 16:53:29', 0, 7, NULL),
(79, '::1', '', 'hung@gmail.com', '2013-10-17 11:34:24', 0, 8, NULL),
(80, '::1', '', 'thanhnien@hotmail.com', '2013-10-17 11:51:16', 1, 9, NULL),
(81, '::1', '', 'hung123@yahoo.com', '2013-10-17 11:51:16', 1, 9, NULL),
(82, '::1', '', 'vnyahoo@yahoo.com', '2013-10-17 11:51:16', 1, 9, NULL),
(83, '::1', '', 'phamminhhai@gmail.com', '2013-10-17 11:51:17', 1, 9, NULL),
(84, '::1', '', 'liberty042@mail.ru', '2013-10-17 11:51:18', 0, 9, NULL),
(85, '::1', '', 'hung@gmail.com', '2013-10-17 11:51:19', 0, 9, NULL),
(86, '::1', '', 'minhhai@gmail.com', '2013-10-17 11:51:46', 1, 9, NULL),
(87, '::1', '', 'hung@gmail.com', '2013-10-17 15:49:29', 0, 10, NULL),
(88, '::1', '', 'minhhai@gmail.com', '2013-10-17 16:14:46', 1, 11, NULL),
(89, '::1', '', 'minhhai@gmail.com', '2013-10-17 16:22:13', 12, 0, '1'),
(90, '::1', '', 'ddd@', '2013-10-17 16:22:27', 12, 0, ''),
(91, '::1', '', 'minhhai@s', '2013-10-17 16:23:36', 0, 12, 's'),
(92, '::1', '', 'hung@gmail.com', '2013-10-17 16:27:46', 0, 13, 'gmail.com'),
(93, '::1', '', 'thanhnien@hotmail.com', '2013-10-17 16:30:09', 1, 14, 'hotmail.com'),
(94, '::1', '', 'minhhai@gmail.com', '2013-10-17 16:30:09', 1, 14, 'gmail.com'),
(95, '::1', '', 'phamminhhai@gmail.com', '2013-10-17 16:30:09', 1, 14, 'gmail.com'),
(96, '::1', '', 'vnyahoo@yahoo.com', '2013-10-17 16:30:09', 1, 14, 'yahoo.com'),
(97, '::1', '', 'hung123@yahoo.com', '2013-10-17 16:30:10', 1, 14, 'yahoo.com'),
(98, '::1', '', 'hung@gmail.com', '2013-10-17 16:30:11', 0, 14, 'gmail.com'),
(99, '::1', '', 'liberty042@mail.ru', '2013-10-17 16:30:12', 0, 14, 'mail.ru'),
(100, '::1', '', 'thanhnien@hotmail.com', '2013-10-17 16:35:05', 1, 15, 'hotmail.com'),
(101, '::1', '', 'vnyahoo@yahoo.com', '2013-10-17 16:35:05', 1, 15, 'yahoo.com'),
(102, '::1', '', 'minhhai@gmail.com', '2013-10-17 16:35:05', 1, 15, 'gmail.com'),
(103, '::1', '', 'phamminhhai@gmail.com', '2013-10-17 16:35:05', 1, 15, 'gmail.com'),
(104, '::1', '', 'liberty042@mail.ru', '2013-10-17 16:35:07', 0, 15, 'mail.ru'),
(105, '::1', '', 'hung123@yahoo.com', '2013-10-17 16:35:07', 1, 15, 'yahoo.com'),
(106, '::1', '', 'hung@gmail.com', '2013-10-17 16:35:08', 0, 15, 'gmail.com'),
(107, '::1', '', 'minhhai@gmail.com', '2013-10-18 17:52:53', 1, 16, 'gmail.com'),
(108, '::1', '', 'hung@gmail.com', '2013-10-18 17:59:39', 0, 17, 'gmail.com'),
(109, '::1', '', 'minhhai@gmail.com', '2013-10-18 18:00:58', 1, 18, 'gmail.com'),
(110, '::1', '', 'minhhai@gmail.com', '2013-10-18 18:01:29', 1, 19, 'gmail.com'),
(111, '::1', '', 'minhhai@gmail.com', '2013-10-18 18:03:28', 1, 20, 'gmail.com'),
(112, '::1', '', 'hung@gmail.com', '2013-10-18 18:04:19', 0, 21, 'gmail.com'),
(113, '::1', '', 'dark-temnota1991@mail.ru', '2013-10-18 18:05:25', 0, 22, 'mail.ru'),
(114, '::1', '', 'phamminhhai@gmail.com', '2013-10-18 18:07:34', 1, 23, 'gmail.com'),
(115, '::1', '', 'tienphong@gmail.com', '2013-10-18 18:08:33', 1, 24, 'gmail.com'),
(116, '::1', '', 'minhhai@gmail.com', '2013-10-19 18:38:43', 1, 25, 'gmail.com'),
(117, '::1', '', 'minhhai@gmail.com', '2013-10-19 20:14:50', 1, 26, 'gmail.com'),
(118, '::1', '', 'minhhai@gmail.com', '2013-10-19 20:16:18', 1, 27, 'gmail.com'),
(119, '127.0.0.1', '', 'minhhai@gmail.com', '2013-10-22 09:55:26', 1, 28, 'gmail.com'),
(120, '127.0.0.1', '', 'minhhai@gmail.com', '2013-10-22 09:55:49', 1, 29, 'gmail.com'),
(121, '127.0.0.1', '', 'dark-temnota1991@mail.ru', '2013-10-22 09:59:58', 0, 30, 'mail.ru'),
(122, '127.0.0.1', '', 'minhhai@gmail.com', '2013-10-22 10:04:41', 1, 31, 'gmail.com'),
(123, '127.0.0.1', '', 'minhhai@gmail.com', '2013-10-22 11:26:16', 1, 32, 'gmail.com'),
(124, '127.0.0.1', '', 'hung@gmail.com', '2013-10-22 11:26:52', 0, 33, 'gmail.com'),
(125, '127.0.0.1', '', 'phamminhhai@gmail.com', '2013-10-22 11:27:43', 1, 34, 'gmail.com'),
(126, '127.0.0.1', '', 'minhhai@gmail.com', '2013-10-22 11:27:43', 1, 34, 'gmail.com'),
(127, '127.0.0.1', '', 'thanhnien@hotmail.com', '2013-10-22 11:27:44', 1, 34, 'hotmail.com'),
(128, '127.0.0.1', '', 'hung123@yahoo.com', '2013-10-22 11:27:44', 1, 34, 'yahoo.com'),
(129, '127.0.0.1', '', 'vnyahoo@yahoo.com', '2013-10-22 11:27:44', 1, 34, 'yahoo.com'),
(130, '127.0.0.1', '', 'hung@gmail.com', '2013-10-22 11:27:46', 0, 34, 'gmail.com'),
(131, '127.0.0.1', '', 'liberty042@mail.ru', '2013-10-22 11:27:50', 0, 34, 'mail.ru'),
(132, '::1', '', 'hung123@yahoo.com', '2013-10-22 19:22:14', 1, 34, 'yahoo.com'),
(133, '::1', '', 'thanhnien@hotmail.com', '2013-10-22 19:22:14', 1, 34, 'hotmail.com'),
(134, '::1', '', 'vnyahoo@yahoo.com', '2013-10-22 19:22:14', 1, 34, 'yahoo.com'),
(135, '::1', '', 'phamminhhai@gmail.com', '2013-10-22 19:22:15', 1, 34, 'gmail.com'),
(136, '::1', '', 'minhhai@gmail.com', '2013-10-22 19:22:16', 1, 34, 'gmail.com'),
(137, '::1', '', 'liberty042@mail.ru', '2013-10-22 19:22:17', 0, 34, 'mail.ru'),
(138, '::1', '', 'hung@gmail.com', '2013-10-22 19:22:17', 0, 34, 'gmail.com'),
(139, '::1', 'nienn@gmail.com', 'tienphong@gmail.com', '2013-10-27 00:05:13', 1, 35, 'gmail.com'),
(140, '::1', 'nienn@gmail.com', 'minhhai@gmail.com', '2013-10-27 00:07:54', 1, 36, 'gmail.com'),
(141, '::1', 'nienn@gmail.com', 'email@email.com', '2013-10-27 00:17:21', 1, 0, 'email.com'),
(142, '::1', 'nienn@gmail.com', 'email@email.com', '2013-10-27 00:19:22', 1, 0, 'email.com'),
(143, '::1', 'nienn@gmail.com', 'email@email.com', '2013-10-27 00:19:28', 1, 0, 'email.com'),
(144, '::1', 'nienn@gmail.com', 'email@email.com', '2013-10-27 00:19:32', 1, 0, 'email.com'),
(145, '::1', 'nienn@gmail.com', 'minhhai@gmail.com', '2013-10-27 00:19:49', 1, 0, 'gmail.com'),
(146, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 00:20:17', 1, 0, 'email.com'),
(147, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 00:22:08', 0, 37, 'mail.ru'),
(148, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 00:22:17', 0, 0, 'mail.ru'),
(149, '::1', 'nienn@gmail.com', 'thanhnien@hotmail.com', '2013-10-27 11:51:19', 1, 0, 'hotmail.com'),
(150, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 20:56:42', 0, 0, 'mail.ru'),
(151, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 20:56:45', 1, 0, 'email.com'),
(152, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-27 20:56:49', 0, 0, 'gmail.com'),
(153, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 20:57:02', 0, 0, 'email.com.vn'),
(154, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 20:59:52', 0, 0, 'mail.ru'),
(155, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-27 20:59:54', 0, 0, 'gmail.com'),
(156, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 21:00:10', 0, 0, 'email.com.vn'),
(157, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 21:00:58', 1, 0, 'email.com'),
(158, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 21:10:55', 1, 0, 'email.com'),
(159, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-27 21:10:58', 0, 0, 'gmail.com'),
(160, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 21:10:59', 0, 0, 'mail.ru'),
(161, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 21:11:13', 0, 0, 'email.com.vn'),
(162, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 21:41:46', 1, 0, 'email.com'),
(163, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 21:41:49', 0, 0, 'mail.ru'),
(164, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 21:42:06', 0, 0, 'email.com.vn'),
(165, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 21:46:09', 0, 0, 'mail.ru'),
(166, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 21:46:10', 1, 0, 'email.com'),
(167, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 21:46:28', 0, 0, 'email.com.vn'),
(168, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 22:04:45', 1, 0, 'email.com'),
(169, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 22:04:45', 0, 0, 'mail.ru'),
(170, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 22:05:04', 0, 0, 'email.com.vn'),
(171, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 22:06:14', 1, 0, 'email.com'),
(172, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 22:06:15', 0, 0, 'mail.ru'),
(173, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 22:06:34', 0, 0, 'email.com.vn'),
(174, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 22:08:37', 1, 0, 'email.com'),
(175, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 22:08:37', 0, 0, 'mail.ru'),
(176, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 22:08:57', 0, 0, 'email.com.vn'),
(177, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-27 22:15:39', 1, 0, 'email.com'),
(178, '::1', 'nienn@gmail.com', 'email@email.com.rt', '2013-10-27 22:15:39', 0, 0, 'email.com.rt'),
(179, '::1', 'nienn@gmail.com', 'liberty042@mail.ru', '2013-10-27 22:15:39', 0, 0, 'mail.ru'),
(180, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 22:15:40', 0, 0, 'mail.ru'),
(181, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-27 22:15:42', 0, 0, 'gmail.com'),
(182, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-27 22:15:59', 0, 0, 'email.com.vn'),
(183, '::1', 'nienn@gmail.com', 'email@email.com.rt', '2013-10-28 00:09:00', 0, 0, 'email.com.rt'),
(184, '::1', 'nienn@gmail.com', 'hung123@yahoo.com', '2013-10-28 00:09:04', 1, 0, 'yahoo.com'),
(185, '::1', 'nienn@gmail.com', 'liberty042@mail.ru', '2013-10-28 00:09:05', 0, 0, 'mail.ru'),
(186, '::1', 'nienn@gmail.com', 'liberty042@mail.ru', '2013-10-28 00:10:54', 0, 0, 'mail.ru'),
(187, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-28 00:10:56', 0, 0, 'gmail.com'),
(188, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-28 22:47:07', 0, 0, 'email.com.vn'),
(189, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-28 22:47:32', 1, 0, 'email.com'),
(190, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-28 22:48:05', 1, 0, 'email.com'),
(191, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-28 22:49:10', 1, 0, 'email.com'),
(192, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-28 22:49:12', 0, 0, 'mail.ru'),
(193, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-28 22:49:14', 0, 0, 'gmail.com'),
(194, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-28 22:49:30', 0, 0, 'email.com.vn'),
(195, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-10-28 22:53:31', 1, 0, 'email.com'),
(196, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-28 22:53:32', 0, 0, 'mail.ru'),
(197, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-28 22:53:35', 0, 0, 'gmail.com'),
(198, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-28 22:53:52', 0, 0, 'email.com.vn'),
(199, '::1', 'nienn@gmail.com', 'hung123@yahoo.com', '2013-10-30 16:34:53', 1, 0, 'yahoo.com'),
(200, '::1', 'nienn@gmail.com', 'thanhnien@hotmail.com', '2013-10-30 16:34:54', 1, 0, 'hotmail.com'),
(201, '::1', 'nienn@gmail.com', 'vnyahoo@yahoo.com', '2013-10-30 16:34:54', 1, 0, 'yahoo.com'),
(202, '::1', 'nienn@gmail.com', 'liberty042@mail.ru', '2013-10-30 16:34:54', 0, 0, 'mail.ru'),
(203, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-30 16:34:57', 0, 0, 'gmail.com'),
(204, '::1', 'nienn@gmail.com', 'hung123@yahoo.com', '2013-10-30 16:45:04', 1, 0, 'yahoo.com'),
(205, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-30 16:45:06', 0, 0, 'gmail.com'),
(206, '::1', 'nienn@gmail.com', 'email@email.com.vn', '2013-11-03 12:42:24', 0, 0, 'email.com.vn'),
(207, '::1', '', 'minhhai@gmail.com', '2013-11-03 15:21:04', 1, 38, 'gmail.com'),
(208, '::1', '', 'hung@gmail.com', '2013-11-03 15:21:31', 0, 39, 'gmail.com'),
(209, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-11-03 16:47:34', 1, 0, 'email.com'),
(210, '::1', 'nienn@gmail.com', 'thanhnien@hotmail.com', '2013-11-03 16:47:34', 1, 0, 'hotmail.com'),
(211, '::1', 'nienn@gmail.com', 'hung123@yahoo.com', '2013-11-03 16:47:34', 1, 0, 'yahoo.com'),
(212, '::1', 'nienn@gmail.com', 'vnyahoo@yahoo.com', '2013-11-03 16:47:35', 1, 0, 'yahoo.com'),
(213, '::1', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-11-03 16:47:35', 0, 0, 'mail.ru'),
(214, '::1', 'nienn@gmail.com', 'email@email.com.rt', '2013-11-03 16:47:36', 0, 0, 'email.com.rt'),
(215, '::1', 'nienn@gmail.com', 'liberty042@mail.ru', '2013-11-03 16:47:37', 0, 0, 'mail.ru'),
(216, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-11-03 16:47:38', 0, 0, 'gmail.com'),
(217, '::1', 'nienn@gmail.com', '777ewgeniya777@mail.ru', '2013-11-03 17:08:53', 0, 0, 'mail.ru'),
(218, '::1', 'nienn@gmail.com', 'phamminhhai@gmail.com', '2013-11-03 17:58:54', 1, 0, 'gmail.com'),
(219, '::1', 'nienn@gmail.com', 'phamminhhai@gmail.com', '2013-11-03 17:59:22', 1, 0, 'gmail.com'),
(220, '::1', 'nienn@gmail.com', 'phamminhhai@gmail.com', '2013-11-03 18:02:19', 1, 0, 'gmail.com'),
(221, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-11-04 21:19:27', 1, 0, 'email.com'),
(222, '::1', 'nienn@gmail.com', 'elmaribrahimli@mail.ru', '2013-11-04 21:19:56', 0, 0, 'mail.ru'),
(223, '::1', 'nienn@gmail.com', 'bespridelschic@mail.ru', '2013-11-04 21:21:35', 0, 0, 'mail.ru'),
(224, '::1', 'nienn@gmail.com', 'hung@gmail.com', '2013-11-16 11:09:54', 0, 0, 'gmail.com'),
(225, '::1', 'nienn@gmail.com', 'email1@email.com', '2013-11-16 11:53:53', 1, 0, 'email.com');

-- --------------------------------------------------------

--
-- Table structure for table `emailconfig`
--

CREATE TABLE IF NOT EXISTS `emailconfig` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Protocol` varchar(1000) NOT NULL,
  `smtp_host` varchar(1000) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `LastUsedDate` date DEFAULT NULL,
  `NumberSentEmail` int(11) DEFAULT NULL,
  `NumberSendPerDate` int(11) DEFAULT NULL,
  `NumberSentEmailToday` int(11) DEFAULT NULL,
  `Status` int(11) NOT NULL,
  `Deleted` tinyint(1) DEFAULT NULL,
  `Note` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `emailconfig`
--

INSERT INTO `emailconfig` (`ID`, `Email`, `Password`, `Protocol`, `smtp_host`, `smtp_port`, `CreatedDate`, `LastUsedDate`, `NumberSentEmail`, `NumberSendPerDate`, `NumberSentEmailToday`, `Status`, `Deleted`, `Note`) VALUES
(1, 'hfwtest01@gmail.com', 'qazwsxcd', 'smtp', 'ssl://smtp.googlemail.com', 465, '2013-12-11', NULL, 0, 500, 0, 1, NULL, 'ok'),
(2, 'notification_im-tool.vn_service_center111111111@lpcorporation.com', 'RLnC33y', 'smtp', 'lpcorporation.com', 25, '2013-12-08', NULL, 0, 500, 0, 1, NULL, 'd'),
(3, 'notification_im-tool.vn_service_center111111111@lpcorporation.com', 'RLnC33y', 'smtp', 'lpcorporation.com', 25, '2013-12-08', NULL, 0, 500, 0, 1, NULL, 'd');

-- --------------------------------------------------------

--
-- Table structure for table `general`
--

CREATE TABLE IF NOT EXISTS `general` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(500) NOT NULL,
  `Content` text NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `Title` varchar(500) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `general`
--

INSERT INTO `general` (`ID`, `Name`, `Content`, `CreatedDate`, `UpdatedDate`, `Title`) VALUES
(1, 'Policy', '<div>Mọi hoạt động tr&ecirc;n website tu&acirc;n thủ theo Nghị định <strong>90/2008/NĐ-CP</strong> ban h&agrave;nh ng&agrave;y 13/08/2008 của ch&iacute;nh phủ.</div>\r\n<p>&nbsp;</p>\r\n<div><strong>1. Thư r&aacute;c (Spam) l&agrave; g&igrave;?</strong> Thư r&aacute;c (spam) l&agrave; thư điện tử, tin nhắn được gửi đến người nhận m&agrave; người nhận đ&oacute; kh&ocirc;ng mong muốn hoặc kh&ocirc;ng c&oacute; tr&aacute;ch nhiệm phải tiếp nhận theo quy định của ph&aacute;p luật. Thư r&aacute;c gồm thư điện tử r&aacute;c v&agrave; tin nhắn r&aacute;c</div>\r\n<p>&nbsp;</p>\r\n<div><strong>2. Khi n&agrave;o th&igrave; bạn vi phạm luật?</strong><br /> - Thu thập địa chỉ email nhằm mục đ&iacute;ch quảng c&aacute;o m&agrave; kh&ocirc;ng được sự đồng &yacute; của người sở hữu email.<br /> Tạo điều kiện, cho ph&eacute;p người kh&aacute;c sử dụng phương tiện điện tử thuộc quyền của m&igrave;nh để gửi, chuyển tiếp thư r&aacute;c.<br /> - Trao đổi, mua b&aacute;n hoặc ph&aacute;t t&aacute;n c&aacute;c phần mềm thu thập địa chỉ điện tử hoặc quyền sử dụng c&aacute;c phần mềm thu thập địa chỉ điện tử; trao đổi mua b&aacute;n danh s&aacute;ch địa chỉ điện tử hoặc quyền sử dụng danh s&aacute;ch địa chỉ điện tử nhằm mục đ&iacute;ch gửi thư r&aacute;c...<br /> - Gửi qu&aacute; 5 thư điện tử quảng c&aacute;o đến 1 địa chỉ thư điện tử trong 24 giờ, trừ trường hợp c&oacute; thỏa thuận kh&aacute;c với người nhận.<br /> - Phi phạm quy định về từ chối nhận th&ocirc;ng tin quảng c&aacute;o.</div>\r\n<p>&nbsp;</p>\r\n<div><strong>&nbsp;3.</strong> </div>', '2013-11-17 00:00:00', '2013-12-04 22:28:08', 'Quy định sử dụng dịch vụ Email Marketing'),
(2, 'faq', 'ok', '2013-12-04 00:00:00', '2013-12-05 00:00:00', 'Các câu hỏi thường gặp');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
  `UserName` varchar(50) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `Level` tinyint(4) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Note` text,
  `LastLogin` datetime DEFAULT NULL,
  `Password` varchar(50) NOT NULL,
  `MobilePhone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`UserName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`UserName`, `FullName`, `CreatedDate`, `UpdatedDate`, `Level`, `Status`, `Note`, `LastLogin`, `Password`, `MobilePhone`) VALUES
('admin', 'Quản Lý', '2013-11-20 00:00:00', '2013-11-20 00:00:00', 1, 1, '', '2013-12-11 20:57:33', 'admin', NULL),
('admin2', 'Nhân viên 1', '2013-11-23 00:00:00', '2013-12-02 22:58:21', 2, 1, 'ok', '2013-11-23 22:16:16', 'admin', '099998989'),
('admin3', 'hh', '2013-12-03 23:02:40', '2013-12-03 23:02:40', 2, 1, 'a', NULL, 'admin', '09902'),
('admin4', 'hh', '2013-12-03 23:05:02', '2013-12-03 23:05:02', 1, 1, '', NULL, '09', '');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `EmailAddress` varchar(100) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `DateRegistry` datetime NOT NULL,
  `Level` tinyint(4) DEFAULT NULL,
  `MobilePhone` varchar(15) DEFAULT NULL,
  `Manager` varchar(50) DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `LastDateLogin` date DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  PRIMARY KEY (`EmailAddress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`EmailAddress`, `Password`, `Name`, `DateRegistry`, `Level`, `MobilePhone`, `Manager`, `UpdatedDate`, `LastDateLogin`, `Status`) VALUES
('a@yahoo.com', '12345', 'Hung', '2013-10-22 00:00:00', 1, '0999090', 'admin2', '2013-11-23 21:57:44', NULL, 1),
('admin@admin.com', '12345', 'admin', '2013-10-28 13:09:59', NULL, '0988998989', NULL, NULL, NULL, 0),
('ađa@ga.com', '', 'Huf', '2013-10-22 00:00:00', 1, '09909090', NULL, '2013-11-23 21:38:31', NULL, 1),
('d', '1', 'd', '2013-10-22 00:00:00', NULL, NULL, NULL, NULL, NULL, 0),
('nienn@gmail.com', '1234567', 'Nien 1', '2013-10-21 00:00:00', 3, 'Nien 1', 'admin', '2013-11-23 21:38:43', '2013-12-01', 1),
('tha@hotmail.com', '', 'Full Name', '2013-10-22 00:00:00', NULL, NULL, NULL, NULL, NULL, 0),
('than1@gmail.com', '12345', 'Hung', '2013-10-21 00:00:00', NULL, NULL, NULL, NULL, NULL, 0),
('than@gmail.com', '12345', '0', '2013-10-21 00:00:00', NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `EmailUser` varchar(50) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `Content` text NOT NULL,
  `Note` text,
  `Deleted` tinyint(1) DEFAULT NULL,
  `Name` varchar(500) NOT NULL,
  `Subject` varchar(500) NOT NULL,
  `Greet` text,
  `Status` tinyint(4) NOT NULL,
  `LastRun` timestamp NULL DEFAULT NULL,
  `NextRun` datetime DEFAULT NULL,
  `Period` tinyint(4) DEFAULT NULL,
  `SendTo` mediumtext,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`ID`, `EmailUser`, `CreatedDate`, `UpdatedDate`, `Content`, `Note`, `Deleted`, `Name`, `Subject`, `Greet`, `Status`, `LastRun`, `NextRun`, `Period`, `SendTo`) VALUES
(1, 'nienn@gmail.com', '2013-11-10 11:14:58', '2013-11-29 22:03:12', '<p>&nbsp;</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr bgcolor="#EDEDED">\r\n<td colspan="2" align="left" valign="top">\r\n<div align="center">No image</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="center" valign="middle" bgcolor="#72B706" width="211"><span class="text3">ta</span></td>\r\n<td class="brder" align="center" valign="middle" bgcolor="#72B706" width="341"><span class="text3">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF">\r\n<p class="text4"><span class="text4">In this issue:</span><br /> <br /> &bull; <a class="text1" href="#1">latest news</a><br /> &bull; <a class="text1" href="#2">main article</a><br /> &bull; <a class="text1" href="#3">special offers</a><br /> &bull; <a class="text1" href="#4">business tips</a><br /> &bull; <a class="text1" href="#5">success story</a><br /> &bull; <a class="text1" href="#6">your free downloads</a></p>\r\n</td>\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF" width="351">\r\n<p class="text5"><span class="style14"><a name="1"></a></span><span class="text4">LATEST NEWS<br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. <br /> kasd gubergren, no sea takimata sanctus est Lorem <br /> At vero eos et accusam et justo duo dolores et ea rebum. <br /> kasd gubergren, no sea takimata sanctus est</p>\r\n</td>\r\n</tr>\r\n<tr class="brder" bgcolor="#FFFFFF">\r\n<td rowspan="2" align="left" valign="top" bgcolor="#EDEDED" width="220"><a name="2"></a><span class="text4">MAIN ARTICLE</span>\r\n<p class="text5"><span class="text1">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. At vero eos <br /> <br /> <span class="text1">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span> <br /> <br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer adipiscing elit</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh euism</a></p>\r\n</td>\r\n<td align="left" valign="top" bgcolor="#EDEDED" width="351">\r\n<p class="text1"><strong><a name="3"></a></strong><span class="text4">SPECIAL OFFERS</span><br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="4"></a></strong><span class="text4"><strong>BUSINESS TIPS</strong></span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <span class="text5"><strong><a name="5"></a></strong><strong class="text4">SUCCESS STORY</strong> <br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea akimata sanctus est Lorem ipsum dolor sit amet. </span></p>\r\n</td>\r\n</tr>\r\n<tr bgcolor="#FFFFFF">\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF"><span class="style25"><strong><a name="6"></a></strong></span><span class="text4"><span class="text4">FREE DOWNLOADS</span><br /> <br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer adipiscing elit</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh euism</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer adipiscing elit</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh euism</a></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#72B706">\r\n<td colspan="2"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a></span></td>\r\n</tr>\r\n<tr class="brder" align="center" valign="middle" bgcolor="#FFFFFF">\r\n<td class="brder" colspan="2"><span class="text5">If you wish to cancel your subscription to this newsletter <a class="text5" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', 'ok nha', NULL, 'thư gửi thứ nhất đựoc đổi', 'tiều đề thử gửi', 'chào [[Name]]', 1, '2013-11-29 15:03:31', '2013-11-16 00:00:00', 1, ',7,'),
(2, 'nienn@gmail.com', '2013-11-11 21:43:49', '2013-11-14 21:56:49', '<p>nội dung chưa c&oacute;</p>', '', NULL, 'thư thứ 2', 'Mời tham dự gì đó', 'Chào bạn', 1, NULL, '2013-11-08 00:00:00', 0, ','),
(3, 'nienn@gmail.com', '2013-11-11 21:44:11', '2013-11-14 21:56:49', '', '', NULL, 'thư thứ 2', 'Mời tham dự gì đó', 'Chào bạn 2', 0, NULL, '2013-11-14 00:00:00', 0, ',6,'),
(4, 'nienn@gmail.com', '2013-11-11 22:01:33', '2013-11-11 22:01:33', '<p>&nbsp;</p>\r\n<p>Your Newsletter</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr bgcolor="#D9DDC2">\r\n<td colspan="3" align="left" valign="top" bgcolor="#DEDEDE">\r\n<div align="center"><img src="images/logo.gif" alt="" width="540" height="90" /></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td align="center" valign="middle" bgcolor="AFAFAF" width="212"><span class="text3">Newsletter title </span></td>\r\n<td colspan="2" align="center" valign="middle" bgcolor="AFAFAF"><span class="text3">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF" width="212">\r\n<p><span class="text3">In this issue:</span><br /> <span class="text4">&bull; <a class="text1" href="#1">latest news</a><br /> &bull; <a class="text1" href="#2">main article</a><br /> &bull; <a class="text1" href="#3">special offers</a><br /> &bull; <a class="text1" href="#4">business tips</a><br /> &bull; <a class="text1" href="#5">success story</a><br /> &bull; <a class="text1" href="#6">your free downloads</a></span></p>\r\n</td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#FFFFFF">\r\n<p class="text1"><strong><a name="3"></a></strong><span class="text4">SPECIAL OFFERS</span><br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut</p>\r\n</td>\r\n</tr>\r\n<tr class="brder" bgcolor="#FFFFFF">\r\n<td align="left" valign="top" bgcolor="B4D8E8" width="212"><a name="2"></a><span class="text4">MAIN ARTICLE</span>\r\n<p class="text1">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>\r\n<p class="text1">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>\r\n</td>\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF" width="156">\r\n<p class="text1"><strong><a name="4"></a></strong><span class="text4"><strong>BUSINESS TIPS</strong></span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>\r\n<p class="text1">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> nonumy eirmod tempor invidunt ut labore et dolore</p>\r\n</td>\r\n<td class="brder" align="left" valign="top" bgcolor="AEAEAE" width="164">\r\n<p class="text1"><span class="text1"><span class="style14"><a name="1"></a></span><span class="text4">LATEST NEWS<br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est Lorem At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est </span></p>\r\n<p class="text1">At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est Lorem At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est</p>\r\n</td>\r\n</tr>\r\n<tr bgcolor="#FFFFFF">\r\n<td align="left" valign="top" bgcolor="B4D8E8" width="212"><span class="text1"><strong><a name="5"></a></strong><strong class="text4">SUCCESS STORY</strong> <br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea akimata sanctus est Lorem ipsum dolor sit amet. </span></td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#FFFFFF">\r\n<p><span class="style25"><strong><a name="6"></a></strong></span><span class="text4"><span class="text4">FREE DOWNLOADS</span><br /> <br /> <strong class="text4">&bull;</strong><a class="text1" href="#">amet consectetuer ad</a><a class="text1" href="#">ipiscing</a><a class="text1" href="#">amet consectetuer ad</a><a class="text1" href="#">ipis</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh euism nonummy nibh euism</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer adipiscing consectetuer adipiscing </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh diam nonummy nibh euism</a></span></p>\r\n</td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#859032">\r\n<td colspan="3" bgcolor="#AFAFAF"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#FFFFFF">\r\n<td colspan="3"><span class="text5">If you wish to cancel your subscription to this newsletter <a class="text5" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', '					', NULL, 'cái thư gửi đây', 'thư này để quảng cáo', 'Chào nha', 0, NULL, NULL, NULL, NULL),
(5, 'nienn@gmail.com', '2013-11-14 20:04:49', '2013-11-14 20:04:49', '<p>&nbsp;</p>\r\n<p>Your Newsletter</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr bgcolor="#C9C89C">\r\n<td colspan="3" align="left" valign="top">\r\n<div align="center">Ch&agrave;o cấc bạn</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="center" valign="middle" bgcolor="#FFFFFF" width="154"><span class="text4">Newsletter title </span></td>\r\n<td class="brder" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><span class="text4">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td align="left" valign="top" bgcolor="#C9C89C">\r\n<p><span class="text3">In this issue:</span><br /> <br /> <span class="text4">&bull; <a class="text4" href="#1">latest news</a><br /> &bull; <a class="text4" href="#2">main article</a><br /> &bull; <a class="text4" href="#3">special offers</a><br /> &bull; <a class="text4" href="#4">business tips</a><br /> &bull; <a class="text4" href="#5">success story</a><br /> &bull; <a class="text4" href="#6">your free downloads</a></span></p>\r\n</td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#C9C89C">\r\n<p><span class="style14"><a name="1"></a></span><span class="text4">LATEST NEWS<br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita <br /> kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit<br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita <br /> kasd gubergren, no sea takimata sanctus est </p>\r\n</td>\r\n</tr>\r\n<tr class="brder" bgcolor="#FFFFFF">\r\n<td colspan="3" align="left" valign="top"><a name="2"></a><span class="text3">MAIN ARTICLE</span>\r\n<p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> takimata sanctus est Lorem ipsum dolor sit amet.<br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod <br /> invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos <br /> accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. At vero eos <br /> <br /> <strong><a name="3"></a></strong><span class="text3">SPECIAL OFFERS</span><br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="4"></a></strong><span class="text3"><strong>BUSINESS TIPS</strong></span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="5"></a></strong><strong class="text3">SUCCESS STORY</strong> <br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</p>\r\n</td>\r\n</tr>\r\n<tr bgcolor="#FFFFFF">\r\n<td class="brder" colspan="2" align="center" valign="middle">Advertisment</td>\r\n<td class="brder" align="left" valign="top" width="341"><span class="style25"><strong><a name="6"></a></strong></span><span class="text4"><span class="text3">FREE DOWNLOADS</span><br /> <br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">amet consectetuer adipiscing elit </a><a class="text2" href="#">dolor in hendrerit in</a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">sed diam nonummy nibh euism</a><a class="text2" href="#">a dipiscing elit </a><a class="text2" href="#">dolor </a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">amet consectetuer adipiscing elit </a><a class="text2" href="#">dolor in hendrerit in </a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">sed diam nonummy nibh euism</a><a class="text2" href="#">a dipiscing elit </a><a class="text2" href="#">dolor </a></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#C9C89C">\r\n<td colspan="3"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a> </span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#68685E">\r\n<td colspan="3"><span class="text6">If you wish to cancel your subscription to this newsletter <a class="text6" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td width="37">&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', 'thử					', NULL, 'template', 'Chào các bạn', 'Lời Chào', 0, NULL, NULL, NULL, NULL),
(6, 'nienn@gmail.com', '2013-11-14 20:05:56', '2013-11-14 21:56:38', '<p>&nbsp;</p>\r\n<p>Your Newsletter</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr bgcolor="#C9C89C">\r\n<td colspan="3" align="left" valign="top">\r\n<div align="center">Ch&agrave;o cấc bạn</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="center" valign="middle" bgcolor="#FFFFFF" width="154"><span class="text4">Newsletter title </span></td>\r\n<td class="brder" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><span class="text4">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td align="left" valign="top" bgcolor="#C9C89C">\r\n<p><span class="text3">In this issue:</span><br /> <br /> <span class="text4">&bull; <a class="text4" href="#1">latest news</a><br /> &bull; <a class="text4" href="#2">main article</a><br /> &bull; <a class="text4" href="#3">special offers</a><br /> &bull; <a class="text4" href="#4">business tips</a><br /> &bull; <a class="text4" href="#5">success story</a><br /> &bull; <a class="text4" href="#6">your free downloads</a></span></p>\r\n</td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#C9C89C">\r\n<p><span class="style14"><a name="1"></a></span><span class="text4">LATEST NEWS<br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita <br /> kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit<br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita <br /> kasd gubergren, no sea takimata sanctus est </p>\r\n</td>\r\n</tr>\r\n<tr class="brder" bgcolor="#FFFFFF">\r\n<td colspan="3" align="left" valign="top"><a name="2"></a><span class="text3">MAIN ARTICLE</span>\r\n<p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> takimata sanctus est Lorem ipsum dolor sit amet.<br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod <br /> invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos <br /> accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. At vero eos <br /> <br /> <strong><a name="3"></a></strong><span class="text3">SPECIAL OFFERS</span><br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="4"></a></strong><span class="text3"><strong>BUSINESS TIPS</strong></span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="5"></a></strong><strong class="text3">SUCCESS STORY</strong> <br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</p>\r\n</td>\r\n</tr>\r\n<tr bgcolor="#FFFFFF">\r\n<td class="brder" colspan="2" align="center" valign="middle">Advertisment</td>\r\n<td class="brder" align="left" valign="top" width="341"><span class="style25"><strong><a name="6"></a></strong></span><span class="text4"><span class="text3">FREE DOWNLOADS</span><br /> <br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">amet consectetuer adipiscing elit </a><a class="text2" href="#">dolor in hendrerit in</a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">sed diam nonummy nibh euism</a><a class="text2" href="#">a dipiscing elit </a><a class="text2" href="#">dolor </a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">amet consectetuer adipiscing elit </a><a class="text2" href="#">dolor in hendrerit in </a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">sed diam nonummy nibh euism</a><a class="text2" href="#">a dipiscing elit </a><a class="text2" href="#">dolor </a></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#C9C89C">\r\n<td colspan="3"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a> </span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#68685E">\r\n<td colspan="3"><span class="text6">If you wish to cancel your subscription to this newsletter <a class="text6" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td width="37">&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', 'thử					', NULL, 'template', 'Chào các bạn', 'Lời Chào', 1, NULL, '2013-11-21 00:00:00', 0, ',-1,'),
(7, 'nienn@gmail.com', '2013-11-20 21:28:46', '2013-11-20 21:29:22', '<p>&nbsp;</p>\r\n<p>Your Newsletter</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr bgcolor="#EDEDED">\r\n<td colspan="2" align="left" valign="top">\r\n<div align="center"><img src="images/logo.gif" alt="" width="540" height="90" /></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="center" valign="middle" bgcolor="#72B706" width="211"><span class="text3">Newsletter title </span></td>\r\n<td class="brder" align="center" valign="middle" bgcolor="#72B706" width="341"><span class="text3">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF">\r\n<p class="text4"><span class="text4">In this issue:</span><br /> <br /> &bull; <a class="text1" href="#1">latest news</a><br /> &bull; <a class="text1" href="#2">main article</a><br /> &bull; <a class="text1" href="#3">special offers</a><br /> &bull; <a class="text1" href="#4">business tips</a><br /> &bull; <a class="text1" href="#5">success story</a><br /> &bull; <a class="text1" href="#6">your free downloads</a></p>\r\n</td>\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF" width="351">\r\n<p class="text5"><span class="style14"><a name="1"></a></span><span class="text4">LATEST NEWS<br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. <br /> kasd gubergren, no sea takimata sanctus est Lorem <br /> At vero eos et accusam et justo duo dolores et ea rebum. <br /> kasd gubergren, no sea takimata sanctus est </p>\r\n</td>\r\n</tr>\r\n<tr class="brder" bgcolor="#FFFFFF">\r\n<td rowspan="2" align="left" valign="top" bgcolor="#EDEDED" width="220"><a name="2"></a><span class="text4">MAIN ARTICLE</span>\r\n<p class="text5"><span class="text1">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. At vero eos <br /> <br /> <span class="text1">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span> <br /> <br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer adipiscing elit</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh euism</a></p>\r\n</td>\r\n<td align="left" valign="top" bgcolor="#EDEDED" width="351">\r\n<p class="text1"><strong><a name="3"></a></strong><span class="text4">SPECIAL OFFERS</span><br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="4"></a></strong><span class="text4"><strong>BUSINESS TIPS</strong></span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <span class="text5"><strong><a name="5"></a></strong><strong class="text4">SUCCESS STORY</strong> <br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea akimata sanctus est Lorem ipsum dolor sit amet. </span></p>\r\n</td>\r\n</tr>\r\n<tr bgcolor="#FFFFFF">\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF"><span class="style25"><strong><a name="6"></a></strong></span><span class="text4"><span class="text4">FREE DOWNLOADS</span><br /> <br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer adipiscing elit</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh euism</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer adipiscing elit</a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh euism</a></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#72B706">\r\n<td colspan="2"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a></span></td>\r\n</tr>\r\n<tr class="brder" align="center" valign="middle" bgcolor="#FFFFFF">\r\n<td class="brder" colspan="2"><span class="text5">If you wish to cancel your subscription to this newsletter <a class="text5" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', '', NULL, 'bứcc thư gửi tới tất cả các bạn luôn đó nghe chưa hả', 'Chào các bạn', 'Chào', 0, NULL, '2013-11-20 00:00:00', 0, ',-1,1,'),
(8, 'nienn@gmail.com', '2013-11-24 10:22:50', '2013-11-24 10:23:15', '<p>&nbsp;</p>\r\n<p>Your Newsletter</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr bgcolor="#E2D6CA">\r\n<td colspan="4" align="left" valign="top">\r\n<div align="center">hello</div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" align="center" valign="middle" bgcolor="B1A398"><span class="text3">Newsletter title </span></td>\r\n<td colspan="2" align="center" valign="middle" bgcolor="B1A398"><span class="text3">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td class="brder" colspan="3" align="left" valign="top" bgcolor="#FFFFFF">\r\n<p><span class="text1"><strong><a name="3"></a></strong><span class="text4">SPECIAL OFFERS</span><br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut</span></p>\r\n</td>\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF" width="187">\r\n<p class="text1"><span class="text4">In this issue:</span><br /> <br /> <span class="text4">&bull; <a class="text5" href="#1">latest news</a><br /> &bull; <a class="text5" href="#2">main article</a><br /> &bull; <a class="text5" href="#3">special offers</a><br /> &bull; <a class="text5" href="#4">business tips</a><br /> &bull; <a class="text5" href="#5">success story</a><br /> &bull; <a class="text5" href="#6">your free downloads</a></span></p>\r\n</td>\r\n</tr>\r\n<tr class="brder" bgcolor="C6BAAE">\r\n<td class="brder" colspan="4" align="left" valign="top"><a name="2"></a><span class="text3">MAIN ARTICLE</span>\r\n<p class="text1">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. <br /> <br /> <strong><a name="4"></a></strong><span class="text3"><strong>BUSINESS TIPS</strong></span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua</p>\r\n</td>\r\n</tr>\r\n<tr class="brder" align="left" bgcolor="#C6D963">\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF" width="192"><span class="text1"><strong><a name="5"></a></strong><strong class="text4">SUCCESS STORY</strong> <br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea akimata sanctus est Lorem ipsum dolor sit amet. </span></td>\r\n<td colspan="2" align="left" valign="top" bgcolor="#E2D6CA"><span class="text1"><span class="style25"><strong><a name="6"></a></strong></span><span class="text4">FREE DOWNLOADS<br /> <br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a></span></span></td>\r\n<td class="brder" rowspan="2" align="left" valign="top" bgcolor="#FFFFFF" width="187"><span class="text1"><span class="style14"><a name="1"></a></span><span class="text4">LATEST NEWS<br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est Lorem At vero eos et accusam <br /> At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est Lorem At vero eos et accusam</span></td>\r\n</tr>\r\n<tr class="brder" align="left">\r\n<td class="brder" align="left" valign="top" bgcolor="#FFFFFF"><span class="text1"><span class="text4"><strong class="text4"><strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a><br /> &bull;</strong> <a class="text1" href="#">amet consectetuer </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a></span></span></td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#FFFFFF"><span class="text1"><span class="text4"><strong class="text4"><strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a><br /> &bull;</strong> <a class="text1" href="#">amet consectetuer </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><br /> <strong class="text4">&bull;</strong> <a class="text1" href="#">sed diam nonummy nibh </a></span></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#B1A398">\r\n<td colspan="4"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#FFFFFF">\r\n<td colspan="4"><span class="text5">If you wish to cancel your subscription to this newsletter <a class="text5" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td width="2">&nbsp;</td>\r\n<td width="152">&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', 'chưa gửi', NULL, 'thử 3', 'tiêu đề', 'chào', 0, NULL, '2013-11-24 00:00:00', 0, ','),
(9, 'nienn@gmail.com', '2013-11-29 21:43:37', '2013-11-29 21:57:29', '<p>&nbsp;</p>\r\n<p>Your Newsletter</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr bgcolor="#C9C89C">\r\n<td colspan="3" align="left" valign="top">\r\n<div align="center"><img src="images/logo.gif" alt="" width="540" height="90" /></div>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="brder" align="center" valign="middle" bgcolor="#FFFFFF" width="154"><span class="text4">Newsletter title </span></td>\r\n<td class="brder" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><span class="text4">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td align="left" valign="top" bgcolor="#C9C89C">\r\n<p><span class="text3">In this issue:</span><br /> <br /> <span class="text4">&bull; <a class="text4" href="#1">latest news</a><br /> &bull; <a class="text4" href="#2">main article</a><br /> &bull; <a class="text4" href="#3">special offers</a><br /> &bull; <a class="text4" href="#4">business tips</a><br /> &bull; <a class="text4" href="#5">success story</a><br /> &bull; <a class="text4" href="#6">your free downloads</a></span></p>\r\n</td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#C9C89C">\r\n<p><span class="style14"><a name="1"></a></span><span class="text4">LATEST NEWS<br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita <br /> kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit<br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita <br /> kasd gubergren, no sea takimata sanctus est </p>\r\n</td>\r\n</tr>\r\n<tr class="brder" bgcolor="#FFFFFF">\r\n<td colspan="3" align="left" valign="top"><a name="2"></a><span class="text3">MAIN ARTICLE</span>\r\n<p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> takimata sanctus est Lorem ipsum dolor sit amet.<br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod <br /> invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos <br /> accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. At vero eos <br /> <br /> <strong><a name="3"></a></strong><span class="text3">SPECIAL OFFERS</span><br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="4"></a></strong><span class="text3"><strong>BUSINESS TIPS</strong></span><br /> <br /> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.<br /> <br /> <strong><a name="5"></a></strong><strong class="text3">SUCCESS STORY</strong> <br /> <br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea <br /> akimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</p>\r\n</td>\r\n</tr>\r\n<tr bgcolor="#FFFFFF">\r\n<td class="brder" colspan="2" align="center" valign="middle">Advertisment</td>\r\n<td class="brder" align="left" valign="top" width="341"><span class="style25"><strong><a name="6"></a></strong></span><span class="text4"><span class="text3">FREE DOWNLOADS</span><br /> <br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">amet consectetuer adipiscing elit </a><a class="text2" href="#">dolor in hendrerit in</a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">sed diam nonummy nibh euism</a><a class="text2" href="#">a dipiscing elit </a><a class="text2" href="#">dolor </a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">amet consectetuer adipiscing elit </a><a class="text2" href="#">dolor in hendrerit in </a><br /> <strong class="text4">&bull;</strong> <a class="text2" href="#">sed diam nonummy nibh euism</a><a class="text2" href="#">a dipiscing elit </a><a class="text2" href="#">dolor </a></span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#C9C89C">\r\n<td colspan="3"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a> </span></td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#68685E">\r\n<td colspan="3"><span class="text6">If you wish to cancel your subscription to this newsletter <a class="text6" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td width="37">&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', '', NULL, 'Thư gửi luôn', 'Thử này là thư test gửi luôn', 'chào bạn [[Name]]]', 0, '2013-11-29 14:57:43', '2013-11-29 00:00:00', 0, ',7,'),
(10, 'nienn@gmail.com', '2013-11-29 21:58:19', '2013-11-29 21:58:38', '<p>&nbsp;</p>\r\n<p>Your Newsletter</p>\r\n<div><center>\r\n<table class="brder" border="0" width="570" cellspacing="1" cellpadding="5"><!--DWLayoutTable-->\r\n<tbody>\r\n<tr align="left" bgcolor="#2F4666">\r\n<td class="brder" colspan="4" align="center" valign="middle" bgcolor="#BDBDBD"><img src="images/logo.gif" alt="" width="540" height="90" /></td>\r\n</tr>\r\n<tr>\r\n<td colspan="2" align="center" valign="middle"><span class="text3">Newsletter title </span></td>\r\n<td colspan="2" align="center" valign="middle"><span class="text3">date # / issue #</span></td>\r\n</tr>\r\n<tr>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="D5D5D5">\r\n<p><span class="text3"><span class="text3">In this issue:</span><br /> <br /> &bull; <a class="text1" href="#1">latest news</a><br /> &bull; <a class="text1" href="#2">main article</a><br /> &bull; <a class="text1" href="#3">special offers</a><br /> &bull; <a class="text1" href="#4">business tips</a><br /> &bull; <a class="text1" href="#5">success story</a><br /> &bull; <a class="text1" href="#6">your free downloads</a></span></p>\r\n</td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#FFFFFF">\r\n<p class="text3"><span class="style14"><a id="4" name="4"></a></span>BUSINESS TIPS <br /> <span class="text5"><br /> At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est At vero eos et accusam et justo duo dolores et ea . kasd gubergren,</span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="191919">\r\n<p class="text3"><a name="2"></a><span class="text4">MAIN ARTICLE</span></p>\r\n<p class="text4">At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br /> <br /> <span class="text6">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. At vero eos</span></p>\r\n</td>\r\n<td class="brder" colspan="2" rowspan="2" align="left" valign="top" bgcolor="#D5D5D5">\r\n<p><span class="text3"><span class="style14"><a name="1"></a></span>LATEST NEWS<br /> <span class="text6"><br /> </span></span><span class="text1">At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est At vero eos et accusam et justo duo dolores et ea . kasd gubergren, </span></p>\r\n<p><span class="text3"><span class="text1">At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est </span></span><br /> <br /> <span class="text1"><span class="text3"><strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#">sed diam nonummy </a><br /> <strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#"> diam nonummy </a></span><br /> <span class="text3"><strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#">sed diam nonummy </a></span></span></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" height="75"><span class="text1">At vero eos accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. vero eos. Lorem ipsum dolor sit amet. At vero eos. At vero eos accusam et justo duo dolores et ea rebum.</span></td>\r\n</tr>\r\n<tr class="brder" bgcolor="#FFFFFF">\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="888888" height="100">\r\n<p><strong><a name="3"></a></strong><span class="text4">SPECIAL OFFERS</span></p>\r\n<p class="text6">At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus est At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus gubergren, no sea takimata sanctus est At vero eos et accusam et justo duo dolores et ea rebum. kasd gubergren, no sea takimata sanctus</p>\r\n</td>\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#FFFFFF">\r\n<p class="text1"><span class="style25"><strong><a name="6"></a></strong></span><span class="text3">FREE DOWNLOADS<br /> <br /> <strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#">sed diam nonummy </a><br /> <strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#"> diam nonummy </a></span><br /> <span class="text3"><strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#">sed diam nonummy </a></span></p>\r\n<p class="text1"><span class="text3"><strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#">sed diam nonummy </a><br /> <strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#"> diam nonummy </a></span><br /> <span class="text3"><strong class="text3">&bull;</strong> <a class="text1" href="#">amet consectetuer </a><a class="text1" href="#">sed diam nonummy </a></span></p>\r\n</td>\r\n</tr>\r\n<tr class="brder" align="left" bgcolor="#FFFFFF">\r\n<td class="brder" colspan="2" align="left" valign="top" bgcolor="#FFFFFF"><span class="text1"><span class="text5"><strong><a name="5"></a></strong><strong class="text3">SUCCESS STORY</strong> <br /> </span><br /> At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea akimata sanctus est Lorem ipsum dolor sit amet akimata</span></td>\r\n<td class="brder" colspan="2" align="center" valign="middle" bgcolor="#D5D5D5">Advertisment</td>\r\n</tr>\r\n<tr align="center" valign="middle" bgcolor="#2F4666">\r\n<td colspan="4" bgcolor="#000000"><span class="text6">Copyright &copy; Your Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designed by <a class="text6" href="http://www.templatesbox.com" target="_blank">Templatesbox.com</a></span></td>\r\n</tr>\r\n<tr class="brder" align="center" valign="middle" bgcolor="#FFFFFF">\r\n<td colspan="4"><span class="text5">If you wish to cancel your subscription to this newsletter <a class="text1" href="#">click here</a></span></td>\r\n</tr>\r\n<tr>\r\n<td width="184" height="0">&nbsp;</td>\r\n<td width="102">&nbsp;</td>\r\n<td width="44">&nbsp;</td>\r\n<td width="191">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</center></div>', '', NULL, 'test gửi thư 2', 'gửi nữa à', 'không chào', 0, '2013-11-29 14:58:54', '2013-11-29 00:00:00', 0, ',7,');

-- --------------------------------------------------------

--
-- Table structure for table `storedemail`
--

CREATE TABLE IF NOT EXISTS `storedemail` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailUser` varchar(100) NOT NULL,
  `StoredEmail` varchar(100) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `Note` text,
  `Domain` varchar(50) NOT NULL,
  `Deleted` tinyint(1) DEFAULT NULL,
  `Disconnected` tinyint(4) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `storedemail`
--

INSERT INTO `storedemail` (`ID`, `FullName`, `EmailUser`, `StoredEmail`, `CreatedDate`, `UpdatedDate`, `Status`, `Note`, `Domain`, `Deleted`, `Disconnected`, `CategoryID`) VALUES
(1, 'Nguyễn Văn A', 'nienn@gmail.com', 'email@email.com', '2013-10-25 10:30:11', '2013-11-03 16:13:30', 1, 'ok', 'email.com', 1, NULL, 3),
(2, 'Lê Văn Chín', 'nienn@gmail.com', 'email@email.com.vn', '2013-10-25 10:55:45', '2013-11-03 16:13:30', 0, 'chào quý vị và các bạn nha s', 'email.com.vn', 1, NULL, 1),
(3, NULL, 'nienn@gmail.com', 'minhhai@gmail.com', '2013-10-27 00:07:54', '2013-10-27 18:41:09', 1, 'ok', 'gmail.com', 1, NULL, NULL),
(4, NULL, 'nienn@gmail.com', 'email1@email.com', '2013-10-27 00:20:11', '2013-11-16 11:53:54', 1, 'hello', 'email.com', NULL, NULL, NULL),
(5, '', 'nienn@gmail.com', 'dark-temnota1991@mail.ru', '2013-10-27 00:22:08', '2013-11-14 21:51:26', 0, '', 'mail.ru', 1, NULL, 4),
(6, '', 'nienn@gmail.com', 'phamminhhai@gmail.com', '2013-10-27 11:48:54', '2013-11-14 21:51:26', 1, '', 'gmail.com', 1, NULL, 4),
(7, '', 'nienn@gmail.com', 'hung@gmail.com', '2013-10-27 11:48:54', '2013-11-16 11:09:54', 0, '', 'gmail.com', 0, NULL, 4),
(8, '', 'nienn@gmail.com', 'hung123@yahoo.com', '2013-10-27 11:48:54', '2013-11-03 16:53:20', 1, '', 'yahoo.com', 0, NULL, 4),
(9, '', 'nienn@gmail.com', 'vnyahoo@yahoo.com', '2013-10-27 11:48:54', '2013-11-03 16:53:21', 1, '', 'yahoo.com', NULL, NULL, 4),
(10, '', 'nienn@gmail.com', 'thanhnien@hotmail.com', '2013-10-27 11:48:54', '2013-11-03 16:53:21', 1, '', 'hotmail.com', NULL, NULL, 4),
(11, '', 'nienn@gmail.com', 'liberty042@mail.ru', '2013-10-27 11:48:54', '2013-11-03 16:53:21', 0, '', 'mail.ru', NULL, NULL, 4),
(12, NULL, 'nienn@gmail.com', 'email@email.com.rt', '2013-10-27 13:26:02', '2013-11-03 16:47:36', 0, '', 'email.com.rt', NULL, NULL, NULL),
(13, NULL, 'nienn@gmail.com', 'vnn@vn.com', '2013-10-27 22:17:30', '2013-10-30 10:45:38', -1, '', 'vn.com', NULL, NULL, NULL),
(14, NULL, 'nienn@gmail.com', 'vnn@vn.com1', '2013-10-30 10:55:36', '2013-10-30 16:36:40', -1, 'thay đổi', 'vn.com1', 1, NULL, NULL),
(15, '', 'nienn@gmail.com', 'minhhai@gmail.com', '2013-10-30 15:48:56', '2013-11-03 16:53:20', -1, '', 'gmail.com', NULL, NULL, 4),
(16, NULL, 'nienn@gmail.com', 'phamminh@gmail.com', '2013-10-30 15:48:56', '2013-10-30 15:48:56', -1, '', 'gmail.com', NULL, NULL, 2),
(17, '', 'nienn@gmail.com', 'meff_dont_stay@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(18, '', 'nienn@gmail.com', 'japaneseeyes@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(19, '', 'nienn@gmail.com', 'chebr007@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(20, '', 'nienn@gmail.com', 'golowcko@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(21, '', 'nienn@gmail.com', 'vk20106@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(22, '', 'nienn@gmail.com', 'karina.ovechkina@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(23, '', 'nienn@gmail.com', 'chestny.syn@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(24, '', 'nienn@gmail.com', 'bayan_v@mail.ru', '2013-11-03 16:53:21', '2013-11-03 16:53:21', -1, '', 'mail.ru', NULL, NULL, 4),
(25, '', 'nienn@gmail.com', 'bespridelschic@mail.ru', '2013-11-03 16:53:21', '2013-11-04 21:21:35', 0, '', 'mail.ru', NULL, NULL, 4),
(26, '', 'nienn@gmail.com', 'elmaribrahimli@mail.ru', '2013-11-03 16:53:22', '2013-11-04 21:19:56', 0, '', 'mail.ru', NULL, NULL, 4),
(27, '', 'nienn@gmail.com', 'alexxl96_96-98@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(28, '', 'nienn@gmail.com', 'abok_respect@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(29, '', 'nienn@gmail.com', 'sofi_sh.85@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(30, '', 'nienn@gmail.com', 'sasha253895@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(31, '', 'nienn@gmail.com', 'mister-proper_95@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(32, '', 'nienn@gmail.com', 'chinaiski@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(33, '', 'nienn@gmail.com', 'balyasnikov94@inbox.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'inbox.ru', NULL, NULL, 4),
(34, '', 'nienn@gmail.com', '777ewgeniya777@mail.ru', '2013-11-03 16:53:22', '2013-11-03 17:08:53', 0, '', 'mail.ru', NULL, NULL, 4),
(35, '', 'nienn@gmail.com', 'wada999@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(36, '', 'nienn@gmail.com', 'rukzakov2@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(37, '', 'nienn@gmail.com', 'vip.borisych@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(38, '', 'nienn@gmail.com', 'javiersuarez@mail.ru', '2013-11-03 16:53:22', '2013-11-03 16:53:22', -1, '', 'mail.ru', NULL, NULL, 4),
(39, '', 'nienn@gmail.com', 'mandola2@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(40, '', 'nienn@gmail.com', 'vladas67@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(41, '', 'nienn@gmail.com', 's1jukov@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(42, '', 'nienn@gmail.com', 'muravei-09@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(43, '', 'nienn@gmail.com', 'hrukinatanya@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(44, '', 'nienn@gmail.com', 'egater@inbox.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'inbox.ru', NULL, NULL, 4),
(45, '', 'nienn@gmail.com', 'bednyystudent@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(46, '', 'nienn@gmail.com', 'rusakov_misha@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(47, '', 'nienn@gmail.com', 'vladimerh@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(48, '', 'nienn@gmail.com', 'crazy-anka08@mail.ru', '2013-11-03 16:53:23', '2013-11-03 16:53:23', -1, '', 'mail.ru', NULL, NULL, 4),
(49, 'Nguyễn Văn A', 'nienn@gmail.com', 'vnn@vn.com.vn', '2013-11-20 21:57:44', '2013-11-20 21:57:44', -1, '', 'vn.com.vn', NULL, NULL, NULL),
(50, 'hung', 'nienn@gmail.com', 'thanhhung1012@gmail.com', '2013-11-26 20:55:37', '2013-11-26 20:55:37', -1, '', 'gmail.com', NULL, NULL, 7),
(51, 'hung 2', 'nienn@gmail.com', 'hfwtest01@gmail.com', '2013-11-26 20:56:16', '2013-11-26 20:56:16', -1, '', 'gmail.com', NULL, NULL, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
