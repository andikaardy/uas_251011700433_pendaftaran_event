-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2026 at 04:57 PM
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
-- Database: `db_uas_251011700433`
--

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_event`
--

CREATE TABLE `pendaftaran_event` (
  `id` bigint(20) NOT NULL,
  `nama_peserta` varchar(100) NOT NULL,
  `nama_event` varchar(100) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `file_bukti` varchar(255) NOT NULL,
  `status` enum('Pending','Dikonfirmasi') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran_event`
--

INSERT INTO `pendaftaran_event` (`id`, `nama_peserta`, `nama_event`, `tanggal_daftar`, `file_bukti`, `status`) VALUES
(251011700433, 'Andika Ardiyansah', 'Seminar SOC Analis', '2026-07-02', '../uploads/6a4645e929ebf.jpg', 'Dikonfirmasi'),
(251011700434, 'Akagami', 'Seminar WEB Devloper', '2026-07-02', '../uploads/6a4647cf0f9bf.jpg', 'Pending'),
(251011700501, 'Sengoku', 'Seminar Robotik', '2026-07-02', '../uploads/6a4648024923b.jpeg', 'Pending'),
(251011700513, 'Garp', 'Seminar AI', '2026-07-02', '../uploads/6a464822dffb6.jpeg', 'Pending'),
(251011700555, 'Usopp', 'Seminar WEB Devloper', '2026-07-02', '../uploads/6a46485172165.jpg', 'Dikonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `password`) VALUES
(1, 'Andika Ardiyansah', 'andikaardy_', '$2y$10$hsNRl4clRSMOFLZCZUUSBuA6NR1GIy7xpTFR16pM9McafaUxuD9x2'),
(2, 'andika', 'andika', '$2y$10$q872A0d.jrL2f14ZkMrCGOh24Pq9uXnkF7A0eymoL7iW7dTtdEVyC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pendaftaran_event`
--
ALTER TABLE `pendaftaran_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
