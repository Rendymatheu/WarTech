-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2026 at 04:45 PM
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
-- Database: `dbpos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(100) NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `stock_minimal` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `barcode`, `nama_barang`, `harga_beli`, `harga_jual`, `stock`, `satuan`, `stock_minimal`, `gambar`) VALUES
('BRG-001', '424142141', 'alvin', 15000, 18000, 0, 'piece', 5, 'BRG-001-png'),
('BRG-002', '0871248124124', 'aldo', 50000, 100000, 0, 'piece', 3, 'BRG-002.png'),
('BRG-003', '21411111112412', 'aldi', 400000, 800000, 0, 'botol', 20, 'BRG-003.842.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli_detail`
--

CREATE TABLE `tbl_beli_detail` (
  `id` int(11) NOT NULL,
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kode_brg` varchar(10) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_beli_detail`
--

INSERT INTO `tbl_beli_detail` (`id`, `no_beli`, `tgl_beli`, `kode_brg`, `nama_brg`, `qty`, `harga_beli`, `jml_harga`) VALUES
(2, 'PB0001', '2026-05-16', 'BRG-002', 'aldo', 3, 50000, 150000),
(4, 'PB0001', '2026-05-16', 'BRG-001', 'alvin', 4, 15000, 60000),
(5, 'PB0002', '2026-05-16', 'BRG-001', 'alvin', 5, 15000, 75000),
(6, 'PB0002', '2026-05-16', 'BRG-002', 'aldo', 4, 50000, 200000),
(8, 'PB0003', '2026-05-16', 'BRG-003', 'aldi', 3, 400000, 1200000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli_head`
--

CREATE TABLE `tbl_beli_head` (
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `suplier` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_beli_head`
--

INSERT INTO `tbl_beli_head` (`no_beli`, `tgl_beli`, `suplier`, `total`, `keterangan`) VALUES
('PB0001', '2026-05-16', 'CV Fajar Sentosa', 210000, ''),
('PB0002', '2026-05-16', 'halo king alvin', 275000, ''),
('PB0003', '2026-05-16', 'halo king alvin', 1200000, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id_customer` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(25) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id_customer`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(2, 'aldi', '017248124214', '12313213', 'cmon');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jual_detail`
--

CREATE TABLE `tbl_jual_detail` (
  `id` int(11) NOT NULL,
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_jual_detail`
--

INSERT INTO `tbl_jual_detail` (`id`, `no_jual`, `tgl_jual`, `barcode`, `nama_brg`, `qty`, `harga_jual`, `jml_harga`) VALUES
(1, 'PJ0001', '2026-05-16', 'BRG-001', 'alvin', 1, 18000, 18000),
(2, 'PJ0001', '2026-05-16', 'BRG-002', 'aldo', 2, 100000, 200000),
(3, 'PJ0001', '2026-05-16', '0871248124124', 'aldo', 1, 100000, 100000),
(5, 'PJ0002', '2026-05-16', '424142141', 'alvin', 2, 18000, 36000),
(6, 'PJ0003', '2026-05-16', '0871248124124', 'aldo', 2, 100000, 200000),
(7, 'PJ0004', '2026-05-16', '0871248124124', 'aldo', 1, 100000, 100000),
(8, 'PJ0005', '2026-05-16', '424142141', 'alvin', 2, 18000, 36000),
(9, 'PJ0006', '2026-05-16', '424142141', 'alvin', 1, 18000, 18000),
(10, 'PJ0007', '2026-05-16', '424142141', 'alvin', 1, 18000, 18000),
(11, 'PJ0007', '2026-05-16', '0871248124124', 'aldo', 1, 100000, 100000),
(12, 'PJ0008', '2026-05-03', '0871248124124', 'aldo', 1, 100000, 100000),
(13, 'PJ0009', '2026-05-16', '424142141', 'alvin', 1, 18000, 18000),
(14, 'PJ0009', '2026-05-16', '0871248124124', 'aldo', 1, 100000, 100000),
(15, 'PJ0010', '2026-05-16', '21411111112412', 'aldi', 3, 800000, 2400000),
(16, 'PJ0010', '2026-05-16', '424142141', 'alvin', 1, 18000, 18000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jual_head`
--

CREATE TABLE `tbl_jual_head` (
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `customer` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jml_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_jual_head`
--

INSERT INTO `tbl_jual_head` (`no_jual`, `tgl_jual`, `customer`, `total`, `keterangan`, `jml_bayar`, `kembalian`) VALUES
('PJ0001', '2026-05-16', '', 318000, '', 60000, -258000),
('PJ0002', '2026-05-16', '', 36000, '', 50000, 14000),
('PJ0003', '2026-05-16', 'tetst', 200000, '', 300000, 100000),
('PJ0004', '2026-05-16', 'tetst', 100000, '', 150000, 50000),
('PJ0005', '2026-05-16', 'tetst', 36000, 'gg', 50000, 14000),
('PJ0006', '2026-05-16', 'tetst', 18000, 'gg', 20000, 2000),
('PJ0007', '2026-05-16', 'tetst', 118000, 'gg', 150, -117850),
('PJ0008', '2026-05-03', 'tetst', 100000, '', 120000, 20000),
('PJ0009', '2026-05-16', 'tetst', 118000, '', 120000, 2000),
('PJ0010', '2026-05-16', 'aldi', 2418000, 'test', 2500000, 82000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(25) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id_supplier`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(1, 'PT Enseval', '08222222222', 'ok', 'Jakarta'),
(2, 'PT Enseval', '08222222222', '', 'Jakarta'),
(3, 'PT Enseval', '08222222222', '', 'Jakarta'),
(4, 'CV Fajar Sentosa', '081234567', '', 'Jakarta'),
(10, 'halo king alvin', '241244142', 'teste', '132414');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `address` varchar(100) NOT NULL,
  `level` int(1) NOT NULL COMMENT '1.pemilik\r\n2.kasir',
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `fullname`, `password`, `address`, `level`, `foto`) VALUES
(3, 'pemilik', 'pemilik', '$2y$10$QbTAssDslnwG6ivXgCJDZehCmra5UikMOg1P7WFkHhxKyJ/co7iWK', 'Jakarta', 1, '780-profile.png'),
(4, 'kasir', 'kasir', '$2y$10$AE8AorMB.ve4ugCxif3Gded4VA5ZpiOyuAoBOkeUefLbqFmpHd4ku', 'Jakarta', 2, '631-815-raphaelsilva-user-2935522_640.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_beli_head`
--
ALTER TABLE `tbl_beli_head`
  ADD PRIMARY KEY (`no_beli`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jual_head`
--
ALTER TABLE `tbl_jual_head`
  ADD PRIMARY KEY (`no_jual`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
