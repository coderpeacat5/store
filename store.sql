-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 06:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_table`
--

CREATE TABLE `data_table` (
  `S_No` int(11) NOT NULL,
  `Username` varchar(11) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `File No.` varchar(50) NOT NULL,
  `Item Name` varchar(50) NOT NULL,
  `Status` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_table`
--

INSERT INTO `data_table` (`S_No`, `Username`, `Date`, `File No.`, `Item Name`, `Status`) VALUES
(12, 'Meta', '2024-11-10', '4587', 'PC', 'OK'),
(14, 'Meta', '2024-11-10', '3569', 'Cooling Pad', 'OK'),
(15, 'Gayatri', '2024-11-10', '3564', 'PC', 'OK'),
(17, 'Meta', '2024-11-12', '3569', 'Keyboard', 'OK');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `S_No` int(11) NOT NULL,
  `Username` varchar(11) NOT NULL,
  `Role` varchar(11) NOT NULL DEFAULT 'User',
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Password` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`S_No`, `Username`, `Role`, `Date`, `Password`) VALUES
(1, 'Gayatri', 'User', '2024-11-10', '123'),
(2, 'Mona', 'User', '2024-11-10', '123'),
(3, 'Meta', 'User', '2024-11-10', '123'),
(4, 'Ravi', 'Admin', '0000-00-00', '123'),
(5, 'Pankaj', 'Admin', '0000-00-00', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_table`
--
ALTER TABLE `data_table`
  ADD PRIMARY KEY (`S_No`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`S_No`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_table`
--
ALTER TABLE `data_table`
  MODIFY `S_No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `S_No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
