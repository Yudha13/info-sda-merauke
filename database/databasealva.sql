-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 03:49 PM
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
-- Database: `databasealva`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `username`, `password`) VALUES
(10, 'alvarizyrachman', 'alva', '$2y$10$r6.GwWHePtjM9oPzIuXt2uxZdWs3ZoiKjwuGjwQwWa.O6oFGwYnva'),
(11, 'User123', 'admin', '$2y$10$W2c0HEb4H7ryqKMsFYlT/eWBevYCBhbI4DsKrraO14kCpUsxXCKRy');

-- --------------------------------------------------------

--
-- Table structure for table `data_daerah`
--

CREATE TABLE `data_daerah` (
  `id_daerah` int(11) NOT NULL,
  `nama_daerah` varchar(255) NOT NULL,
  `luas_wilayah` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_daerah`
--

INSERT INTO `data_daerah` (`id_daerah`, `nama_daerah`, `luas_wilayah`) VALUES
(3, 'Kurik', 320.00),
(4, 'Jagebob', 3562.00),
(5, 'Tanah Miring', 5000.00),
(6, 'Muting', 1000.00),
(7, 'Tubang', 2333.00),
(8, 'Okaba', 12233.00),
(9, 'Kimaam', 4566.00),
(10, 'Semangga', 43454.00),
(11, 'Sota', 3443.00),
(12, 'Ulilin', 753.00),
(13, 'Elikobel', 633.00),
(14, 'Naukenjerai', 3443.00),
(15, 'Kaptel', 3443.00),
(16, 'Ngguti', 334.00),
(18, 'Tabonji', 4333.00),
(19, 'Waan', 544.00),
(20, 'Animha', 656.00),
(21, 'Malind', 6555.00),
(22, 'Tubang', 544.00),
(24, 'Ilwayab', 2334.00),
(25, 'Padua', 442.00),
(26, 'Kontuar', 500.00),
(27, 'Merauke', 123.00);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_panen`
--

CREATE TABLE `hasil_panen` (
  `id_hasil_panen` int(11) NOT NULL,
  `id_jenis_panen` int(11) NOT NULL,
  `id_daerah` int(11) NOT NULL,
  `tahun_panen` year(4) NOT NULL,
  `kuantitas` decimal(10,2) NOT NULL,
  `luas_lahan_tanam` decimal(10,2) NOT NULL,
  `luas_lahan_panen` decimal(10,2) NOT NULL,
  `produktivitas_per_hektar` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_panen`
--

INSERT INTO `hasil_panen` (`id_hasil_panen`, `id_jenis_panen`, `id_daerah`, `tahun_panen`, `kuantitas`, `luas_lahan_tanam`, `luas_lahan_panen`, `produktivitas_per_hektar`) VALUES
(20, 22, 9, '2023', 234.40, 0.00, 64.75, NULL),
(21, 22, 18, '2023', 152.08, 0.00, 36.50, NULL),
(22, 22, 19, '2023', 82.16, 0.00, 19.75, NULL),
(23, 22, 8, '2023', 404.63, 0.00, 124.50, NULL),
(24, 22, 15, '2023', 0.00, 0.00, 1.50, NULL),
(25, 22, 3, '2023', 87483.75, 0.00, 15375.00, NULL),
(26, 22, 20, '2023', 84.00, 0.00, 35.00, NULL),
(27, 22, 21, '2023', 42183.00, 0.00, 9374.00, NULL),
(28, 22, 27, '2023', 3618.45, 0.00, 731.00, NULL),
(29, 22, 14, '2023', 416.25, 0.00, 185.00, NULL),
(30, 22, 10, '2023', 43650.77, 0.00, 8128.00, NULL),
(31, 22, 5, '2023', 64392.60, 0.00, 14552.00, NULL),
(32, 22, 4, '2023', 2369.95, 0.00, 764.50, NULL),
(33, 22, 11, '2023', 2.30, 0.00, 2.00, NULL),
(34, 22, 6, '2023', 100.50, 0.00, 30.00, NULL),
(35, 22, 13, '2023', 197.75, 0.00, 56.50, NULL),
(36, 22, 12, '2023', 127.75, 0.00, 36.50, NULL),
(37, 23, 9, '2023', 24.50, 0.00, 7.00, NULL),
(38, 23, 8, '2023', 98.47, 0.00, 21.50, NULL),
(39, 23, 7, '2023', 15.79, 0.00, 3.50, NULL),
(40, 23, 3, '2023', 330.80, 0.00, 82.70, NULL),
(41, 24, 21, '2023', 384.75, 0.00, 85.50, NULL),
(42, 23, 27, '2023', 51.75, 0.00, 11.50, NULL),
(43, 23, 14, '2023', 81.90, 0.00, 21.00, NULL),
(44, 23, 10, '2023', 703.80, 0.00, 153.00, NULL),
(45, 23, 4, '2023', 575.00, 0.00, 143.75, NULL),
(46, 23, 5, '2023', 661.20, 0.00, 137.75, NULL),
(47, 23, 11, '2023', 39.02, 0.00, 8.50, NULL),
(48, 23, 6, '2023', 89.01, 0.00, 23.00, NULL),
(49, 23, 13, '2023', 247.80, 0.00, 70.00, NULL),
(50, 23, 12, '2023', 120.36, 0.00, 34.00, NULL),
(51, 24, 3, '2023', 12.00, 0.00, 6.00, NULL),
(52, 24, 21, '2023', 22.43, 0.00, 11.50, NULL),
(53, 24, 4, '2023', 86.25, 0.00, 37.50, NULL),
(54, 24, 6, '2023', 6.80, 0.00, 4.00, NULL),
(55, 24, 12, '2023', 8.55, 0.00, 4.50, NULL),
(56, 25, 9, '2023', 780.00, 0.00, 52.00, NULL),
(57, 25, 18, '2023', 1144.00, 0.00, 52.00, NULL),
(58, 25, 19, '2023', 304.00, 0.00, 19.00, NULL),
(59, 25, 24, '2023', 140.00, 0.00, 10.00, NULL),
(60, 25, 8, '2023', 866.25, 0.00, 57.75, NULL),
(61, 25, 7, '2023', 198.00, 0.00, 11.00, NULL),
(62, 25, 3, '2023', 377.30, 0.00, 24.50, NULL),
(63, 25, 20, '2023', 251.25, 0.00, 16.75, NULL),
(64, 25, 21, '2023', 224.75, 0.00, 14.50, NULL),
(65, 25, 27, '2023', 336.00, 0.00, 21.00, NULL),
(66, 25, 14, '2023', 660.83, 0.00, 40.05, NULL),
(67, 25, 10, '2023', 383.63, 0.00, 23.25, NULL),
(68, 25, 5, '2023', 668.25, 0.00, 40.50, NULL),
(69, 25, 4, '2023', 1073.38, 0.00, 69.25, NULL),
(70, 25, 11, '2023', 413.25, 0.00, 21.75, NULL),
(71, 25, 6, '2023', 693.75, 0.00, 46.25, NULL),
(72, 25, 13, '2023', 765.00, 0.00, 38.25, NULL),
(73, 25, 12, '2023', 1968.75, 0.00, 78.75, NULL),
(74, 22, 9, '2022', 560.00, 0.00, 160.00, NULL),
(75, 22, 18, '2022', 239.48, 0.00, 77.25, NULL),
(76, 22, 19, '2022', 226.95, 0.00, 89.00, NULL),
(77, 22, 24, '2022', 119.25, 0.00, 45.00, NULL),
(78, 22, 8, '2022', 350.30, 0.00, 113.00, NULL),
(79, 22, 7, '2022', 20.00, 0.00, 8.00, NULL),
(80, 22, 15, '2022', 2.50, 0.00, 1.00, NULL),
(81, 22, 3, '2022', 77660.80, 0.00, 17335.00, NULL),
(82, 22, 20, '2022', 139.37, 0.00, 38.50, NULL),
(83, 22, 21, '2022', 35747.25, 0.00, 9285.00, NULL),
(84, 22, 27, '2022', 4870.32, 0.00, 1170.75, NULL),
(85, 22, 14, '2022', 1666.00, 0.00, 490.00, NULL),
(86, 22, 10, '2022', 28310.75, 0.00, 8711.00, NULL),
(87, 22, 5, '2022', 64639.26, 0.00, 15921.00, NULL),
(88, 22, 4, '2022', 3048.64, 0.00, 752.75, NULL),
(89, 22, 11, '2022', 3.10, 0.00, 1.00, NULL),
(90, 22, 6, '2022', 190.95, 0.00, 57.00, NULL),
(91, 22, 13, '2022', 469.00, 0.00, 134.00, NULL),
(92, 22, 12, '2022', 780.50, 0.00, 223.00, NULL),
(93, 23, 8, '2022', 57.00, 0.00, 19.00, NULL),
(94, 23, 3, '2022', 1787.00, 0.00, 389.00, NULL),
(95, 23, 9, '2022', 33.00, 0.00, 10.00, NULL),
(96, 23, 21, '2022', 1160.00, 0.00, 261.00, NULL),
(97, 23, 27, '2022', 936.00, 0.00, 208.00, NULL),
(98, 23, 14, '2022', 750.00, 0.00, 182.00, NULL),
(99, 23, 10, '2022', 2192.00, 0.00, 479.00, NULL),
(100, 23, 5, '2022', 2174.00, 0.00, 482.00, NULL),
(101, 23, 4, '2022', 1599.00, 0.00, 390.00, NULL),
(102, 23, 11, '2022', 354.00, 0.00, 99.00, NULL),
(103, 23, 6, '2022', 935.00, 0.00, 242.00, NULL),
(104, 23, 13, '2022', 789.00, 0.00, 223.00, NULL),
(105, 23, 12, '2022', 772.00, 0.00, 218.00, NULL),
(106, 24, 3, '2022', 8.29, 0.00, 4.25, NULL),
(107, 24, 21, '2022', 9.26, 0.00, 4.75, NULL),
(108, 24, 10, '2022', 0.48, 0.00, 0.25, NULL),
(109, 24, 5, '2022', 3.74, 0.00, 2.00, NULL),
(110, 24, 4, '2022', 39.00, 0.00, 19.50, NULL),
(111, 24, 6, '2022', 2.55, 0.00, 1.50, NULL),
(112, 24, 13, '2022', 6.13, 0.00, 3.50, NULL),
(113, 25, 9, '2022', 232.00, 0.00, 14.50, NULL),
(114, 25, 18, '2022', 247.50, 0.00, 15.00, NULL),
(115, 25, 19, '2022', 264.00, 0.00, 16.00, NULL),
(116, 25, 24, '2022', 107.25, 0.00, 6.50, NULL),
(117, 25, 8, '2022', 713.00, 0.00, 46.00, NULL),
(118, 25, 7, '2022', 323.40, 0.00, 21.00, NULL),
(119, 25, 16, '2022', 172.50, 0.00, 11.50, NULL),
(120, 25, 15, '2022', 178.25, 0.00, 11.50, NULL),
(121, 25, 3, '2022', 637.45, 0.00, 33.55, NULL),
(122, 25, 20, '2022', 135.00, 0.00, 9.00, NULL),
(123, 25, 21, '2022', 341.00, 0.00, 15.50, NULL),
(124, 25, 27, '2022', 248.00, 0.00, 15.50, NULL),
(125, 25, 14, '2022', 595.00, 0.00, 42.50, NULL),
(126, 25, 10, '2022', 330.00, 0.00, 22.00, NULL),
(127, 25, 5, '2022', 846.00, 0.00, 47.00, NULL),
(128, 25, 4, '2022', 1585.00, 0.00, 79.25, NULL),
(129, 25, 11, '2022', 513.00, 0.00, 27.00, NULL),
(130, 25, 6, '2022', 457.50, 0.00, 30.50, NULL),
(131, 25, 13, '2022', 595.00, 0.00, 29.75, NULL),
(132, 25, 12, '2022', 850.00, 0.00, 34.00, NULL),
(133, 22, 9, '2021', 3151.72, 0.00, 754.00, NULL),
(134, 22, 18, '2021', 1395.00, 0.00, 450.00, NULL),
(135, 22, 19, '2021', 994.50, 0.00, 390.00, NULL),
(136, 22, 24, '2021', 265.00, 0.00, 100.00, NULL),
(137, 22, 8, '2021', 744.00, 0.00, 240.00, NULL),
(138, 22, 7, '2021', 87.50, 0.00, 35.00, NULL),
(139, 22, 16, '2021', 12.50, 0.00, 5.00, NULL),
(140, 22, 15, '2021', 5.00, 0.00, 2.00, NULL),
(141, 22, 3, '2021', 101341.11, 0.00, 18129.00, NULL),
(142, 22, 20, '2021', 108.60, 0.00, 30.00, NULL),
(143, 22, 21, '2021', 53950.50, 0.00, 9465.00, NULL),
(144, 22, 27, '2021', 9083.20, 0.00, 1622.00, NULL),
(145, 22, 14, '2021', 1740.40, 0.00, 458.00, NULL),
(146, 22, 10, '2021', 54633.52, 0.00, 9704.00, NULL),
(147, 22, 5, '2021', 112927.20, 0.00, 17840.00, NULL),
(148, 22, 4, '2021', 5025.00, 0.00, 1256.25, NULL),
(149, 22, 11, '2021', 15.50, 0.00, 5.00, NULL),
(150, 22, 6, '2021', 887.75, 0.00, 265.00, NULL),
(151, 22, 13, '2021', 1890.00, 0.00, 540.00, NULL),
(152, 22, 12, '2021', 1330.00, 0.00, 380.00, NULL),
(153, 23, 9, '2021', 4.40, 0.00, 2.00, NULL),
(154, 23, 8, '2021', 108.75, 0.00, 43.50, NULL),
(155, 23, 3, '2021', 1206.45, 0.00, 344.70, NULL),
(156, 23, 20, '2021', 2.00, 0.00, 1.00, NULL),
(157, 23, 21, '2021', 73.43, 0.00, 22.25, NULL),
(158, 23, 27, '2021', 127.40, 0.00, 45.50, NULL),
(159, 23, 14, '2021', 112.80, 0.00, 47.00, NULL),
(160, 23, 10, '2021', 502.74, 0.00, 147.00, NULL),
(161, 23, 5, '2021', 180.20, 0.00, 53.00, NULL),
(162, 23, 4, '2021', 1001.29, 0.00, 256.74, NULL),
(163, 23, 11, '2021', 16.50, 0.00, 7.50, NULL),
(164, 23, 6, '2021', 112.05, 0.00, 41.50, NULL),
(165, 23, 13, '2021', 356.25, 0.00, 118.75, NULL),
(166, 23, 12, '2021', 246.40, 0.00, 88.00, NULL),
(167, 24, 3, '2021', 11.60, 0.00, 5.95, NULL),
(168, 24, 21, '2021', 2.44, 0.00, 1.25, NULL),
(169, 24, 27, '2021', 4.75, 0.00, 2.50, NULL),
(170, 24, 4, '2021', 6.00, 0.00, 3.00, NULL),
(171, 24, 11, '2021', 0.75, 0.00, 0.50, NULL),
(172, 24, 3, '2023', 456.00, 0.00, 340.00, NULL),
(173, 24, 4, '2023', 30000.00, 0.00, 5000.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_panen`
--

CREATE TABLE `jenis_panen` (
  `id_jenis_panen` int(11) NOT NULL,
  `nama_jenis_panen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_panen`
--

INSERT INTO `jenis_panen` (`id_jenis_panen`, `nama_jenis_panen`) VALUES
(22, 'Padi'),
(23, 'Jagung'),
(24, 'Kedelai'),
(25, 'Ubi Kayu');

-- --------------------------------------------------------

--
-- Table structure for table `peringkat_potensi`
--

CREATE TABLE `peringkat_potensi` (
  `id_peringkat` int(11) NOT NULL,
  `id_daerah` int(11) DEFAULT NULL,
  `id_jenis_panen` int(11) DEFAULT NULL,
  `tahun_panen` year(4) DEFAULT NULL,
  `peringkat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `data_daerah`
--
ALTER TABLE `data_daerah`
  ADD PRIMARY KEY (`id_daerah`);

--
-- Indexes for table `hasil_panen`
--
ALTER TABLE `hasil_panen`
  ADD PRIMARY KEY (`id_hasil_panen`);

--
-- Indexes for table `jenis_panen`
--
ALTER TABLE `jenis_panen`
  ADD PRIMARY KEY (`id_jenis_panen`);

--
-- Indexes for table `peringkat_potensi`
--
ALTER TABLE `peringkat_potensi`
  ADD PRIMARY KEY (`id_peringkat`),
  ADD KEY `id_daerah` (`id_daerah`),
  ADD KEY `id_jenis_panen` (`id_jenis_panen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `data_daerah`
--
ALTER TABLE `data_daerah`
  MODIFY `id_daerah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `hasil_panen`
--
ALTER TABLE `hasil_panen`
  MODIFY `id_hasil_panen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `jenis_panen`
--
ALTER TABLE `jenis_panen`
  MODIFY `id_jenis_panen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `peringkat_potensi`
--
ALTER TABLE `peringkat_potensi`
  MODIFY `id_peringkat` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peringkat_potensi`
--
ALTER TABLE `peringkat_potensi`
  ADD CONSTRAINT `peringkat_potensi_ibfk_1` FOREIGN KEY (`id_daerah`) REFERENCES `data_daerah` (`id_daerah`),
  ADD CONSTRAINT `peringkat_potensi_ibfk_2` FOREIGN KEY (`id_jenis_panen`) REFERENCES `jenis_panen` (`id_jenis_panen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
