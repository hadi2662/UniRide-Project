-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 11:19 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uni-bus-transport`
--

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `BusID` int(11) NOT NULL,
  `BusNumber` varchar(20) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `DriverName` varchar(100) NOT NULL,
  `ContactNumber` varchar(15) DEFAULT NULL,
  `Route` varchar(255) NOT NULL,
  `Status` enum('active','inactive') DEFAULT 'active',
  `BusSchedule` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`BusID`, `BusNumber`, `Capacity`, `DriverName`, `ContactNumber`, `Route`, `Status`, `BusSchedule`) VALUES
(3, 'KKM-6713', 2, 'Hadi Abbas', '03363183501', 'Smiu To Maymar', 'active', '2025-01-12 13:00:00'),
(4, 'KOV-9974', 2, 'Abbas', '03363183501', 'SIMU - Hadeed', 'active', '2025-01-12 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `TicketId` int(11) NOT NULL,
  `TicketNumber` varchar(100) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `BusID` int(11) NOT NULL,
  `receipt_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`TicketId`, `TicketNumber`, `Price`, `username`, `BusID`, `receipt_path`) VALUES
(32, 'TICKET-6772695765258', '10.00', 'hussain', 4, 'receipts/receipt_TICKET-6772695765258.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `UniId` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','faculty') DEFAULT 'student',
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `Address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `UniId`, `username`, `password`, `role`, `email`, `contact_number`, `Address`) VALUES
(4, 'CSC-23S-206', 'hadi', '48bf82c7492876f686fda9690614d4f5', 'admin', 'abbashadi824@gmail.com', '03363183501', 'Nazimabad #1'),
(7, 'CSC-23S-207', 'ana', 'a70f9e38ff015afaa9ab0aacabee2e13', 'admin', 'anna@gmail.com', '03310211555', 'Maripur'),
(8, 'CSC-23S-211', 'student', '5975c755734ec9fce047b36e2a0fe264', 'student', 'student@gmail.com', '0325211251002', 'Numaish'),
(15, 'CSC-23S-205', 'hussain', '76671d4b83f6e6f953ea2dfb75ded921', 'student', 'hussain@gmail.com', '0325211251002', 'linesarea');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`BusID`),
  ADD UNIQUE KEY `BusNumber` (`BusNumber`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TicketId`),
  ADD KEY `username` (`username`),
  ADD KEY `BusID` (`BusID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `UniId` (`UniId`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `username_3` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `BusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `TicketId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`BusID`) REFERENCES `buses` (`BusID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
