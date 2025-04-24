-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2025 at 03:38 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_detail_transaksi`
--

CREATE TABLE `master_detail_transaksi` (
  `id` int NOT NULL,
  `id_transaksi` int DEFAULT NULL,
  `id_produk` int DEFAULT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_detail_transaksi`
--

INSERT INTO `master_detail_transaksi` (`id`, `id_transaksi`, `id_produk`, `quantity`) VALUES
(42, 37, 5, 5),
(43, 37, 3, 1),
(46, 38, 5, 12),
(47, 38, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_produk`
--

CREATE TABLE `master_produk` (
  `id` int NOT NULL,
  `produk` varchar(255) NOT NULL,
  `stok` int NOT NULL,
  `harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_produk`
--

INSERT INTO `master_produk` (`id`, `produk`, `stok`, `harga`) VALUES
(3, 'Celana Jeans', 33, 102000),
(5, 'Karpet', 31, 35000);

-- --------------------------------------------------------

--
-- Table structure for table `master_transaksi`
--

CREATE TABLE `master_transaksi` (
  `id` int NOT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_transaksi`
--

INSERT INTO `master_transaksi` (`id`, `kode_transaksi`, `tanggal`) VALUES
(37, '120250423', '2025-04-23 22:46:00'),
(38, '3820250424', '2025-04-10 03:33:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_detail_transaksi`
--
ALTER TABLE `master_detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `master_produk`
--
ALTER TABLE `master_produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produk` (`produk`);

--
-- Indexes for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_detail_transaksi`
--
ALTER TABLE `master_detail_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `master_produk`
--
ALTER TABLE `master_produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_detail_transaksi`
--
ALTER TABLE `master_detail_transaksi`
  ADD CONSTRAINT `master_detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `master_transaksi` (`id`),
  ADD CONSTRAINT `master_detail_transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `master_produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
