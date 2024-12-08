-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Dec 08, 2024 at 07:23 PM
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
-- Database: `room_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogs`
--

CREATE TABLE `adminlogs` (
  `log_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `action_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminlogs`
--

INSERT INTO `adminlogs` (`log_id`, `admin_id`, `action`, `action_timestamp`, `details`) VALUES
(1, 1, 'Added new room: Room 101', '2024-11-25 00:00:00', NULL),
(2, 1, 'Booked Room 102 for user 2', '2024-11-26 00:00:00', NULL),
(3, 1, 'Deleted booking for Room 103', '2024-11-27 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `booking_date`, `time_slot`, `status`) VALUES
(6, 1, 1, '2024-11-26', '09:00-11:00', 'Confirmed'),
(7, 2, 2, '2024-11-26', '11:00-13:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `room_id`, `comment_text`, `created_at`) VALUES
(1, 1, 1, 'Great room for lectures, everything works fine.', '2024-11-25 00:00:00'),
(2, 2, 2, 'The projector is a bit outdated, but the room is good.', '2024-11-26 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_type` enum('Lecture','Lab') NOT NULL,
  `building` varchar(100) NOT NULL,
  `floor` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `image5` varchar(255) DEFAULT NULL,
  `availability_status` enum('Available','Booked') NOT NULL DEFAULT 'Available',
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `room_type`, `building`, `floor`, `department`, `capacity`, `image1`, `image2`, `image3`, `image4`, `image5`, `availability_status`, `description`) VALUES
(1, 'Room 021', 'Lab', 'IT', 0, 'IS', 45, 'room.jpeg', 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(2, 'Room 1006', 'Lab', 'IT', 1, 'IS', 50, 'room.jpeg', 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(3, 'Room 2005', 'Lab', 'IT', 2, 'IS', 50, 'room.jpeg', 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(4, 'Room 032', 'Lecture', 'IT', 0, 'IS', 30, 'room.jpeg', 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(5, 'Room 2008', 'Lecture', 'IT', 2, 'IS', 32, 'room.jpeg', 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(6, 'Room 051', 'Lab', 'IT', 0, 'CS', 45, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(7, 'Room 1049', 'Lab', 'IT', 1, 'CS', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(8, 'Room 2050', 'Lab', 'IT', 2, 'CS', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(9, 'Room 049', 'Lecture', 'IT', 0, 'CS', 30, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(10, 'Room 1047', 'Lecture', 'IT', 1, 'CS', 55, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(11, 'Room 079', 'Lab', 'IT', 0, 'CE', 45, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(12, 'Room 1081', 'Lab', 'IT', 1, 'CE', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(13, 'Room 2091', 'Lab', 'IT', 2, 'CE', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(14, 'Room 085', 'Lecture', 'IT', 0, 'CE', 30, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(15, 'Room 1086', 'Lecture', 'IT', 1, 'CE', 55, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('Admin','User') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`) VALUES
(1, 'Admin User', 'admin@example.com', 'hashedpassword', 'Admin'),
(2, 'Regular User', 'user@example.com', 'hashedpassword', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogs`
--
ALTER TABLE `adminlogs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_name` (`room_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminlogs`
--
ALTER TABLE `adminlogs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminlogs`
--
ALTER TABLE `adminlogs`
  ADD CONSTRAINT `adminlogs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
