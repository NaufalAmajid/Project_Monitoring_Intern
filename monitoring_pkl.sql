-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 03:23 AM
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
-- Database: `monitoring_pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `absensi_id` int(11) NOT NULL,
  `hari` date NOT NULL,
  `masuk` time NOT NULL,
  `keluar` time NOT NULL,
  `lampiran_masuk` text NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `siswa_id` int(11) NOT NULL,
  `lampiran_keluar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`absensi_id`, `hari`, `masuk`, `keluar`, `lampiran_masuk`, `is_verified`, `siswa_id`, `lampiran_keluar`) VALUES
(1, '2024-05-27', '19:52:55', '20:24:56', '3_20240528195255-masuk.png', 1, 3, '3_20240528202456-keluar.jpeg'),
(2, '2024-05-28', '20:25:49', '20:55:12', '3_20240528202549-masuk.jpeg', 0, 3, '3_20240528205512-keluar.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembimbing`
--

CREATE TABLE `detail_pembimbing` (
  `pembimbing_id` int(11) NOT NULL,
  `no` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pembimbing`
--

INSERT INTO `detail_pembimbing` (`pembimbing_id`, `no`, `nama_lengkap`, `jenis_kelamin`, `user_id`) VALUES
(1, '628123923413', 'Demon One Valorant Player', 'Perempuan', 2),
(2, '6287230012332', 'X-Drake Marine', 'Perempuan', 6);

-- --------------------------------------------------------

--
-- Table structure for table `detail_siswa`
--

CREATE TABLE `detail_siswa` (
  `siswa_id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no` varchar(20) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `user_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `tempat_pkl` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_siswa`
--

INSERT INTO `detail_siswa` (`siswa_id`, `nama_lengkap`, `no`, `nis`, `jenis_kelamin`, `user_id`, `kelas_id`, `tempat_pkl`) VALUES
(1, 'Forsaken Player Valorant', '62812443523', '000123432', 'Laki-laki', 3, 1, 'shanghai'),
(2, 'Aspas Valorant', '6287230323245', '00043523434', 'Laki-laki', 4, 1, 'Solo'),
(3, 'Kanroji Slayer', '62845623434', '000432123', 'Perempuan', 5, 2, 'Sukoharjo'),
(5, 'D\'Art Nanzy', '08734213123', '00043523434', 'Laki-laki', 12, 7, 'Gayam');

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses_menu`
--

CREATE TABLE `hak_akses_menu` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(10) NOT NULL,
  `status_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hak_akses_menu`
--

INSERT INTO `hak_akses_menu` (`id`, `menu_id`, `status_user_id`) VALUES
(1, 'ME01', 1),
(3, 'ME03', 1),
(4, 'ME04', 2),
(5, 'ME03', 2),
(6, 'ME07', 2),
(7, 'ME05', 3),
(8, 'ME06', 3),
(9, 'ME03', 3);

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `jurusan_id` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`jurusan_id`, `nama_jurusan`, `is_active`) VALUES
(1, 'Teknik Komputer Jaringan', 0),
(2, 'Rekayasa Perangkat Lunak', 1),
(3, 'Multimedia', 1),
(4, 'Teknik Elektro', 1),
(5, 'RPL', 1),
(6, 'Perhotelan', 1),
(7, 'My Test', 1),
(8, 'Classroom Of The Elite', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `kelas_id` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `jurusan_id` int(11) NOT NULL,
  `pembimbing_id` int(11) NOT NULL,
  `is_active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`kelas_id`, `nama_kelas`, `jurusan_id`, `pembimbing_id`, `is_active`) VALUES
(1, 'II-A', 2, 1, 1),
(2, 'II-B', 2, 1, 1),
(4, 'II-A', 1, 2, 0),
(5, 'II-C', 1, 1, 0),
(6, 'III-C', 3, 1, 1),
(7, 'III-B', 4, 2, 1),
(8, 'III-A', 2, 2, 1),
(9, 'III-A', 3, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `logbook`
--

CREATE TABLE `logbook` (
  `logbook_id` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `lampiran` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_verified` tinyint(1) NOT NULL,
  `siswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` varchar(10) NOT NULL,
  `nama_menu` varchar(20) NOT NULL,
  `direktori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `nama_menu`, `direktori`) VALUES
('ME01', 'master', 'master'),
('ME03', 'profil', 'profil'),
('ME04', 'riwayat', 'riwayat'),
('ME05', 'absensi', 'absensi'),
('ME06', 'logbook', 'logbook'),
('ME07', 'daftar siswa', 'daftar_siswa');

-- --------------------------------------------------------

--
-- Table structure for table `status_user`
--

CREATE TABLE `status_user` (
  `status_user_id` int(11) NOT NULL,
  `nama_status_user` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_user`
--

INSERT INTO `status_user` (`status_user_id`, `nama_status_user`) VALUES
(1, 'admin'),
(2, 'pembimbing'),
(3, 'siswa');

-- --------------------------------------------------------

--
-- Table structure for table `submenu`
--

CREATE TABLE `submenu` (
  `submenu_id` varchar(10) NOT NULL,
  `nama_submenu` varchar(20) NOT NULL,
  `direktori` varchar(50) NOT NULL,
  `menu_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submenu`
--

INSERT INTO `submenu` (`submenu_id`, `nama_submenu`, `direktori`, `menu_id`) VALUES
('SUB02', 'jurusan & kelas', 'jurusan_kelas', 'ME01'),
('SUB03', 'pembimbing', 'pembimbing', 'ME01'),
('SUB04', 'siswa', 'siswa', 'ME01'),
('SUB06', 'absensi', 'absensi', 'ME04'),
('SUB07', 'logbook', 'logbook', 'ME04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `status_user_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `status_user_id`, `email`, `is_active`) VALUES
(1, 'dragnel', '250cf8b51c773f3f8dc8b4be867a9a02', 1, 'dragnel@gmail.com', 1),
(2, 'demonone', '202cb962ac59075b964b07152d234b70', 2, 'demonone@gmail.com', 1),
(3, 'forsaken', '202cb962ac59075b964b07152d234b70', 3, 'forsaken@gmail.com', 1),
(4, 'aspas', '202cb962ac59075b964b07152d234b70', 3, 'aspas@gmail.com', 1),
(5, 'slayer', '202cb962ac59075b964b07152d234b70', 3, 'slayer@gmail.com', 1),
(6, 'xdrake', '202cb962ac59075b964b07152d234b70', 2, 'xdrakemarine@gmail.com', 1),
(12, 'nanzy', '250cf8b51c773f3f8dc8b4be867a9a02', 3, 'nanzy@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`absensi_id`),
  ADD KEY `fk_abs_siswa` (`siswa_id`);

--
-- Indexes for table `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  ADD PRIMARY KEY (`pembimbing_id`),
  ADD KEY `fk_dp_user` (`user_id`);

--
-- Indexes for table `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD PRIMARY KEY (`siswa_id`),
  ADD KEY `fk_ds_user` (`user_id`),
  ADD KEY `fk_ds_kelas` (`kelas_id`);

--
-- Indexes for table `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ham_menu` (`menu_id`),
  ADD KEY `fk_ham_status_user` (`status_user_id`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`jurusan_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelas_id`),
  ADD KEY `fk_kel_jurusan` (`jurusan_id`),
  ADD KEY `fk_kel_pembimbing` (`pembimbing_id`);

--
-- Indexes for table `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`logbook_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `status_user`
--
ALTER TABLE `status_user`
  ADD PRIMARY KEY (`status_user_id`);

--
-- Indexes for table `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`submenu_id`),
  ADD KEY `fk_menu` (`menu_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_status_user` (`status_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `absensi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  MODIFY `pembimbing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detail_siswa`
--
ALTER TABLE `detail_siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `jurusan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `logbook_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_user`
--
ALTER TABLE `status_user`
  MODIFY `status_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_abs_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `detail_siswa` (`siswa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  ADD CONSTRAINT `fk_dp_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD CONSTRAINT `fk_ds_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ds_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  ADD CONSTRAINT `fk_ham_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ham_status_user` FOREIGN KEY (`status_user_id`) REFERENCES `status_user` (`status_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `fk_kel_jurusan` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`jurusan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kel_pembimbing` FOREIGN KEY (`pembimbing_id`) REFERENCES `detail_pembimbing` (`pembimbing_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_status_user` FOREIGN KEY (`status_user_id`) REFERENCES `status_user` (`status_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
