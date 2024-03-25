-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2024 at 12:50 AM
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
  `Username` varchar(50) NOT NULL,
  `ImgFile` blob NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Images`
--

INSERT INTO `Images` (`ImageId`, `Username`, `ImgFile`) VALUES
(1, 'prithvi', 0x64617461),
(2, 'sina', 0x64617461),
(3, 'programming', 0x64617461);

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

--
-- Dumping data for table `Threads`
--

INSERT INTO `Threads` (`ThreadId`, `Title`, `Tags`, `Content`, `UserId`, `Time`, `ImageId`) VALUES
(1, 'Programming Like a Pro', 'programming', 'Programming at a professional level involves crafting efficient, maintainable code to solve complex problems. It requires a deep understanding of both the language and the problem domain, as well as a commitment to best practices and continuous learning.', 1, '2024-03-20 22:17:04', 3),
(2, 'Food Travels', 'food', ' Food travels at a professional level go beyond mere indulgence—they are a celebration of diversity, a bridge between cultures, and a testament to the universal language of taste that unites us all. ', 1, '2024-03-20 22:17:14', 4),
(3, 'Pets Care', 'pets', 'Professional pet care is a thoughtful blend of compassion and expertise, ensuring the well-being and happiness of our furry companions. It involves nurturing relationships built on trust, providing quality nutrition, exercise, and medical attention tailored to each pet''s unique needs.', 2, '2024-03-20 22:18:19', 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `Name`, `Email`, `Username`, `Password`, `DOB`, `ImageId`, `Bio`) VALUES
(1, 'Prithvi', 'prithviwaraich@gmail.com', 'prithvi', 'password123', '2002-02-18', 1, NULL),
(2, 'Sina', 'sina@gmail.com', 'sina', 'password1234', '2002-02-18', 2, 'Hey Im a Fourth Year Comp Sci Student at the University of British Columbia. I like games, computer and basketball.');

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
  ADD PRIMARY KEY (`ImageId`);

--
-- Indexes for table `Threads`
--
ALTER TABLE `Threads`
  ADD PRIMARY KEY (`ThreadId`),
  ADD UNIQUE KEY `ThreadId` (`ThreadId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Username` (`Username`);

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
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Threads`
--
ALTER TABLE `Threads`
  ADD CONSTRAINT `Threads_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;