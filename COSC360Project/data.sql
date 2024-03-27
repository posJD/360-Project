-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2024 at 11:05 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`CommentId`, `ThreadId`, `Username`, `Content`, `Time`) VALUES
(1, 1, 'prithvi', 'thanks for the programming advice!', '2024-03-20 22:18:33'),
(2, 1, 'sina', 'The insight on food travel sounds cool!', '2024-03-20 22:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE IF NOT EXISTS `Images` (
  `ImageId` int(11) NOT NULL,
  `ImgFile` blob NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Threads`
--

CREATE TABLE IF NOT EXISTS `Threads` (
  `ThreadId` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Tags` varchar(255) DEFAULT NULL,
  `Content` text NOT NULL,
  `UserId` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ImageId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `Name`, `Email`, `Username`, `Password`, `DOB`, `ImageId`, `Bio`) VALUES
(1, 'Prithvi', 'prithviwaraich@gmail.com', 'prithvi', 'password123', '2002-02-18', 1, NULL),
(2, 'Sina', 'sina@gmail.com', 'sina', 'password1234', '2002-02-18', 2, 'Hey Im a Fourth Year Comp Sci Student at the University of British Columbia. I like games, computer and basketball.'),
(3, 'Sina', 'SJnana@yahoo.ca', 'sinkid8', '$2y$10$L612J7NoKHH2C.4o/9IBvuHPBOvT4shj3zhQbwcjVPPW5g.fGtBL.', '2024-03-12', NULL, 'Yeeeeeoooooo');

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
-- Indexes for table `Threads`
--
ALTER TABLE `Threads`
  ADD PRIMARY KEY (`ThreadId`),
  ADD UNIQUE KEY `ThreadId` (`ThreadId`),
  ADD KEY `fk_Threads_UserId` (`UserId`),
  ADD KEY `fk_Threads_ImageId` (`ImageId`);

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
  MODIFY `CommentId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Images`
--
ALTER TABLE `Images`
  MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Threads`
--
ALTER TABLE `Threads`
  MODIFY `ThreadId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
  ADD CONSTRAINT `fk_Threads_UserId` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`),
  ADD CONSTRAINT `fk_Threads_ImageId` FOREIGN KEY (`ImageId`) REFERENCES `Images` (`ImageId`),
  ADD CONSTRAINT `Threads_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
