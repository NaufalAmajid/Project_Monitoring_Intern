-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Bulan Mei 2024 pada 09.09
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `absensi`
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
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`absensi_id`, `hari`, `masuk`, `keluar`, `lampiran_masuk`, `is_verified`, `siswa_id`, `lampiran_keluar`) VALUES
(1, '2024-05-27', '19:52:55', '20:24:56', '3_20240528195255-masuk.png', 1, 3, '3_20240528202456-keluar.jpeg'),
(2, '2024-05-28', '20:25:49', '20:55:12', '3_20240528202549-masuk.jpeg', 0, 3, '3_20240528205512-keluar.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pembimbing`
--

CREATE TABLE `detail_pembimbing` (
  `pembimbing_id` int(11) NOT NULL,
  `no` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pembimbing`
--

INSERT INTO `detail_pembimbing` (`pembimbing_id`, `no`, `nama_lengkap`, `jenis_kelamin`, `user_id`) VALUES
(1, '628123923413', 'Demon One Valorant Player', 'Perempuan', 2),
(2, '6287230012332', 'X-Drake Marine', 'Perempuan', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_siswa`
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
-- Dumping data untuk tabel `detail_siswa`
--

INSERT INTO `detail_siswa` (`siswa_id`, `nama_lengkap`, `no`, `nis`, `jenis_kelamin`, `user_id`, `kelas_id`, `tempat_pkl`) VALUES
(1, 'Forsaken Player Valorant', '62812443523', '000123432', 'Laki-laki', 3, 1, 'shanghai'),
(2, 'Aspas Valorant', '6287230323245', '00043523434', 'Laki-laki', 4, 1, 'Solo'),
(3, 'Kanroji Slayer', '62845623434', '000432123', 'Perempuan', 5, 2, 'Sukoharjo'),
(5, 'D\'Art Nanzy', '08734213123', '00043523434', 'Laki-laki', 12, 7, 'Gayam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hak_akses_menu`
--

CREATE TABLE `hak_akses_menu` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(10) NOT NULL,
  `status_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hak_akses_menu`
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
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `jurusan_id` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
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
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kelas_id` int(11) NOT NULL,
  `nama_kelas` varchar(10) NOT NULL,
  `jurusan_id` int(11) NOT NULL,
  `pembimbing_id` int(11) NOT NULL,
  `is_active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
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
-- Struktur dari tabel `logbook`
--

CREATE TABLE `logbook` (
  `logbook_id` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `lampiran` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `siswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `logbook`
--

INSERT INTO `logbook` (`logbook_id`, `catatan`, `lampiran`, `created_at`, `is_verified`, `siswa_id`) VALUES
(1, 'test 123', '1_20240531080059.png', '2024-05-30 08:00:59', 1, 1),
(2, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1_20240531101321.png', '2024-05-29 10:13:21', 0, 1),
(3, 'Cras eleifend vel tortor non eleifend. Proin massa lacus, fringilla eget dictum in, faucibus convallis eros. Phasellus justo est, maximus iaculis efficitur nec, fermentum et dolor. Nunc dapibus augue sed tristique pellentesque. Quisque sapien erat, bibendum in purus in, blandit auctor augue. Phasellus gravida at augue nec rutrum. Integer eros nunc, fringilla nec libero non, lacinia maximus ex. Duis vehicula gravida massa id rhoncus. Cras leo nisl, molestie eu tristique id, vulputate sit amet ante. Curabitur sagittis varius est, in viverra ligula rutrum in. Aliquam erat volutpat. Mauris tempus ex mauris, et condimentum erat imperdiet ac. Sed gravida non diam faucibus luctus.', '1_20240531125157.png', '2024-05-28 12:51:57', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `menu_id` varchar(10) NOT NULL,
  `nama_menu` varchar(20) NOT NULL,
  `direktori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
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
-- Struktur dari tabel `status_user`
--

CREATE TABLE `status_user` (
  `status_user_id` int(11) NOT NULL,
  `nama_status_user` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `status_user`
--

INSERT INTO `status_user` (`status_user_id`, `nama_status_user`) VALUES
(1, 'admin'),
(2, 'pembimbing'),
(3, 'siswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `submenu`
--

CREATE TABLE `submenu` (
  `submenu_id` varchar(10) NOT NULL,
  `nama_submenu` varchar(20) NOT NULL,
  `direktori` varchar(50) NOT NULL,
  `menu_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `submenu`
--

INSERT INTO `submenu` (`submenu_id`, `nama_submenu`, `direktori`, `menu_id`) VALUES
('SUB02', 'jurusan & kelas', 'jurusan_kelas', 'ME01'),
('SUB03', 'pembimbing', 'pembimbing', 'ME01'),
('SUB04', 'siswa', 'siswa', 'ME01'),
('SUB06', 'absensi', 'absensi', 'ME04'),
('SUB07', 'logbook', 'logbook', 'ME04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
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
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`absensi_id`),
  ADD KEY `fk_abs_siswa` (`siswa_id`);

--
-- Indeks untuk tabel `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  ADD PRIMARY KEY (`pembimbing_id`),
  ADD KEY `fk_dp_user` (`user_id`);

--
-- Indeks untuk tabel `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD PRIMARY KEY (`siswa_id`),
  ADD KEY `fk_ds_user` (`user_id`),
  ADD KEY `fk_ds_kelas` (`kelas_id`);

--
-- Indeks untuk tabel `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ham_menu` (`menu_id`),
  ADD KEY `fk_ham_status_user` (`status_user_id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`jurusan_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelas_id`),
  ADD KEY `fk_kel_jurusan` (`jurusan_id`),
  ADD KEY `fk_kel_pembimbing` (`pembimbing_id`);

--
-- Indeks untuk tabel `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`logbook_id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indeks untuk tabel `status_user`
--
ALTER TABLE `status_user`
  ADD PRIMARY KEY (`status_user_id`);

--
-- Indeks untuk tabel `submenu`
--
ALTER TABLE `submenu`
  ADD PRIMARY KEY (`submenu_id`),
  ADD KEY `fk_menu` (`menu_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_status_user` (`status_user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `absensi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  MODIFY `pembimbing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail_siswa`
--
ALTER TABLE `detail_siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `jurusan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `logbook`
--
ALTER TABLE `logbook`
  MODIFY `logbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `status_user`
--
ALTER TABLE `status_user`
  MODIFY `status_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_abs_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `detail_siswa` (`siswa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  ADD CONSTRAINT `fk_dp_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD CONSTRAINT `fk_ds_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ds_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  ADD CONSTRAINT `fk_ham_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ham_status_user` FOREIGN KEY (`status_user_id`) REFERENCES `status_user` (`status_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `fk_kel_jurusan` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`jurusan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kel_pembimbing` FOREIGN KEY (`pembimbing_id`) REFERENCES `detail_pembimbing` (`pembimbing_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `submenu`
--
ALTER TABLE `submenu`
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_status_user` FOREIGN KEY (`status_user_id`) REFERENCES `status_user` (`status_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
