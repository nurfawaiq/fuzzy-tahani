-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 12, 2022 at 08:45 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tahani`
--

-- --------------------------------------------------------

--
-- Table structure for table `buah`
--

CREATE TABLE `buah` (
  `id` int(5) NOT NULL,
  `nama` varchar(10) NOT NULL,
  `vitamin` varchar(20) NOT NULL,
  `masatanam` varchar(10) NOT NULL,
  `harga` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buah`
--

INSERT INTO `buah` (`id`, `nama`, `vitamin`, `masatanam`, `harga`) VALUES
(1, 'Blimbing', '46 mg/100 g', '5 Tahun', '15000'),
(2, 'Blackcurre', '120 mg/68 g', '1 Tahun', '40000'),
(3, 'Jambu Biji', '120 mg/60 g', '3 Tahun', '7000'),
(4, 'Jeruk', '69 mg/100 g', '3 Tahun', '15000'),
(5, 'Leci', '112 mg/100 g', '3 Tahun', '25000'),
(6, 'Markisa', '72 mg/100 g', '5 Tahun', '20000'),
(7, 'Kiwi', '62 mg/100 g', '4 Tahun', '45000'),
(8, 'Mangga', '58 mg/100 g', '10 Tahun', '20000'),
(9, 'Pisang', '93 mg/1 buah pisang ', '1 Tahun', '30000'),
(10, 'Strawbery', '83 mg/100 g', '1 Tahun', '30000');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

CREATE TABLE `kelompok` (
  `id` int(5) NOT NULL,
  `nama_kelompok` varchar(20) NOT NULL,
  `akses` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelompok`
--

INSERT INTO `kelompok` (`id`, `nama_kelompok`, `akses`) VALUES
(1, 'Vitamin', 'vitamin'),
(2, 'Masa tanam', 'masatanam'),
(3, 'Harga', 'harga');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(10) NOT NULL,
  `nama_kriteria` varchar(30) NOT NULL,
  `bawah` float(10,2) NOT NULL,
  `tengah` float(10,2) NOT NULL,
  `atas` float(10,2) NOT NULL,
  `kelompok` tinyint(2) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama_kriteria`, `bawah`, `tengah`, `atas`, `kelompok`, `keterangan`) VALUES
(1, 'rendah', 0.00, 30.00, 60.00, 1, ''),
(2, 'sedang', 50.00, 90.00, 110.00, 1, ''),
(3, 'tinggi', 100.00, 130.00, 150.00, 1, ''),
(4, 'pendek', 0.00, 2.00, 5.00, 2, ''),
(5, 'panjang', 3.00, 8.00, 12.00, 2, ''),
(6, 'murah', 0.00, 7000.00, 12000.00, 3, ''),
(7, 'sedang', 10000.00, 20000.00, 25000.00, 3, ''),
(8, 'mahal', 23000.00, 35000.00, 50000.00, 3, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buah`
--
ALTER TABLE `buah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buah`
--
ALTER TABLE `buah`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kelompok`
--
ALTER TABLE `kelompok`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
