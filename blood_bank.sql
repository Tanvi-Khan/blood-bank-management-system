-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2026 at 07:55 PM
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
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

DROP TABLE IF EXISTS `blood_requests`;
CREATE TABLE `blood_requests` (
  `request_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `request_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`request_id`, `patient_name`, `blood_group`, `quantity`, `status`, `request_date`) VALUES
(12, 'Hasan', 'B+', 2, 'Approved', '2026-07-11'),
(15, 'Karim', 'A+', 2, 'Approved', '2026-07-19'),
(16, 'Turjo', 'B-', 2, 'Pending', '2026-07-19');

-- --------------------------------------------------------

--
-- Table structure for table `blood_stock`
--

DROP TABLE IF EXISTS `blood_stock`;
CREATE TABLE `blood_stock` (
  `stock_id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `last_updated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_stock`
--

INSERT INTO `blood_stock` (`stock_id`, `blood_group`, `quantity`, `last_updated`) VALUES
(1, 'A+', 16, '2026-07-19'),
(2, 'A-', 10, '2026-07-13'),
(3, 'B+', 8, '2026-07-13'),
(4, 'B-', 6, '2026-07-12'),
(5, 'AB+', 15, '2026-07-12'),
(6, 'AB-', 0, '2026-07-12'),
(7, 'O+', 18, '2026-07-13'),
(8, 'O-', 0, '2026-07-11');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

DROP TABLE IF EXISTS `donors`;
CREATE TABLE `donors` (
  `donor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `last_donation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`donor_id`, `name`, `blood_group`, `phone`, `email`, `last_donation_date`) VALUES
(1, 'Tanvi Khan', 'O+', '01639615914', 'tanvikhan@gmail.com', '2025-12-20'),
(2, 'Bijay Paul', 'A+', '01700000000', 'bijaypaul@gmail.com', '2026-02-24'),
(9, 'Kabir Ahmed', 'B+', '01787878787', 'kabir245@gmail.com', '2026-01-06'),
(10, 'Shuvo Sheikh', 'O+', '01622222222', 'shuvosheikh@gmail.com', '2025-01-16'),
(11, 'Anik Ahmed', 'A+', '01533333333', 'anikahmed@gmail.com', '2025-06-18'),
(12, 'Tarek Khan', 'A-', '01644444444', 'tarekkhan@gmail.com', '2026-03-10'),
(13, 'Habib Rahman', 'AB+', '01855555555', 'habib845@gmail.com', '2026-06-08'),
(14, 'Nizam Uddin', 'B+', '01688888888', 'nizamuddin@gmail.com', '2025-06-26'),
(15, 'Mamun Loskor', 'O-', '01588888888', 'Mamunloskor@gmail.com', '2026-05-05'),
(16, 'Akhil Sheikh', 'O+', '01655555555', 'akhilsheikh@gmail.com', '2026-02-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `blood_stock`
--
ALTER TABLE `blood_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`donor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `blood_stock`
--
ALTER TABLE `blood_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
