-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2023 at 06:28 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--
CREATE DATABASE IF NOT EXISTS `hotel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hotel`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `room_no` int(255) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date DEFAULT NULL,
  `adults_num` int(11) NOT NULL,
  `children_num` int(11) NOT NULL,
  `clear_bill` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `type`, `customer_email`, `room_no`, `check_in`, `check_out`, `adults_num`, `children_num`, `clear_bill`) VALUES
(1, '', 'admin@gmail.com', 2, '2021-08-10', '2021-09-09', 2, 0, 0),
(2, '', 'admin@gmail.com', 3, '2021-08-28', '2021-09-02', 2, 0, 0),
(3, '', 'admin@gmail.com', 1, '2021-08-04', '2021-09-02', 2, 0, 0),
(4, '', 'admin@gmail.com', 4, '2021-08-20', '2021-09-02', 2, 0, 1),
(5, '', 'abc@gmail.com', 3, '2021-08-10', '2021-10-29', 2, 0, 1),
(6, '', 'admin@gmail.com', 2, '2021-08-10', '2021-08-29', 2, 0, 0),
(7, '', 'abc@gmail.com', 4, '2021-08-23', '2021-08-29', 1, 0, 0),
(8, '', 'james@gmail.com', 2, '2021-08-11', '2021-08-29', 2, 0, 1),
(9, '', 'james@gmail.com', 2, '2021-08-03', '2021-08-29', 2, 0, 0),
(10, '', 'james@gmail.com', 3, '2021-08-04', '2021-08-29', 2, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `type`, `price`, `description`, `image`) VALUES
(1, 'Standard', 600, 'TV, Free Wifi', 'standard.jpg'),
(2, 'Deluxe', 1000, 'Breakfast, TV, Wifi, Massage', 'deluxe.jpg'),
(3, 'Super Deluxe', 1500, 'City View, Deluxe Features, Dinner', 'super-deluxe.jpg'),
(4, 'Luxury', 2000, 'Super Deluxe + Cool Breeze and Paradise View, Dance Party', 'luxury.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'customer'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `email`, `password`, `role`) VALUES
(1, 'Admin', '', 'admin@gmail.com', '$2y$10$eIUI0tDGqwqqUIJsH2neFeqd9yG.FoqUw/xC7xHGzpzZGtYHibNh6', 'admin'),
(2, 'abc', '', 'abc@gmail.com', '$2y$10$FC0/NMjY/5iMScZlQZ2theAJ5.ABvqlqCYx5Z2HVjVlplxiB28UG6', 'customer'),
(3, 'james', '', 'james@gmail.com', '$2y$10$FZSHyjgKe7812XJHMGcY3OdWGeTGW0n04VFKxAlPjwm2cHDnIdYFi', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_room_no` (`room_no`) USING BTREE;

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
