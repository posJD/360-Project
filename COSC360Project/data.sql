-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2024 at 09:58 PM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_86043593`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE IF NOT EXISTS `Admin` (
  `AdminId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `UniqueId` varchar(50) NOT NULL,
  `Permissions` varchar(255) DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`AdminId`, `Name`, `UniqueId`, `Permissions`, `Username`, `Password`) VALUES
(1, 'Admin ', '1', 'all', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `CommentId` int(11) NOT NULL,
  `ThreadId` int(11) DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `Content` text NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`CommentId`, `ThreadId`, `Username`, `Content`, `Time`) VALUES
(1, 1, 'prithvi', 'thanks for the programming advice!', '2024-03-20 22:18:33'),
(2, 1, 'sina', 'The insight on food travel sounds cool!', '2024-03-20 22:18:43'),
(3, 5, 'sinkid8', 'Very Nice', '2024-03-27 11:15:50'),
(4, 5, 'sinkid8', 'kk', '2024-03-27 11:25:31'),
(5, 7, 'prithvi', 'wow thanks!', '2024-03-27 21:49:06');

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE IF NOT EXISTS `Images` (
  `ImageId` int(11) NOT NULL,
  `ImgFile` blob NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Images`
--


--
-- Table structure for table `Tags`
--

CREATE TABLE IF NOT EXISTS `Tags` (
  `TagId` int(11) NOT NULL,
  `TagName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Threads`
--

CREATE TABLE IF NOT EXISTS `Threads` (
  `ThreadId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `UserId` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ImageId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Threads`
--

INSERT INTO `Threads` (`ThreadId`, `Title`, `Content`, `UserId`, `Time`, `ImageId`) VALUES
(4, 'ded', 'a es, am, cma ncm', 3, '2024-03-27 11:10:49', NULL),
(5, 'Dogs Adopted', 'Just Adopted a new dog. So excited!!!', 3, '2024-03-27 11:15:38', NULL),
(6, 'Dogs Adopted', 'Adopted a new dog!!', 3, '2024-03-27 11:30:46', 4),
(7, 'food travels', 'Food travels encompass the exploration of culinary traditions, flavors, and ingredients across different cultures and regions. ', 4, '2024-03-27 21:44:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ThreadTag`
--

CREATE TABLE IF NOT EXISTS `ThreadTag` (
  `ThreadTagId` int(11) NOT NULL,
  `ThreadId` int(11) NOT NULL,
  `TagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `UserId` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `ImageId` int(11) DEFAULT NULL,
  `Bio` text
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `Name`, `Email`, `Username`, `Password`, `DOB`, `ImageId`, `Bio`) VALUES
(3, 'sina', 'Sinaha8@yahoo.ca', 'sinkid8', '$2y$10$L612J7NoKHH2C.4o/9IBvuHPBOvT4shj3zhQbwcjVPPW5g.fGtBL.', '2024-03-05', NULL, 'Hi Im sina. Im fourth Year UBCO student.'),
(4, 'prithvi waraich', 'prithvi@gmail.com', 'prithvi', '$2y$10$.18XfoyvJoA/jxlog8NsZOXnaeysaLp49Yf3z0nTcBvSoLVDdrJtq', '2002-02-18', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`AdminId`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`CommentId`);

--
-- Indexes for table `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`ImageId`),
  ADD KEY `fk_Images_UserId` (`UserId`);

--
-- Indexes for table `Tags`
--
ALTER TABLE `Tags`
  ADD PRIMARY KEY (`TagId`),
  ADD UNIQUE KEY `TagName` (`TagName`);

--
-- Indexes for table `Threads`
--
ALTER TABLE `Threads`
  ADD PRIMARY KEY (`ThreadId`),
  ADD UNIQUE KEY `ThreadId` (`ThreadId`),
  ADD KEY `fk_Threads_UserId` (`UserId`),
  ADD KEY `fk_Threads_ImageId` (`ImageId`);

--
-- Indexes for table `ThreadTag`
--
ALTER TABLE `ThreadTag`
  ADD PRIMARY KEY (`ThreadTagId`),
  ADD KEY `ThreadId` (`ThreadId`),
  ADD KEY `TagId` (`TagId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `idx_UserId` (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `CommentId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Images`
--
ALTER TABLE `Images`
  MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Tags`
--
ALTER TABLE `Tags`
  MODIFY `TagId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Threads`
--
ALTER TABLE `Threads`
  MODIFY `ThreadId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ThreadTag`
--
ALTER TABLE `ThreadTag`
  MODIFY `ThreadTagId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Images`
--
ALTER TABLE `Images`
  ADD CONSTRAINT `fk_Images_UserId` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`);

--
-- Constraints for table `Threads`
--
ALTER TABLE `Threads`
  ADD CONSTRAINT `fk_Threads_ImageId` FOREIGN KEY (`ImageId`) REFERENCES `Images` (`ImageId`),
  ADD CONSTRAINT `fk_Threads_UserId` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`),
  ADD CONSTRAINT `Threads_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`);

--
-- Constraints for table `ThreadTag`
--
ALTER TABLE `ThreadTag`
  ADD CONSTRAINT `ThreadTag_ibfk_1` FOREIGN KEY (`ThreadId`) REFERENCES `Threads` (`ThreadId`) ON DELETE CASCADE,
  ADD CONSTRAINT `ThreadTag_ibfk_2` FOREIGN KEY (`TagId`) REFERENCES `Tags` (`TagId`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
