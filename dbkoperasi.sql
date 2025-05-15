-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 06:46 PM
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
-- Database: `dbkoperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `status_aktif` tinyint(1) DEFAULT NULL,
  `pegawai_id` int(11) DEFAULT NULL,
  `kartu_diskon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `status_aktif`, `pegawai_id`, `kartu_diskon_id`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 0, 3, 4),
(4, 1, 4, 3),
(5, 1, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `pesanan_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`pesanan_id`, `produk_id`, `jumlah`) VALUES
(1, 1, 1),
(1, 3, 5),
(2, 2, 10),
(3, 5, 3),
(4, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_produk`
--

CREATE TABLE `jenis_produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_produk`
--

INSERT INTO `jenis_produk` (`id`, `nama`, `deskripsi`) VALUES
(1, 'Elektronik', 'Peralatan elektronik rumah tangga'),
(2, 'Alat Tulis', 'Kebutuhan sekolah dan kantor'),
(3, 'Makanan', 'Snack dan makanan instan'),
(4, 'Pakaian', 'Busana pria dan wanita'),
(5, 'Obat', 'Obat-obatan ringan dan vitamin');

-- --------------------------------------------------------

--
-- Table structure for table `kartu_diskon`
--

CREATE TABLE `kartu_diskon` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `persen_diskon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kartu_diskon`
--

INSERT INTO `kartu_diskon` (`id`, `nama`, `deskripsi`, `persen_diskon`) VALUES
(1, 'Silver', 'Diskon anggota silver', 5),
(2, 'Gold', 'Diskon anggota gold', 10),
(3, 'Platinum', 'Diskon platinum premium', 15),
(4, 'None', 'Tidak ada diskon', 0),
(5, 'Student', 'Diskon khusus mahasiswa', 7);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(10) DEFAULT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `jabatan` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama`, `jenis_kelamin`, `jabatan`, `email`, `password`) VALUES
(1, '1234567890', 'Ahmad Yani', 'L', 'Staf', 'ahmad@example.com', '$2y$10$hashdummy1'),
(2, '2345678901', 'Siti Aminah', 'P', 'Manager', 'siti@example.com', '$2y$10$hashdummy2'),
(3, '3456789012', 'Budi Santoso', 'L', 'Kasir', 'budi@example.com', '$2y$10$hashdummy3'),
(4, '4567890123', 'Dina Fitriani', 'P', 'Admin', 'dina@example.com', '$2y$10$hashdummy4'),
(5, '5678901234', 'Rahmat Hidayat', 'L', 'Supervisor', 'rahmat@example.com', '$2y$10$hashdummy5'),
(6, '6208480921', 'user', 'L', 'Staf', 'user@gmail.com', '$2y$10$l5dwVKPGVz0Ru2/BYLAcf.dp1YxKGo3noqc3yjQQlIhObJ74MTZtS');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `jumlah_bayar` double DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `pesanan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `jumlah_bayar`, `tanggal`, `pesanan_id`) VALUES
(1, 285000, '2025-05-01', 1),
(2, 0, '2025-05-02', 2),
(3, 24000, '2025-05-03', 3),
(4, 85000, '2025-05-04', 4),
(5, 0, '2025-05-05', 5);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `status_bayar` tinyint(1) DEFAULT NULL,
  `anggota_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `tanggal`, `diskon`, `status_bayar`, `anggota_id`) VALUES
(1, '2025-05-01', 5, 1, 1),
(2, '2025-05-02', 10, 0, 2),
(3, '2025-05-03', 0, 1, 3),
(4, '2025-05-04', 15, 1, 4),
(5, '2025-05-05', 7, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `jenis_produk_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kode`, `nama`, `deskripsi`, `harga`, `stok`, `jenis_produk_id`) VALUES
(1, 'ELK001', 'Rice Cooker', 'Penanak nasi 1L', 300000, 20, 1),
(2, 'ALT001', 'Pulpen', 'Pulpen tinta hitam', 3000, 200, 2),
(3, 'MKN001', 'Mie Instan', 'Mie goreng instan', 2500, 500, 3),
(4, 'PKN001', 'Kaos Polos', 'Kaos polos ukuran L', 50000, 50, 4),
(5, 'OBT001', 'Paracetamol', 'Obat sakit kepala', 8000, 100, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`),
  ADD KEY `kartu_diskon_id` (`kartu_diskon_id`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`pesanan_id`,`produk_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `jenis_produk`
--
ALTER TABLE `jenis_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kartu_diskon`
--
ALTER TABLE `kartu_diskon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_id` (`anggota_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_produk_id` (`jenis_produk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_produk`
--
ALTER TABLE `jenis_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kartu_diskon`
--
ALTER TABLE `kartu_diskon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  ADD CONSTRAINT `anggota_ibfk_2` FOREIGN KEY (`kartu_diskon_id`) REFERENCES `kartu_diskon` (`id`);

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`jenis_produk_id`) REFERENCES `jenis_produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
