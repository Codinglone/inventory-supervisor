-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2023 at 02:09 PM
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
-- Database: `inventory_supervisor`
--

-- --------------------------------------------------------

--
-- Table structure for table `cyber_products`
--

CREATE TABLE `cyber_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cyber_products`
--

INSERT INTO `cyber_products` (`id`, `product_name`, `quantity`, `price_per_unit`) VALUES
(1, 'Pen', 7, 100),
(2, 'Notebooks', 16, 600),
(8, 'Pencil', 50, 200),
(11, 'Mathematical Set', 1, 500);

-- --------------------------------------------------------

--
-- Table structure for table `cyber_products_transactions`
--

CREATE TABLE `cyber_products_transactions` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` float NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cyber_products_transactions`
--

INSERT INTO `cyber_products_transactions` (`id`, `product_name`, `quantity`, `price_per_unit`, `dates`) VALUES
(1, 'Pen', 1, 100, '2023-11-23'),
(2, 'Pen', 1, 100, '2023-11-23'),
(3, 'Pen', 2, 100, '2023-11-23'),
(4, 'Pen', 7, 100, '2023-11-23'),
(5, 'Notebooks', 2, 600, '2023-11-23'),
(6, 'Notebooks', 2, 600, '2023-11-23'),
(7, 'Pen', 1, 100, '2023-11-28'),
(8, 'Pen', 2, 100, '2023-11-28'),
(9, 'Mathematical Set', 1, 500, '2023-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `daily_total_income`
--

CREATE TABLE `daily_total_income` (
  `id` int(11) NOT NULL,
  `dates` varchar(255) NOT NULL,
  `total_income` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_total_income`
--

INSERT INTO `daily_total_income` (`id`, `dates`, `total_income`) VALUES
(3, '2023-11-29', 42000);

-- --------------------------------------------------------

--
-- Table structure for table `gym_clients`
--

CREATE TABLE `gym_clients` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `membership_type` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `dates` varchar(255) NOT NULL,
  `amount_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gym_clients`
--

INSERT INTO `gym_clients` (`id`, `fullname`, `membership_type`, `organization`, `dates`, `amount_paid`) VALUES
(1, 'NIYOKWIZERWA Fabrice', 'Daily', 'Personal', '2023-11-24', 2000),
(2, 'UWAYO Benjamin', 'Daily', 'Personal', '2023-11-29', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `gym_organizations`
--

CREATE TABLE `gym_organizations` (
  `id` int(11) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `date_registered` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gym_organizations`
--

INSERT INTO `gym_organizations` (`id`, `organization_name`, `date_registered`) VALUES
(1, 'RDB', ''),
(2, 'BK', ''),
(3, 'RRA', ''),
(4, 'IITECH', '2023-11-28 14:47:53');

-- --------------------------------------------------------

--
-- Table structure for table `restaurent_products`
--

CREATE TABLE `restaurent_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurent_products`
--

INSERT INTO `restaurent_products` (`id`, `product_name`, `price`) VALUES
(1, 'Hot Dog', 1000),
(3, 'Milkshake', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `restaurent_products_transactions`
--

CREATE TABLE `restaurent_products_transactions` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurent_products_transactions`
--

INSERT INTO `restaurent_products_transactions` (`id`, `product_name`, `quantity`, `price`, `dates`) VALUES
(1, 'Hot Dog', 2, 1000, '2023-11-23'),
(2, 'Hot Dog', 1, 1000, '2023-11-23'),
(3, 'Hot Dog', 3, 1000, '2023-11-28'),
(4, 'Milkshake', 3, 2000, '2023-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `room_price` int(11) NOT NULL,
  `room_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `room_price`, `room_status`) VALUES
(1, 'F1-100', 20000, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_clients`
--

CREATE TABLE `rooms_clients` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `checkin_date` varchar(20) NOT NULL,
  `checkout_date` varchar(20) NOT NULL,
  `room_id` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_clients`
--

INSERT INTO `rooms_clients` (`id`, `fullname`, `email`, `phone`, `id_number`, `checkin_date`, `checkout_date`, `room_id`, `amount_paid`) VALUES
(2, 'NIYOKWIZERWA Fabrice', 'codinglone@gmail.com', '+250784427142', '120008045872865', '2023-11-29', '2023-11-30', 1, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `sauna_massage_clients`
--

CREATE TABLE `sauna_massage_clients` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `membership_type` varchar(255) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `dates` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sauna_massage_clients`
--

INSERT INTO `sauna_massage_clients` (`id`, `fullname`, `email`, `phone`, `service_type`, `membership_type`, `amount_paid`, `dates`) VALUES
(1, 'NIYOKWIZERWA Eric', 'codinglone@gmail.com', '+250784427142', 'Sauna & Massage', 'Monthly', 1000, '2023-11-28'),
(2, 'Habimana Eric', 'erichabimana@gmail.com', '0783217831', 'Sauna & Massage', 'Daily', 10000, '2023-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `supermarket_products`
--

CREATE TABLE `supermarket_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` float NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supermarket_products`
--

INSERT INTO `supermarket_products` (`id`, `product_name`, `unit_price`, `quantity`) VALUES
(1, 'Inyange milk', 700, 5),
(2, 'Milinda Juice', 1000, 4),
(3, 'Inyange Juice Apple', 800, 10);

-- --------------------------------------------------------

--
-- Table structure for table `supermarket_products_transactions`
--

CREATE TABLE `supermarket_products_transactions` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` float NOT NULL,
  `dates` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supermarket_products_transactions`
--

INSERT INTO `supermarket_products_transactions` (`id`, `product_name`, `quantity`, `price_per_unit`, `dates`) VALUES
(1, 'Inyange milk', 3, 700, '2023-11-23'),
(2, 'Inyange milk', 7, 700, '2023-11-23'),
(3, 'Inyange milk', 5, 700, '2023-11-29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`) VALUES
(1, 'NIYOKWIZERWA Fabrice', 'codinglone@gmail.com', '123', 'accountant'),
(2, 'NIYOKWIZERWA Fabrice', 'manager@gmail.com', '1234', 'manager'),
(4, 'Fabrice', 'supermarket@gmail.com', '123', 'supermarket'),
(5, 'Benjamin', 'saunamassage@gmail.com', '123', 'sauna-massage'),
(6, 'NIYOKWIZERWA', 'cyber@gmail.com', '123', 'cyber'),
(7, 'UWAYO', 'restaurent@gmail.com', '123', 'restaurent'),
(9, 'Codinglone', 'reception@gmail.com', '123', 'reception'),
(10, 'UWABEN', 'technician@gmail.com', '123', 'technician');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cyber_products`
--
ALTER TABLE `cyber_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cyber_products_transactions`
--
ALTER TABLE `cyber_products_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_total_income`
--
ALTER TABLE `daily_total_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_clients`
--
ALTER TABLE `gym_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gym_organizations`
--
ALTER TABLE `gym_organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurent_products`
--
ALTER TABLE `restaurent_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurent_products_transactions`
--
ALTER TABLE `restaurent_products_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms_clients`
--
ALTER TABLE `rooms_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `sauna_massage_clients`
--
ALTER TABLE `sauna_massage_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supermarket_products`
--
ALTER TABLE `supermarket_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supermarket_products_transactions`
--
ALTER TABLE `supermarket_products_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cyber_products`
--
ALTER TABLE `cyber_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cyber_products_transactions`
--
ALTER TABLE `cyber_products_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `daily_total_income`
--
ALTER TABLE `daily_total_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gym_clients`
--
ALTER TABLE `gym_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gym_organizations`
--
ALTER TABLE `gym_organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurent_products`
--
ALTER TABLE `restaurent_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `restaurent_products_transactions`
--
ALTER TABLE `restaurent_products_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms_clients`
--
ALTER TABLE `rooms_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sauna_massage_clients`
--
ALTER TABLE `sauna_massage_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supermarket_products`
--
ALTER TABLE `supermarket_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supermarket_products_transactions`
--
ALTER TABLE `supermarket_products_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms_clients`
--
ALTER TABLE `rooms_clients`
  ADD CONSTRAINT `rooms_clients_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
