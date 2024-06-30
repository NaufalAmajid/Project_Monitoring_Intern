-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: my_db
-- Waktu pembuatan: 30 Jun 2024 pada 07.42
-- Versi server: 11.4.2-MariaDB-ubu2404
-- Versi PHP: 8.2.8

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`absensi_id`, `hari`, `masuk`, `keluar`, `lampiran_masuk`, `is_verified`, `siswa_id`, `lampiran_keluar`) VALUES
(1, '2024-06-04', '21:51:39', '00:00:00', '1_20240604215139-masuk.jpg', 0, 1, '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pembimbing`
--

INSERT INTO `detail_pembimbing` (`pembimbing_id`, `no`, `nama_lengkap`, `jenis_kelamin`, `user_id`) VALUES
(1, '09231892132', 'Natsu Dragnel', 'Laki-laki', 2);

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
  `tempat_pkl` varchar(100) NOT NULL,
  `pimpinan_pkl` varchar(100) NOT NULL,
  `nilai` int(11) NOT NULL,
  `selesai_pkl` int(11) NOT NULL DEFAULT 0,
  `laporan` text DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `verif_laporan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_siswa`
--

INSERT INTO `detail_siswa` (`siswa_id`, `nama_lengkap`, `no`, `nis`, `jenis_kelamin`, `user_id`, `kelas_id`, `tempat_pkl`, `pimpinan_pkl`, `nilai`, `selesai_pkl`, `laporan`, `komentar`, `verif_laporan`) VALUES
(1, 'Kirigaya Kazuto', '08734213123', '00043523434', 'Laki-laki', 3, 1, 'Gayam', 'Adi Saputra', 79, 1, NULL, 'Untuk membuat elemen legend dengan Bootstrap 4, Anda bisa menggunakan kelas-kelas yang disediakan oleh Bootstrap untuk mengatur tampilan elemen tersebut. Berikut adalah langkah-langkah dan contoh kode untuk membuat elemen legend yang terintegrasi dengan baik ', 0),
(2, 'obito uchiha', '0823134234', '00043523434', 'Laki-laki', 4, 1, 'Boyolali', 'Madara', 0, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hak_akses_menu`
--

CREATE TABLE `hak_akses_menu` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(10) NOT NULL,
  `status_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(9, 'ME03', 3),
(10, 'ME08', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `jurusan_id` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`jurusan_id`, `nama_jurusan`, `is_active`) VALUES
(1, 'RPL', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kelas_id`, `nama_kelas`, `jurusan_id`, `pembimbing_id`, `is_active`) VALUES
(1, 'II-C', 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `logbook`
--

CREATE TABLE `logbook` (
  `logbook_id` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `lampiran` text NOT NULL,
  `komentar` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_verified` tinyint(1) DEFAULT NULL,
  `siswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `logbook`
--

INSERT INTO `logbook` (`logbook_id`, `catatan`, `lampiran`, `komentar`, `created_at`, `is_verified`, `siswa_id`) VALUES
(1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1_20240604220827.jpg', NULL, '2024-06-04 22:08:27', 0, 1),
(4, 'Aenean molestie massa at orci pulvinar, sed sodales ex lobortis. Donec fringilla mollis aliquam.', '[\"1_20240624201925_0.jpg\",\"1_20240624201925_1.jpg\"]', NULL, '2024-06-24 20:19:42', 1, 1),
(5, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '[\"1_20240630130519_1.png\",\"1_20240630130540_0.png\"]', 'Untuk membuat elemen legend dengan Bootstrap 4, Anda bisa menggunakan kelas-kelas yang disediakan oleh Bootstrap untuk mengatur tampilan elemen tersebut. Berikut adalah langkah-langkah dan contoh kode untuk membuat elemen legend yang terintegrasi dengan baik ', '2024-06-30 13:05:40', NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `menu_id` varchar(10) NOT NULL,
  `nama_menu` varchar(20) NOT NULL,
  `direktori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`menu_id`, `nama_menu`, `direktori`) VALUES
('ME01', 'master', 'master'),
('ME03', 'profil', 'profil'),
('ME04', 'riwayat', 'riwayat'),
('ME05', 'absensi', 'absensi'),
('ME06', 'logbook', 'logbook'),
('ME07', 'daftar siswa', 'daftar_siswa'),
('ME08', 'laporan pkl', 'laporan_pkl');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_user`
--

CREATE TABLE `status_user` (
  `status_user_id` int(11) NOT NULL,
  `nama_status_user` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `status_user_id`, `email`, `is_active`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 1, 'admin@admin.com', 1),
(2, 'natsu', '202cb962ac59075b964b07152d234b70', 2, 'natsu@gmail.com', 1),
(3, 'kirito', '202cb962ac59075b964b07152d234b70', 3, 'kirito@gmail.com', 1),
(4, 'tobi', '202cb962ac59075b964b07152d234b70', 3, 'obitouchiha@gmail.com', 1);

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
  MODIFY `absensi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `detail_pembimbing`
--
ALTER TABLE `detail_pembimbing`
  MODIFY `pembimbing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `detail_siswa`
--
ALTER TABLE `detail_siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `hak_akses_menu`
--
ALTER TABLE `hak_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `jurusan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `logbook`
--
ALTER TABLE `logbook`
  MODIFY `logbook_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `status_user`
--
ALTER TABLE `status_user`
  MODIFY `status_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
