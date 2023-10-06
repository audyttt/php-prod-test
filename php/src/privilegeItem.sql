-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 06, 2023 at 02:30 AM
-- Server version: 8.1.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `member`
--

-- --------------------------------------------------------

--
-- Table structure for table `privilegeItem`
--

CREATE TABLE `privilegeItem` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privilegeItem`
--

INSERT INTO `privilegeItem` (`id`, `name`, `discount`, `image`, `price`) VALUES
(1, 'Starbuks', '15', 'https://tb-static.uber.com/prod/image-proc/processed_images/cc2c3b81f1e02e1dcbffa7e0c9fdd2a1/3ac2b39ad528f8c8c5dc77c59abb683d.jpeg', 50),
(2, 'Shopee', '20', 'https://cdn.techinasia.com/wp-content/uploads/2022/02/1644411465_GettyImages-1233945042-scaled-1.jpg', 100),
(3, 'Banana IT', '15', 'https://instore.bnn.in.th/wp-content/uploads/2021/07/yingchai-yingdai-2021-1-1024x682.jpg', 80),
(4, 'Cafe Amazon', '25', 'https://www.bitec.co.th/wp-content/uploads/2021/06/DSC04756-scaled.jpg', 20),
(5, 'Tops', '30', 'https://static.thairath.co.th/media/dFQROr7oWzulq5Fa5xZ1iKH8f9PpM8g7XeIegFwd99jqVbgu67O46Z8ih9ApHNk0rMd.jpg', 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `privilegeItem`
--
ALTER TABLE `privilegeItem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `privilegeItem`
--
ALTER TABLE `privilegeItem`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
