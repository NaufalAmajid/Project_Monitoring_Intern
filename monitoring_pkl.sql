-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 05:12 PM
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
(1, '2024-06-04', '21:51:39', '00:00:00', '1_20240604215139-masuk.jpg', 0, 1, '');

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
(1, '09231892132', 'Natsu Dragnel', 'Laki-laki', 2);

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
  `tempat_pkl` varchar(100) NOT NULL,
  `nilai` int(11) NOT NULL,
  `selesai_pkl` int(11) NOT NULL DEFAULT 0,
  `laporan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_siswa`
--

INSERT INTO `detail_siswa` (`siswa_id`, `nama_lengkap`, `no`, `nis`, `jenis_kelamin`, `user_id`, `kelas_id`, `tempat_pkl`, `nilai`, `selesai_pkl`, `laporan`) VALUES
(1, 'Kirigaya Kazuto', '08734213123', '00043523434', 'Laki-laki', 3, 1, 'Gayam', 86, 0, NULL);

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
(9, 'ME03', 3),
(10, 'ME08', 3);

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
(1, 'RPL', 1);

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
(1, 'II-C', 1, 1, 1);

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

--
-- Dumping data for table `logbook`
--

INSERT INTO `logbook` (`logbook_id`, `catatan`, `lampiran`, `created_at`, `is_verified`, `siswa_id`) VALUES
(1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1_20240604220827.jpg', '2024-06-04 22:08:27', 0, 1);

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
('ME07', 'daftar siswa', 'daftar_siswa'),
('ME08', 'laporan', 'laporan');

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
('SUB07', 'logbook', 'logbook', 'ME04'),
('SUB08', 'laporan absensi', 'laporan_absensi', 'ME08'),
('SUB09', 'laporan logbook', 'laporan_logbook', 'ME08'),
('SUB10', 'laporan pkl', 'laporan_pkl', 'ME08');

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
(1, 'admin', '202cb962ac59075b964b07152d234b70', 1, 'admin@admin.com', 1),
(2, 'natsu', '202cb962ac59075b964b07152d234b70', 2, 'natsu@gmail.com', 1),
(3, 'kirito', '202cb962ac59075b964b07152d234b70', 3, 'kirito@gmail.com', 1);

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
  MODIFY `absensi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  MODIFY `pembimbing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_siswa`
--
ALTER TABLE `detail_siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `jurusan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `logbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_user`
--
ALTER TABLE `status_user`
  MODIFY `status_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
