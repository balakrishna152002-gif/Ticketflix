-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2023 at 08:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketflix`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `theater_name` varchar(255) DEFAULT NULL,
  `showtime` varchar(50) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `card_holder_name` varchar(255) DEFAULT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `expiry_month` varchar(2) DEFAULT NULL,
  `expiry_year` varchar(4) DEFAULT NULL,
  `cvv` varchar(300) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `selected_seats` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `movie_id`, `theater_name`, `showtime`, `date`, `card_holder_name`, `card_number`, `expiry_month`, `expiry_year`, `cvv`, `email`, `selected_seats`, `timestamp`) VALUES
(3, 9, 'Arjun Movies', '13:30', '2023-07-21', 'example', '25f9e794323b453885f5181f1b624d0b', '01', '2024', '202cb962ac59075b964b07152d234b70', 'arjunprakash@gmail.com', 'A10', '2023-07-19 12:50:53'),
(4, 7, 'Pan Cinemas', '11:30', '2023-07-21', 'example', '25f9e794323b453885f5181f1b624d0b', '01', '2024', '202cb962ac59075b964b07152d234b70', 'arjunprakash@gmail.com', 'B8', '2023-07-19 14:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `card_number` varchar(300) NOT NULL,
  `expiry_month` int(11) NOT NULL,
  `expiry_year` int(11) NOT NULL,
  `cvv` varchar(300) NOT NULL,
  `card_holder_name` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `card_number`, `expiry_month`, `expiry_year`, `cvv`, `card_holder_name`, `balance`) VALUES
(1, '25f9e794323b453885f5181f1b624d0b', 1, 2024, '202cb962ac59075b964b07152d234b70', 'example', 9000.00);

-- --------------------------------------------------------

--
-- Table structure for table `current`
--

CREATE TABLE `current` (
  `c_id` int(11) NOT NULL,
  `mid` int(30) NOT NULL,
  `tid` int(30) NOT NULL,
  `screen` int(30) NOT NULL,
  `trelease` varchar(50) NOT NULL,
  `morning` int(10) NOT NULL,
  `noon` int(10) NOT NULL,
  `first` int(10) NOT NULL,
  `seccond` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `current`
--

INSERT INTO `current` (`c_id`, `mid`, `tid`, `screen`, `trelease`, `morning`, `noon`, `first`, `seccond`) VALUES
(174, 7, 6, 1, '', 1, 1, 1, 1),
(175, 8, 6, 2, '', 1, 1, 1, 1),
(176, 7, 2, 2, '', 1, 0, 1, 0),
(177, 9, 2, 1, '', 1, 1, 1, 1),
(178, 7, 5, 1, '', 1, 1, 1, 1),
(179, 8, 5, 2, '', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `m_id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `language` varchar(30) NOT NULL,
  `duration_h` varchar(30) NOT NULL,
  `duration_m` varchar(30) NOT NULL,
  `censor_rating` varchar(30) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `coming_soon` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`m_id`, `name`, `language`, `duration_h`, `duration_m`, `censor_rating`, `fname`, `coming_soon`) VALUES
(7, '2018', 'malayalam', '2', '51', 'U/A', '2018.jpg', 0),
(8, 'Malaikottai Valiban', 'Malayalam', '3', '15', 'U/A', 'malaikotta.jpg', 0),
(9, 'John Wick', 'English', '3', '35', 'A', 'john.jpg', 0),
(10, 'Neymar', 'Malayalam', '2', '30', 'U/A', 'neymar.jpg', 0),
(15, 'Mission Impossible', '', '', '', '', '', 1),
(16, 'Open Heimer', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `theatre`
--

CREATE TABLE `theatre` (
  `tid` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tname` varchar(30) NOT NULL,
  `tcity` varchar(30) NOT NULL,
  `tlocation` varchar(30) NOT NULL,
  `screens` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theatre`
--

INSERT INTO `theatre` (`tid`, `email`, `tname`, `tcity`, `tlocation`, `screens`) VALUES
(2, 'arjun@gmail.com', 'Arjun Movies', 'pathanamthitta', 'kadamattam', 2),
(5, 'paru@gmail.com', 'P Movies', 'Pala', 'Pala', 2),
(6, 'pan@gmail.com', 'Pan Cinemas', 'Alappuzha', 'Alappuzha', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `type` varchar(2) NOT NULL,
  `tname` varchar(50) NOT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `fname`, `lname`, `phone`, `email`, `password`, `type`, `tname`, `location`) VALUES
(1, 'admin', '', '', 'admin@gmail.com', 'e19d5cd5af0378da05f63f891c7467af', '1', '', '0'),
(29, 'bk', '', '8848737794', 'arjun@gmail.com', '325a2cc052914ceeb8c19016c091d2ac', '2', '', '0'),
(30, 'Parvathy', 'Suryan', '6282489436', 'paru@gmail.com', '77a1abbce7cf234045b1e89ad622b148', '2', '', '0'),
(31, 'arjun', '', '9874563210', 'arjunprakash@gmail.com', '325a2cc052914ceeb8c19016c091d2ac', '3', '', ''),
(32, 'jeena', '', '9874563210', 'jeena@gmail.com', '274efe9fab0b00b7c75b551f2f8f0c13', '3', '', ''),
(33, 'Balu', '', '8848737794', 'balu@gmail.com', '325a2cc052914ceeb8c19016c091d2ac', '3', '', ''),
(34, 'Pan', '', '8745547879', 'pan@gmail.com', '325a2cc052914ceeb8c19016c091d2ac', '2', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_ibfk_1` (`movie_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current`
--
ALTER TABLE `current`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `tid` (`tid`),
  ADD KEY `mid` (`mid`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `theatre`
--
ALTER TABLE `theatre`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `current`
--
ALTER TABLE `current`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `m_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `theatre`
--
ALTER TABLE `theatre`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`m_id`) ON DELETE SET NULL;

--
-- Constraints for table `current`
--
ALTER TABLE `current`
  ADD CONSTRAINT `current_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `theatre` (`tid`),
  ADD CONSTRAINT `current_ibfk_2` FOREIGN KEY (`mid`) REFERENCES `movies` (`m_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
