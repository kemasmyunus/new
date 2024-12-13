-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Nov 2024 pada 15.22
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
-- Database: `administrasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `tjabatan` varchar(255) NOT NULL,
  `golongan` varchar(255) NOT NULL,
  `masa` varchar(250) NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `dik` varchar(255) NOT NULL,
  `diklat` varchar(255) NOT NULL,
  `point` varchar(11) DEFAULT NULL,
  `hadir` int(11) DEFAULT 0,
  `izin` int(11) DEFAULT 0,
  `sakit` int(11) DEFAULT 0,
  `jk` enum('Laki-laki','Perempuan') DEFAULT 'Laki-laki',
  `alpha` int(255) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `nip`, `jabatan`, `tjabatan`, `golongan`, `masa`, `pendidikan`, `dik`, `diklat`, `point`, `hadir`, `izin`, `sakit`, `jk`, `alpha`) VALUES
(1, 'FARID RIDHONY, S.SOS, M', '197503132008011021', 'Lurah', '2016-12-31', 'Penata Tingkat I III/d', '2024-09-01', 'S2', 'Tingkat IV', '-', '800', 1, 2, 0, 'Laki-laki', 0),
(2, 'DONY SETIADI, SE', '198010252005011015', 'Kepala Seksi Ketentraman dan Ketertiban Umum', '2022-06-10', 'Penata Tingkat I III/d', '2024-09-01', 'S1', '-', '-', '1000', 3, 0, 0, 'Laki-laki', 0),
(3, 'KATERINA YULIANTI, SE', '197903282010012010', 'Kepala Seksi Pemerintahan dan Kemasyarakatan', '2022-04-01', 'Penata Muda Tingkat I III/d', '2024-09-01', 'S1', '-', '-', '800', 3, 0, 0, 'Perempuan', 0),
(4, 'RAHAYU MAULIDA, A.MD', '198611172010012011', 'Sekretaris', '2021-10-01', 'Penata Muda Tingkat I III/d', '2024-09-01', 'D III', '-', '-', '1000', 3, 0, 0, 'Perempuan', 0),
(5, 'RIZKA NUR AMALIA, S.AB', '198909182010012001', 'Kepala Seksi Ekonomi dan Pembangunan', '2022-04-22', 'Penata Muda Tingkat I III/d', '2024-09-01', 'S1', '-', '-', '1000', 3, 0, 0, 'Perempuan', 0),
(6, 'ASYIAH', '196909022014062001', 'Pengadministrasi Pertanahan', '2014-06-01', 'Penata Muda Tingkat I III/d', '2024-09-01', 'STLA', '-', '-', '1000', 3, 0, 0, 'Perempuan', 0);

--
-- Trigger `pegawai`
--
DELIMITER $$
CREATE TRIGGER `before_pegawai_delete` BEFORE DELETE ON `pegawai` FOR EACH ROW BEGIN
    DELETE FROM presensi_pegawai WHERE id_pegawai = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pejabat_desa`
--

CREATE TABLE `pejabat_desa` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(225) NOT NULL,
  `ttd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pejabat_desa`
--

INSERT INTO `pejabat_desa` (`id`, `nama`, `jabatan`, `ttd`) VALUES
(4, 'FARID RIDHONY, S.SOS, M', 'Lurah', ''),
(6, 'DONY SETIADI, SE', 'Kepala Seksi Ketentraman dan Ketertiban Umum', ''),
(7, 'KATERINA YULIANTI, SE', 'Kepala Seksi Pemerintahan dan Kemasyarakatan', ''),
(8, 'RAHAYU MAULIDA, A.MD', 'Sekretaris', ''),
(9, 'RIZKA NUR AMALIA, S.AB', 'Kepala Seksi Ekonomi dan Pembangunan', ''),
(10, 'ASYIAH', 'Pengadministrasi Pertanahan', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penduduk`
--

CREATE TABLE `penduduk` (
  `id` int(11) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl` varchar(255) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `agama` text NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `warga` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penduduk`
--

INSERT INTO `penduduk` (`id`, `nik`, `nama`, `tgl`, `jk`, `agama`, `alamat`, `no_hp`, `user_id`, `pekerjaan`, `warga`) VALUES
(21, '1000000017100000', 'I Kadek Agus Diana Putra', 'Kerta Buwana, 26 Agustus 2000', 'Laki-laki', 'Hindu', 'Jl. Sungai Jingah RT. 4 RW. 2', '081725672371', 34, 'Mahasiswa', 'WNI'),
(22, '1000000001100000', 'Dwi Ajeng Anindia', 'Banjarmasin, 15 Januari 1990', 'Perempuan', 'Islam', 'Jl. Sungai Jingah RT 1. RW. 2', '082156782912', 43, 'Guru', 'WNI'),
(23, '1000000013100000', 'Ni Putu Sutia Andryani', 'Banjarbaru, 25 Januari 2002', 'Perempuan', 'Hindu', 'Jl, Sungai Jingah RT. 5 RW.2', '081725672371', 44, 'Mahasiswa', 'WNI'),
(24, '1000000002100000', 'Erawati', 'Banjarmasin, 15 Januari 1990', 'Perempuan', 'Islam', 'Jl. Sungai Jingah RT. 8 RW 2', '123124123124124', 45, 'Dokter', 'WNI'),
(25, '1000000023100000', 'Rendi', 'Banjarmasin, 08 Maret 2001', 'Laki-laki', 'Islam', 'Jl. Sungai Jingah RT. 6 RW. 1', '081725672371', 46, 'Mahasiswa', 'WNI'),
(29, '1234567890987654321', 'Ernawati', 'Banjarmasin, 20 Mei 1992', 'Perempuan', 'Islam', 'sebamban', '08123456789098', 48, 'Mahasiswa', 'WNI'),
(31, '0987654321123567', 'erfan', 'Banjarmasin, 20 Mei 1992', 'Laki-laki', 'Islam', 'jl.sungai miai', '0821307838943', 50, 'Dosen', 'WNI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `ttd` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi_pegawai`
--

CREATE TABLE `presensi_pegawai` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `presensi` enum('Hadir','Sakit','Izin','Alpha') DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi_pegawai`
--

INSERT INTO `presensi_pegawai` (`id`, `id_pegawai`, `presensi`, `tanggal`) VALUES
(124, 1, 'Hadir', '2024-08-22'),
(125, 2, 'Hadir', '2024-08-22'),
(126, 3, 'Hadir', '2024-08-22'),
(127, 4, 'Hadir', '2024-08-22'),
(128, 5, 'Hadir', '2024-08-22'),
(129, 6, 'Hadir', '2024-08-22'),
(130, 1, 'Izin', '2024-08-26'),
(131, 2, 'Hadir', '2024-08-26'),
(132, 3, 'Hadir', '2024-08-26'),
(133, 4, 'Hadir', '2024-08-26'),
(134, 5, 'Hadir', '2024-08-26'),
(135, 6, 'Hadir', '2024-08-26'),
(136, 1, 'Izin', '2024-08-25'),
(137, 2, 'Hadir', '2024-08-25'),
(138, 3, 'Hadir', '2024-08-25'),
(139, 4, 'Hadir', '2024-08-25'),
(140, 5, 'Hadir', '2024-08-25'),
(141, 6, 'Hadir', '2024-08-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_desa`
--

CREATE TABLE `profil_desa` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_desa`
--

INSERT INTO `profil_desa` (`id`, `nama`, `alamat`, `kecamatan`, `kota`) VALUES
(3, 'Surgi Mufti', 'Jalan Jahri Saleh, RT.19, Surgi Mufti', 'Banjarmasin Utara', 'Banjarmasin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sk`
--

CREATE TABLE `sk` (
  `id` int(11) NOT NULL,
  `no_sk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `warga` enum('WNI','WNA') NOT NULL,
  `keperluan` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sk`
--

INSERT INTO `sk` (`id`, `no_sk`, `id_user`, `jk`, `tgl_lahir`, `agama`, `pekerjaan`, `nik`, `alamat`, `warga`, `keperluan`, `status`, `file`, `tanggal_dibuat`) VALUES
(14, 1, 43, 'Perempuan', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Guru', '1000000001100000', 'Jl. Sungai Jingah RT 1. RW. 2', 'WNI', 'Melamar Pekerjaan', 'Menunggu', NULL, '2024-08-22 13:58:26'),
(15, 2, 34, 'Laki-laki', 'Kerta Buwana, 26 Agustus 2000', 'Islam', 'Mahasiswa', '1000000017100000', 'Jl. Sungai Jingah RT. 4 RW. 2', 'WNI', 'Melamar Pekerjaan', 'Menunggu', NULL, '2024-08-22 13:59:00'),
(16, 3, 44, 'Perempuan', 'Banjarbaru, 25 Januari 2002', 'Hindu', 'Mahasiswa', '1000000013100000', 'Jl, Sungai Jingah RT. 5 RW.2', 'WNI', 'Melamar Pekerjaan', 'Menunggu', NULL, '2024-08-22 13:59:46'),
(17, 4, 45, 'Perempuan', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Dokter', '1000000002100000', 'Jl. Sungai Jingah RT. 8 RW 2', 'WNI', 'Melamar Pekerjaan', 'Menunggu', NULL, '2024-08-22 14:05:24'),
(18, 5, 46, 'Laki-laki', 'Banjarmasin, 08 Maret 2001', 'Islam', 'Mahasiswa', '1000000023100000', 'Jl. Sungai Jingah RT. 6 RW. 1', 'WNI', 'Melamar Pekerjaan', 'Menunggu', NULL, '2024-08-22 14:09:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skbb`
--

CREATE TABLE `skbb` (
  `id` int(11) NOT NULL,
  `no_skbb` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `warga` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skbb`
--

INSERT INTO `skbb` (`id`, `no_skbb`, `id_user`, `jk`, `keperluan`, `tgl_lahir`, `agama`, `pekerjaan`, `nik`, `alamat`, `warga`, `status`, `file`, `tanggal_dibuat`) VALUES
(7, 1, 34, 'Laki-laki', 'Melamar Pekerjaan', 'Kerta Buwana, 26 Agustus 2000', 'Hindu', 'Mahasiswa', '1000000017100000', 'Jl. Sungai Jingah RT. 4 RW. 2', 'WNI', 'Menuggu', NULL, '2024-08-22 13:42:47'),
(8, 2, 43, 'Perempuan', 'Melamar Pekerjaan', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Guru', '1000000001100000', 'Jl. Sungai Jingah RT 1. RW. 2', 'WNI', 'Menuggu', NULL, '2024-08-22 13:53:01'),
(9, 3, 44, 'Perempuan', 'Melamar Pekerjaan', 'Banjarbaru, 25 Januari 2002', 'Hindu', 'Mahasiswa', '1000000013100000', 'Jl, Sungai Jingah RT. 5 RW.2', 'WNI', 'Menuggu', NULL, '2024-08-22 14:00:58'),
(10, 4, 45, 'Perempuan', 'Melamar Pekerjaan', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Dokter', '1000000002100000', 'Jl. Sungai Jingah RT. 8 RW 2', 'WNI', 'Menuggu', NULL, '2024-08-22 14:05:36'),
(11, 5, 46, 'Laki-laki', 'Melamar Pekerjaan', 'Banjarmasin, 08 Maret 2001', 'Islam', 'Mahasiswa', '1000000023100000', 'Jl. Sungai Jingah RT. 6 RW. 1', 'WNI', 'Menuggu', NULL, '2024-08-22 14:10:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skbm`
--

CREATE TABLE `skbm` (
  `id` int(11) NOT NULL,
  `no_skbm` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `warga` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skbm`
--

INSERT INTO `skbm` (`id`, `no_skbm`, `id_user`, `jk`, `keperluan`, `tgl_lahir`, `agama`, `pekerjaan`, `nik`, `alamat`, `warga`, `status`, `file`, `tanggal_dibuat`) VALUES
(5, 1, 34, 'Laki-laki', 'Melamar Pekerjaan', 'Kerta Buwana, 26 Agustus 2000', 'Hindu', 'Mahasiswa', '1000000017100000', 'Jl. Sungai Jingah RT. 4 RW. 2', 'WNI', 'Menunggu', 'SKRIPSI_I Kadek Agus Diana Putra_2010010777.jpg', '2024-08-22 13:49:20'),
(6, 2, 43, 'Perempuan', 'Melamar Pekerjaan', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Guru', '1000000001100000', 'Jl. Sungai Jingah RT 1. RW. 2', 'WNI', 'Menuggu', NULL, '2024-08-22 13:57:37'),
(7, 3, 44, 'Perempuan', 'Melamar Pekerjaan', 'Banjarbaru, 25 Januari 2002', 'Hindu', 'Mahasiswa', '1000000013100000', 'Jl, Sungai Jingah RT. 5 RW.2', 'WNI', 'Menunggu', 'SKRIPSI_I Kadek Agus Diana Putra_2010010777.jpg', '2024-08-22 14:03:46'),
(8, 4, 45, 'Perempuan', 'Melamar Pekerjaan', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Dokter', '1000000002100000', 'Jl. Sungai Jingah RT. 8 RW 2', 'WNI', 'Menuggu', NULL, '2024-08-22 14:08:16'),
(9, 5, 46, 'Laki-laki', 'Melamar Pekerjaan', 'Banjarmasin, 08 Maret 2001', 'Islam', 'Mahasiswa', '1000000023100000', 'Jl. Sungai Jingah RT. 6 RW. 1', 'WNI', 'Menuggu', NULL, '2024-08-22 14:12:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skbmr`
--

CREATE TABLE `skbmr` (
  `id` int(11) NOT NULL,
  `no_skbmr` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `nik` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skbmr`
--

INSERT INTO `skbmr` (`id`, `no_skbmr`, `id_user`, `jk`, `keperluan`, `tgl_lahir`, `pekerjaan`, `alamat`, `status`, `file`, `nik`, `agama`, `tanggal_dibuat`) VALUES
(5, 1, 34, 'Laki-laki', 'Kredit KPR', 'Kerta Buwana, 26 Agustus 2000', 'Mahasiswa', 'Jl. Sungai Jingah RT. 4 RW. 2', 'Menuggu', NULL, '1000000017100000', 'Islam', '2024-08-22 13:49:33'),
(6, 2, 43, 'Perempuan', 'Kredit KPR', 'Banjarmasin, 15 Januari 1990', 'Guru', 'Jl. Sungai Jingah RT 1. RW. 2', 'Menuggu', NULL, '1000000001100000', 'Islam', '2024-08-22 13:58:12'),
(7, 3, 44, 'Perempuan', 'Kredit KPR', 'Banjarbaru, 25 Januari 2002', 'Mahasiswa', 'Jl, Sungai Jingah RT. 5 RW.2', 'Menuggu', NULL, '1000000013100000', 'Hindu', '2024-08-22 14:04:01'),
(8, 4, 45, 'Perempuan', 'Kredit KPR', 'Banjarmasin, 15 Januari 1990', 'Dokter', 'Jl. Sungai Jingah RT. 8 RW 2', 'Menuggu', NULL, '1000000002100000', 'Islam', '2024-08-22 14:08:29'),
(9, 5, 46, 'Laki-laki', 'Kredit KPR', 'Banjarmasin, 08 Maret 2001', 'Mahasiswa', 'Jl. Sungai Jingah RT. 6 RW. 1', 'Menuggu', NULL, '1000000023100000', 'Islam', '2024-08-22 14:12:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skd`
--

CREATE TABLE `skd` (
  `id` int(11) NOT NULL,
  `no_skd` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `warga` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file` varchar(225) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skd`
--

INSERT INTO `skd` (`id`, `no_skd`, `id_user`, `jk`, `keperluan`, `tgl_lahir`, `agama`, `pekerjaan`, `nik`, `alamat`, `warga`, `status`, `file`, `tanggal_dibuat`) VALUES
(6, 1, 34, 'Laki-laki', 'Membuat KTP', 'Kerta Buwana, 26 Agustus 2000', 'Hindu', 'Mahasiswa', '1000000017100000', 'Jl. Sungai Jingah RT. 4 RW. 2', 'WNI', 'Menunggu', 'SKRIPSI_I Kadek Agus Diana Putra_2010010777.jpg', '2024-08-22 13:43:22'),
(7, 2, 43, 'Perempuan', 'Membuat KTP', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Guru', '1000000001100000', 'Jl. Sungai Jingah RT 1. RW. 2', 'WNI', 'Menunggu', NULL, '2024-08-22 13:53:12'),
(8, 3, 44, 'Perempuan', 'Membuat KTP', 'Banjarbaru, 25 Januari 2002', 'Hindu', 'Mahasiswa', '1000000013100000', 'Jl, Sungai Jingah RT. 5 RW.2', 'WNI', 'Menunggu', NULL, '2024-08-22 14:01:16'),
(9, 4, 45, 'Perempuan', 'Membuat KTP', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Dokter', '1000000002100000', 'Jl. Sungai Jingah RT. 8 RW 2', 'WNI', 'Menunggu', NULL, '2024-08-22 14:05:50'),
(10, 5, 46, 'Laki-laki', 'Membuat KTP', 'Banjarmasin, 08 Maret 2001', 'Islam', 'Mahasiswa', '1000000023100000', 'Jl. Sungai Jingah RT. 6 RW. 1', 'WNI', 'Menunggu', NULL, '2024-08-22 14:10:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skk`
--

CREATE TABLE `skk` (
  `id` int(11) NOT NULL,
  `no_skk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama2` varchar(255) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `jk2` enum('Laki-laki','Perempuan') NOT NULL,
  `hubungan` text NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `agama2` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nik2` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `alamat2` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `sebab` varchar(225) NOT NULL,
  `hari` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skk`
--

INSERT INTO `skk` (`id`, `no_skk`, `id_user`, `nama2`, `jk`, `jk2`, `hubungan`, `tgl_lahir`, `agama`, `agama2`, `nik`, `nik2`, `alamat`, `alamat2`, `status`, `file`, `sebab`, `hari`, `tanggal`, `waktu`, `tempat`, `tanggal_dibuat`) VALUES
(8, 1, 34, 'Kleo', 'Laki-laki', 'Laki-laki', 'Teman', 'Sungai Miai, 11 Januari 2002', 'Hindu', 'Hindu', '1000000017100000', 2147483647, 'Jl. Sungai Jingah RT. 4 RW. 2', 'Sebamban 3 Blok C', 'Menuggu', NULL, 'Sakit', 'Senin', '2024-08-13', '11.00 Wita', 'Banjarmasin', '2024-08-22 13:48:58'),
(9, 2, 43, 'Mardi', 'Perempuan', 'Laki-laki', 'Teman', 'Sungai Miai, 11 Januari 2002', 'Islam', 'Islam', '1000000001100000', 2147483647, 'Jl. Sungai Jingah RT 1. RW. 2', 'Sebamban 3 Blok', 'Menuggu', NULL, 'Sakit', 'Senin', '2024-08-22', '11.00 Wita', 'Banjarmasin', '2024-08-22 13:57:24'),
(10, 3, 44, 'Giri', 'Perempuan', 'Laki-laki', 'Adik', 'Sungai Miai, 11 Januari 2004', 'Hindu', 'Islam', '1000000013100000', 2147483647, 'Jl, Sungai Jingah RT. 5 RW.2', 'Jl, Sungai Jingah RT. 5 RW.2', 'Menuggu', NULL, 'Sakit', 'Selasa', '2024-07-29', '09.00 Wita', 'Banjarmasin', '2024-08-22 14:03:34'),
(11, 4, 45, 'Poro', 'Perempuan', 'Laki-laki', 'Jl. Sungai Jingah RT. 8 RW 2', 'Sungai Miai, 28 Januari 2002', 'Islam', 'Islam', '1000000002100000', 2147483647, 'Jl. Sungai Jingah RT. 8 RW 2', 'Jl. Sungai Jingah RT. 8 RW 2', 'Menuggu', NULL, 'Sakit', 'Rabu', '2024-08-02', '09.00 Wita', 'Banjarmasin', '2024-08-22 14:08:02'),
(12, 5, 46, 'Bayu', 'Laki-laki', 'Laki-laki', 'Kakak Kandung', 'Sungai Miai, 11 Januari 2008', 'Islam', 'Islam', '1000000023100000', 2147483647, 'Jl. Sungai Jingah RT. 6 RW. 1', 'Jl. Sungai Jingah RT. 6 RW. 1', 'Menuggu', NULL, 'Sakit', 'Kamis', '2024-08-08', '11.00 Wita', 'Banjarmasin', '2024-08-22 14:12:20'),
(13, 6, 50, 'Erawati', 'Laki-laki', 'Perempuan', 'Kakak Kandung', 'Sungai Miai, 28 Januari 2002', 'Islam', 'Islam', '0987654321123567', 2147483647, 'jl.sungai miai', 'jl.sungai miai', 'Menuggu', NULL, 'Sakit', 'Selasa', '2024-09-01', '11.00 Wita', 'Banjarmasin', '2024-09-03 02:04:15'),
(14, 7, 34, '', 'Laki-laki', 'Laki-laki', 'Kakak Kandung', '', 'Islam', '', '', 2147483647, '', '', 'Menunggu', NULL, 'Sakit', 'Senin', '2024-09-12', '11.00 Wita', 'Banjarmasin', '2024-09-06 13:28:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skm`
--

CREATE TABLE `skm` (
  `id` int(11) NOT NULL,
  `no_skm` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `warga` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skm`
--

INSERT INTO `skm` (`id`, `no_skm`, `id_user`, `jk`, `keperluan`, `tgl_lahir`, `agama`, `pekerjaan`, `nik`, `alamat`, `warga`, `status`, `file`, `tanggal_dibuat`) VALUES
(8, 1, 34, 'Laki-laki', 'Membuat BPJS', 'Kerta Buwana, 26 Agustus 2000', 'Hindu', 'Mahasiswa', '1000000017100000', 'Jl. Sungai Jingah RT. 4 RW. 2', 'WNI', 'Menunggu', NULL, '2024-08-22 13:46:48'),
(9, 2, 43, 'Perempuan', 'Membuat BPJS', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Guru', '1000000001100000', 'Jl. Sungai Jingah RT 1. RW. 2', 'WNI', 'Menunggu', NULL, '2024-08-22 13:56:01'),
(10, 3, 44, 'Perempuan', 'Membuat BPJS', 'Banjarbaru, 25 Januari 2002', 'Hindu', 'Mahasiswa', '1000000013100000', 'Jl, Sungai Jingah RT. 5 RW.2', 'WNI', 'Menunggu', NULL, '2024-08-22 14:01:29'),
(11, 4, 45, 'Perempuan', 'Untuk Mendapatkan Beasiswa', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Dokter', '1000000002100000', 'Jl. Sungai Jingah RT. 8 RW 2', 'WNI', 'Menunggu', NULL, '2024-08-22 14:06:16'),
(12, 5, 46, 'Laki-laki', 'Membuat BPJS', 'Banjarmasin, 08 Maret 2001', 'Islam', 'Mahasiswa', '1000000023100000', 'Jl. Sungai Jingah RT. 6 RW. 1', 'WNI', 'Menunggu', NULL, '2024-08-22 14:10:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sku`
--

CREATE TABLE `sku` (
  `id` int(11) NOT NULL,
  `no_sku` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `agama` enum('Islam','Hindu','Kristen','Katolik','Buddha','Konghucu') NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `warga` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT '',
  `usaha` varchar(225) NOT NULL,
  `alamat_usaha` text DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sku`
--

INSERT INTO `sku` (`id`, `no_sku`, `id_user`, `jk`, `keperluan`, `tgl_lahir`, `agama`, `pekerjaan`, `nik`, `alamat`, `warga`, `status`, `file`, `usaha`, `alamat_usaha`, `tanggal_dibuat`) VALUES
(14, 1, 34, 'Laki-laki', 'Membayar Pajak Usaha', 'Kerta Buwana, 26 Agustus 2000', 'Hindu', 'Mahasiswa', '1000000017100000', 'Jl. Sungai Jingah RT. 4 RW. 2', 'WNI', 'Menuggu', '', 'Toko Kue', 'Sebamban 3 Blok C', '2024-08-22 13:47:54'),
(15, 2, 43, 'Perempuan', 'Membayar Pajak Usaha', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Guru', '1000000001100000', 'Jl. Sungai Jingah RT 1. RW. 2', 'WNI', 'Menuggu', '', 'Dokter Gigi', 'Jl. Sungai Jingah RT 1. RW. 2', '2024-08-22 13:56:41'),
(16, 3, 44, 'Perempuan', 'Membayar Pajak Usaha', 'Banjarbaru, 25 Januari 2002', 'Islam', 'Mahasiswa', '1000000013100000', 'Jl, Sungai Jingah RT. 5 RW.2', 'WNI', 'Menuggu', '', 'Rumah Makan', 'Jl, Sungai Jingah RT. 5 RW.2', '2024-08-22 14:02:23'),
(17, 4, 45, 'Perempuan', 'Membayar Pajak Usaha', 'Banjarmasin, 15 Januari 1990', 'Islam', 'Dokter', '1000000002100000', 'Jl. Sungai Jingah RT. 8 RW 2', 'WNI', 'Menuggu', '', 'Toko Baju', 'Jl. Sungai Jingah RT. 8 RW 2', '2024-08-22 14:07:03'),
(18, 5, 46, 'Laki-laki', 'Membayar Pajak Usaha', 'Banjarmasin, 08 Maret 2001', 'Islam', 'Mahasiswa', '1000000023100000', 'Jl. Sungai Jingah RT. 6 RW. 1', 'WNI', 'Menuggu', '', 'Warung Sembako', 'Jl. Sungai Jingah RT. 6 RW. 1', '2024-08-22 14:11:23'),
(19, 6, 50, 'Laki-laki', 'Membayar Pajak Usaha', 'Banjarmasin, 20 Mei 1992', 'Islam', 'Dosen', '0987654321123567', 'jl.sungai miai', 'WNI', 'Disetujui', 'Surat Keterangan Usaha.pdf', 'Loundry', 'jl.sungai miai', '2024-09-03 01:49:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `nama_pegawai` varchar(255) DEFAULT NULL,
  `tugas` varchar(255) DEFAULT NULL,
  `poin` int(11) DEFAULT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `bulan` enum('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DEFAULT 'Januari'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `nama_pegawai`, `tugas`, `poin`, `id_pegawai`, `bulan`) VALUES
(17, 'FARID RIDHONY, S.SOS, M', 'Memberikan Bantuan Beras Kepada Warga dan Menyelesaikan Tugas Dengan Cepat', 400, 1, 'Juli'),
(18, 'DONY SETIADI, SE', 'Memberikan Bantuan Beras Kepada Warga dan Menyelesaikan Tugas Dengan Cepat', 400, 2, 'Juli'),
(19, 'KATERINA YULIANTI, SE', 'Ketepatan menyelesaikan tugas sangat baik', 200, 3, 'Januari'),
(20, 'RAHAYU MAULIDA, A.MD', 'Pelayanan Masyarakat, Menyelesaikan Tugas Dengan Cepat', 400, 4, 'Agustus'),
(21, 'RIZKA NUR AMALIA, S.AB', 'Pelayanan Masyarakat, Menyelesaikan Tugas Dengan Cepat', 400, 5, 'Maret'),
(22, 'ASYIAH', 'Memberikan Bantuan Beras dan Menyelesaikan Tugas Dengan Cepat', 400, 6, 'Oktober');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `level` varchar(50) NOT NULL DEFAULT 'pelanggan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verifikasi` enum('Belum Terverifikasi','Sudah Terverifikasi') NOT NULL DEFAULT 'Belum Terverifikasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `level`, `created_at`, `updated_at`, `verifikasi`) VALUES
(1, 'admin', 'admin', 'Administrator', '', 'admin', '2024-08-01 22:19:46', '2024-08-14 06:51:46', 'Sudah Terverifikasi'),
(34, 'kadekagus', 'kadekagus', 'I Kadek Agus Diana Putra', 'kadeka841@gmail.com', 'pelanggan', '2024-08-14 23:29:11', '2024-08-22 04:50:35', 'Sudah Terverifikasi'),
(43, 'ajeng', 'ajeng', 'Dwi Ajeng Anindia', 'blaavlaaa@gmail.com', 'pelanggan', '2024-08-22 04:36:12', '2024-08-22 14:13:31', 'Sudah Terverifikasi'),
(44, 'putu', 'putu', 'Ni Putu Sutia Andryani', 'blaavlaaa@gmail.com', 'pelanggan', '2024-08-22 04:44:52', '2024-08-22 14:13:36', 'Sudah Terverifikasi'),
(45, 'erawati', 'erawati', 'Erawati', 'blaavlaaa@gmail.com', 'pelanggan', '2024-08-22 04:46:52', '2024-08-22 04:51:29', 'Sudah Terverifikasi'),
(46, 'rendi', 'rendi', 'Rendi', 'blaavlaaa@gmail.com', 'pelanggan', '2024-08-22 04:48:57', '2024-08-22 14:09:43', 'Sudah Terverifikasi'),
(48, 'erna', 'erna', 'Ernawati', 'masako@gmail.com', 'pelanggan', '2024-08-28 23:09:43', '2024-08-28 23:10:22', 'Sudah Terverifikasi'),
(50, 'erfan', 'erfan', 'erfan', 'blaavsdaaa@gmail.com', 'pelanggan', '2024-09-03 01:45:45', '2024-09-03 01:46:10', 'Sudah Terverifikasi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pejabat_desa`
--
ALTER TABLE `pejabat_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `presensi_pegawai`
--
ALTER TABLE `presensi_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `profil_desa`
--
ALTER TABLE `profil_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sk`
--
ALTER TABLE `sk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skbb`
--
ALTER TABLE `skbb`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skbm`
--
ALTER TABLE `skbm`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skbmr`
--
ALTER TABLE `skbmr`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skd`
--
ALTER TABLE `skd`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skk`
--
ALTER TABLE `skk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skm`
--
ALTER TABLE `skm`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sku`
--
ALTER TABLE `sku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pejabat_desa`
--
ALTER TABLE `pejabat_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `presensi_pegawai`
--
ALTER TABLE `presensi_pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT untuk tabel `profil_desa`
--
ALTER TABLE `profil_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sk`
--
ALTER TABLE `sk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `skbb`
--
ALTER TABLE `skbb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `skbm`
--
ALTER TABLE `skbm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `skbmr`
--
ALTER TABLE `skbmr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `skd`
--
ALTER TABLE `skd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `skk`
--
ALTER TABLE `skk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `skm`
--
ALTER TABLE `skm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `sku`
--
ALTER TABLE `sku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penduduk`
--
ALTER TABLE `penduduk`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi_pegawai`
--
ALTER TABLE `presensi_pegawai`
  ADD CONSTRAINT `presensi_pegawai_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`);

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `fk_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
