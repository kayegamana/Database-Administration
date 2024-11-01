-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 11:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `addressID` int(10) NOT NULL,
  `userInfoID` int(10) NOT NULL,
  `cityID` int(10) NOT NULL,
  `provinceID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`addressID`, `userInfoID`, `cityID`, `provinceID`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3),
(4, 4, 4, 2),
(5, 5, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `cityID` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`cityID`, `name`) VALUES
(1, 'Bay'),
(2, 'Sto. Tomas'),
(3, 'San Fernando'),
(4, 'Lemery'),
(5, 'Manila'),
(6, 'Calamba'),
(7, 'San Jose del Monte');

-- --------------------------------------------------------

--
-- Table structure for table `closefriends`
--

CREATE TABLE `closefriends` (
  `closeFriendID` int(10) NOT NULL,
  `ownerID` int(10) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(10) NOT NULL,
  `dateTime` varchar(50) NOT NULL,
  `content` varchar(250) NOT NULL,
  `userID` int(10) NOT NULL,
  `postID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friendID` int(10) NOT NULL,
  `requesterID` int(10) NOT NULL,
  `requesteeID` int(10) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gcmembers`
--

CREATE TABLE `gcmembers` (
  `gcMemberID` int(10) NOT NULL,
  `groupChatID` int(10) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupchats`
--

CREATE TABLE `groupchats` (
  `groupChatID` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(50) NOT NULL,
  `theme` varchar(50) NOT NULL,
  `adminID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message` varchar(250) NOT NULL,
  `senderID` int(10) NOT NULL,
  `receiverID` int(10) NOT NULL,
  `dateTime` varchar(50) NOT NULL,
  `isRead` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `attachment` varchar(50) NOT NULL,
  `groupChatID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `content` varchar(250) NOT NULL,
  `dateTime` varchar(50) NOT NULL,
  `privacy` varchar(50) NOT NULL,
  `isDeleted` varchar(50) NOT NULL,
  `attachment` varchar(250) NOT NULL,
  `cityID` int(10) NOT NULL,
  `provinceID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `userID`, `content`, `dateTime`, `privacy`, `isDeleted`, `attachment`, `cityID`, `provinceID`) VALUES
(1, 1, 'Hello World! This is my new post. My name is Christine Panganiban, and I am from Bay, Laguna.', '6:56 am 26/10/2024', 'Public', 'No', '', 1, 1),
(2, 2, 'ello prendsss :>>> Sino G mag ML later? Gustong-gusto ko nang maglaro at makasama kayo :(', '7:45 am 26/10/2024', 'Friends', 'No', '', 2, 2),
(3, 3, 'Another day, another adventure. Feeling inspired and grateful for all the love and support. Can’t wait to share what I’ve been working on. Stay tuned, blinks!', '8:07 am 26/10/2024', 'Public', 'No', '', 1, 1),
(4, 4, 'Hey, Blooms! Remember to shine bright, even on cloudy days. Your unique sparkle matters! What made you smile today? Let\'s spread some good vibes together! #BloomingTogether #BINI', '6:26 pm 26/10/2024', 'Public', 'No', '', 5, 4),
(5, 3, 'BLINKSSSS!!! Guess where I am? I’m in beautiful Calamba, Laguna! Loving the vibes and soaking in the amazing scenery. Can’t wait to explore more! What’s your favorite spot here?  #Calamba #JennieInLaguna', '8:35 pm 26/10/2024', 'Public', 'No', '', 6, 1),
(6, 5, 'What’s up, Lilies?! Just a little reminder to chase your dreams and never stop believing in yourself. Every step counts! What’s one goal you’re working on this week? Let’s inspire each other! #StayMotivated #LALISA\r\n', '9:41 pm 26/10/2024', 'Public', 'No', '', 5, 4),
(7, 1, 'Missing my amazing friends today! The laughter, the inside jokes, and all the little moments we share. Can\'t wait to make more memories together soon pls pls plssssss!!!!', '10:21 pm 26/10/2024', 'Private', 'No', '', 2, 2),
(8, 2, 'Yo, friends! Movie night, anyone? I’m in the mood for something thrilling or maybe a good comedy! Any recossss?', '3:35 pm 27/10/2024', 'Friends', 'No', '', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `provinceID` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`provinceID`, `name`) VALUES
(1, 'Laguna'),
(2, 'Batangas'),
(3, 'Pampanga'),
(4, 'Metro Manila'),
(5, 'Bulacan');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `reactionID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `postID` int(10) NOT NULL,
  `kind` varchar(50) NOT NULL,
  `commentID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `userInfoID` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `birthDay` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`userInfoID`, `firstName`, `lastName`, `birthDay`) VALUES
(1, 'Christine', 'Panganiban', '2004-05-21'),
(2, 'Christian', 'Park', '2004-06-21'),
(3, 'Jennie Ruby Jane', 'Kim', '1996-01-16'),
(4, 'Mary Loi Yves', 'Ricalde', '2002-05-27'),
(5, 'Pranpriya', 'Manobal', '1997-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(10) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userInfoID` int(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `willRemember` varchar(50) NOT NULL,
  `isOnline` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userInfoID`, `password`, `email`, `phoneNumber`, `willRemember`, `isOnline`) VALUES
(1, 'Tintin21', 1, 'Christinepassword', 'Christine@gmail.com', '09123456789', 'Yes', 'Yes'),
(2, 'Chris2024', 2, 'Chris2password', 'MyEmailChris2024@gmail.com', '09223456789', 'Yes', 'Yes'),
(3, 'Ruby96JANEEEE', 3, 'Jendeuk1996NINI', 'jennierubyjane@gmail.com', '09333456789', 'Yes', 'No'),
(4, 'iolaMaloibiniBINI8', 4, 'biniMAMALOILOI8', 'binimaloiricalde@gmail.com', '09444456789', 'Yes', 'Yes'),
(5, 'lalalalisa_manoban', 5, 'blackpinkLALISA9700', 'lalisaBPmanoban@gmail.com', '09555556789', 'Yes', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`addressID`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`cityID`);

--
-- Indexes for table `closefriends`
--
ALTER TABLE `closefriends`
  ADD PRIMARY KEY (`closeFriendID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friendID`);

--
-- Indexes for table `gcmembers`
--
ALTER TABLE `gcmembers`
  ADD PRIMARY KEY (`gcMemberID`);

--
-- Indexes for table `groupchats`
--
ALTER TABLE `groupchats`
  ADD PRIMARY KEY (`groupChatID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`provinceID`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`reactionID`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`userInfoID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `addressID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `cityID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `closefriends`
--
ALTER TABLE `closefriends`
  MODIFY `closeFriendID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friendID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gcmembers`
--
ALTER TABLE `gcmembers`
  MODIFY `gcMemberID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groupchats`
--
ALTER TABLE `groupchats`
  MODIFY `groupChatID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `provinceID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `reactionID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `userInfoID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
