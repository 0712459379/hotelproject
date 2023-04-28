-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2021 at 04:23 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `foodorders`
--

CREATE TABLE `foodorders` (
  `id` int(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel_no` int(30) NOT NULL,
  `date` datetime NOT NULL,
  `order_total` decimal(9,2) NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foodorders`
--

INSERT INTO `foodorders` (`id`, `email`, `tel_no`, `date`, `order_total`, `order_status`) VALUES
(1, 'customer@customer.com', 46372, '2021-03-20 00:00:00', '334.00', 'deleted'),
(2, 'user@user.user', 3763876, '2021-03-22 00:00:00', '1070.00', 'active'),
(3, 'c@c.c', 4323, '2021-03-25 00:00:00', '1106.00', 'active'),
(4, 'c@c.c', 4323, '2021-03-25 00:00:00', '1030.00', 'active'),
(5, 'c@c.c', 4323, '2021-03-25 00:00:00', '1533.00', 'active'),
(6, 'c@c.c', 4323, '2021-03-25 00:00:00', '1110.00', 'active'),
(7, 'c@c.c', 4323, '2021-03-25 00:00:00', '776253.00', 'active'),
(8, 'c@c.c', 4323, '2021-03-26 00:00:00', '530.00', 'active'),
(9, 'c@c.c', 4323, '2021-03-26 00:00:00', '30.00', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `food_name` varchar(128) NOT NULL,
  `food_category` varchar(128) NOT NULL,
  `food_image` varchar(128) NOT NULL,
  `food_description` varchar(128) NOT NULL,
  `food_price` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `food_name`, `food_category`, `food_image`, `food_description`, `food_price`) VALUES
(2, 'Ugali', 'breakfast', 'Ugali.jpeg', 'The staple food of kenya', '30'),
(3, 'chapo', 'lunch', 'chapo.jpg', 'chapo beans', '34'),
(4, 'kuku', 'dinner', 'kuku.jpg', 'eeeeeeeeeeeeeeeeeeeeeeeeeeeee', '76'),
(5, 'nyake', 'snacks', 'nyake.jpg', 'kali', '31'),
(6, 'rewq', 'supper', 'rewq.jpg', 'rqrrrrrrdfffdddddd', '54'),
(15, 'chapo', 'supper', 'chapo.jpg', 'chapo beans', '50'),
(16, 'Ugali', 'breakfast', 'Ugali.jpeg', 'The staple food of kenya', '50'),
(17, 'mchele', 'dinner', 'mchele.jpeg', 'jhsfifwui', '60'),
(18, 'mchele', 'breakfast', 'mchele.jpeg', 'hii ni mchele bana', '999');

-- --------------------------------------------------------

--
-- Table structure for table `food_order_items`
--

CREATE TABLE `food_order_items` (
  `id` int(14) NOT NULL,
  `order_id` int(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `food_id` int(4) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `quantity` decimal(9,2) NOT NULL,
  `food_price` decimal(9,2) NOT NULL,
  `foodprice_total` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `food_order_items`
--

INSERT INTO `food_order_items` (`id`, `order_id`, `email`, `food_id`, `food_name`, `quantity`, `food_price`, `foodprice_total`) VALUES
(1, 1, '46372', 2, ' Ugali', '10.00', '30.00', '300.00'),
(2, 1, '46372', 3, ' chapo', '1.00', '34.00', '34.00'),
(3, 2, '3763876', 5, ' nyake', '10.00', '31.00', '310.00'),
(4, 2, '3763876', 4, ' kuku', '10.00', '76.00', '760.00'),
(5, 3, '4323', 4, ' kuku', '1.00', '76.00', '76.00'),
(6, 3, '4323', 5, ' nyake', '1.00', '31.00', '31.00'),
(7, 3, '4323', 18, ' mchele', '1.00', '999.00', '999.00'),
(8, 4, '4323', 18, ' mchele', '1.00', '999.00', '999.00'),
(9, 4, '4323', 5, ' nyake', '1.00', '31.00', '31.00'),
(10, 5, '4323', 3, ' chapo', '1.00', '34.00', '34.00'),
(11, 5, '4323', 16, ' Ugali', '10.00', '50.00', '500.00'),
(12, 5, '4323', 18, ' mchele', '1.00', '999.00', '999.00'),
(13, 6, '4323', 2, ' Ugali', '1.00', '30.00', '30.00'),
(14, 6, '4323', 5, ' nyake', '1.00', '31.00', '31.00'),
(15, 6, '4323', 18, ' mchele', '1.00', '999.00', '999.00'),
(16, 6, '4323', 16, ' Ugali', '1.00', '50.00', '50.00'),
(17, 7, '4323', 2, ' Ugali', '1.00', '30.00', '30.00'),
(18, 7, '4323', 18, ' mchele', '777.00', '999.00', '776223.00'),
(19, 8, '4323', 2, ' Ugali', '1.00', '30.00', '30.00'),
(20, 8, '4323', 16, ' Ugali', '10.00', '50.00', '500.00'),
(21, 9, '4323', 2, ' Ugali', '1.00', '30.00', '30.00');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `room_details` varchar(100) NOT NULL,
  `room_status` enum('Available','Booked') NOT NULL DEFAULT 'Available',
  `room_price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `room_type`, `name`, `room_details`, `room_status`, `room_price`) VALUES
(1, 'room1', 'Single', 'pablo meme.PNG', '9jnijnj', '', '56.0009'),
(2, 'room2', 'Single', 'drink-3242673__340.jpg', 'k', 'Available', '09'),
(3, 'room7', 'Double', 'istockphoto-1134703571-170667a.jpg', 'mffkfkfkf', 'Available', '200'),
(4, 'room4', 'Double', 'drink-3242673__340.jpg', 'alalall', 'Available', '390');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_ordered`
--

CREATE TABLE `rooms_ordered` (
  `id` int(14) NOT NULL,
  `room_order_id` int(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `room_id` int(4) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `room_price` decimal(9,2) NOT NULL,
  `roomprice_total` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms_ordered`
--

INSERT INTO `rooms_ordered` (`id`, `room_order_id`, `email`, `room_id`, `room_name`, `room_price`, `roomprice_total`) VALUES
(1, 6, 'c@c.c', 2, ' room2', '9.00', '90.00'),
(2, 7, 'c@c.c', 2, ' room2', '9.00', '9.00'),
(3, 8, 'c@c.c', 2, ' room2', '9.00', '9.00'),
(4, 8, 'c@c.c', 3, ' room7', '200.00', '200.00'),
(5, 8, 'c@c.c', 4, ' room4', '390.00', '390.00');

-- --------------------------------------------------------

--
-- Table structure for table `room_orders`
--

CREATE TABLE `room_orders` (
  `room_order_id` int(14) NOT NULL,
  `emailuser` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `date_in` datetime NOT NULL,
  `date_out` datetime NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room_orders`
--

INSERT INTO `room_orders` (`room_order_id`, `emailuser`, `date`, `date_in`, `date_out`, `order_status`) VALUES
(1, 'hSESSION', '2021-03-25 10:15:38', '2021-03-30 00:00:00', '2021-03-03 00:00:00', 'active'),
(2, 'c@c.c', '2021-03-26 10:43:36', '2021-03-17 00:00:00', '2021-04-01 00:00:00', 'active'),
(3, 'c@c.c', '2021-03-26 10:45:28', '2021-03-26 00:00:00', '2021-03-27 00:00:00', 'active'),
(4, 'c@c.c', '2021-03-26 10:49:42', '2021-03-26 00:00:00', '2021-04-03 00:00:00', 'active'),
(5, 'c@c.c', '2021-03-26 10:51:29', '2021-03-19 00:00:00', '2021-04-03 00:00:00', 'active'),
(6, 'c@c.c', '2021-03-26 10:52:58', '2021-03-27 00:00:00', '2021-03-31 00:00:00', 'active'),
(7, 'c@c.c', '2021-03-26 10:54:45', '2021-03-03 00:00:00', '2021-03-03 00:00:00', 'active'),
(8, 'c@c.c', '2021-03-26 10:57:44', '2021-03-26 00:00:00', '2021-03-30 00:00:00', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'customer',
  `firstname` varchar(50) NOT NULL,
  `secondname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel_no` int(30) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `firstname`, `secondname`, `email`, `tel_no`, `status`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'chelsea', 'chelsea', 'chelsea@chelsea.chelsea', 123456, 'active', '$2y$10$6ZudqjGqp3mztwfL6iFpW.vRY6qQsCOa4IcjaWemKUe/LDmcS9Wni', '2021-03-24 16:17:29', '2021-03-24 16:17:29'),
(2, 'customer', 'karani', 'kevo', 'a@b.c', 908, ' active', '$2y$10$AIRmd6dtU1MExGoF26pTiehQjIJnYgfCD7PxVZJfKlbSBFJH1JoPG', '2021-03-24 16:18:28', '2021-03-24 16:18:28'),
(3, 'customer', 'sus', 'sus', 'sus@sus.sus', 78767, ' suspended', '$2y$10$7C.7GyujDMLrddryfqxVTeRYKD.HJ/t5hl/l0TwUIH3klixvYObP2', '2021-03-24 17:18:58', '2021-03-24 17:18:58'),
(4, 'customer', '98', 'muriuki', 'indomitablewriters@gmail.com', 1232434, 'active', '$2y$10$EHSZziMquWfr9Ph6sW327ORlc.HT5e4b7LonCAaGlcbp29wQDluve', '2021-03-24 17:34:53', '2021-03-24 17:34:53'),
(5, 'administrator', '2', 'muriuki', 'a@b.ch', 98, 'active', '$2y$10$spzPhIeeofO8y5QZqAfymuKbXQT6s9dn7xj1EBK5eBRq9OhO6t7ve', '2021-03-24 17:52:55', '2021-03-24 17:52:55'),
(6, 'customer', 'tyr', '23', 'w@d.c', 345434532, 'deleted', '$2y$10$OdxbecEskxC40LIM3PGoFucQx56v0y8rVkOGkIE96PHHpW0tIBVNG', '2021-03-24 17:54:34', '2021-03-24 17:54:34'),
(7, 'customer', 'c', 'c', 'c@c.c', 4323, 'active', '$2y$10$hcvXrfG2AbN/MyiQPzaTkeJH7YI9DAGk43bN9rjk1vHE2sjrRxtPi', '2021-03-25 17:29:48', '2021-03-25 17:29:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foodorders`
--
ALTER TABLE `foodorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_order_items`
--
ALTER TABLE `food_order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `rooms_ordered`
--
ALTER TABLE `rooms_ordered`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_orders`
--
ALTER TABLE `room_orders`
  ADD PRIMARY KEY (`room_order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tel_no` (`tel_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foodorders`
--
ALTER TABLE `foodorders`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `food_order_items`
--
ALTER TABLE `food_order_items`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms_ordered`
--
ALTER TABLE `rooms_ordered`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room_orders`
--
ALTER TABLE `room_orders`
  MODIFY `room_order_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
