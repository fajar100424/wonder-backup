-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 04, 2024 at 10:21 AM
-- Server version: 10.5.22-MariaDB-cll-lve
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wond3714_wonder`
--

-- --------------------------------------------------------

--
-- Table structure for table `ba_hambatan`
--

CREATE TABLE `ba_hambatan` (
  `id_ba_hambatan` int(25) NOT NULL,
  `id_wonder` int(25) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `keterangan_ba` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_hambatan`
--

INSERT INTO `ba_hambatan` (`id_ba_hambatan`, `id_wonder`, `start`, `end`, `keterangan_ba`, `created_at`) VALUES
(3, 3, '2024-07-21 05:27:00', '2024-07-21 09:27:00', 'Hujan Deras', '2024-07-21 05:27:41'),
(5, 3, '2024-07-25 16:12:00', '2024-07-27 16:12:00', 'Hujan Deras', '2024-07-25 16:12:48'),
(7, 7, '2023-01-13 08:00:00', '2023-01-13 13:00:00', 'Hujan deras ', '2024-09-13 11:43:39'),
(8, 7, '2023-01-13 22:00:00', '2023-01-14 06:00:00', 'tidak bisa moving malam hari lewat pemukiman warga', '2024-09-13 11:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `ba_keterangan`
--

CREATE TABLE `ba_keterangan` (
  `id_ba` int(25) NOT NULL,
  `id_wonder` int(25) NOT NULL,
  `start_rig_down` datetime DEFAULT NULL,
  `end_rig_down` datetime DEFAULT NULL,
  `keterangan1` varchar(50) NOT NULL DEFAULT 'Rig down dari sumur sebelumnya',
  `start_moving` varchar(50) DEFAULT NULL,
  `end_moving` datetime DEFAULT NULL,
  `keterangan2` varchar(25) NOT NULL DEFAULT 'Moving',
  `start_rig_up` datetime DEFAULT NULL,
  `end_rig_up` datetime NOT NULL,
  `keterangan3` varchar(25) NOT NULL DEFAULT 'Rig Up',
  `start_icheck` datetime DEFAULT NULL,
  `end_icheck` datetime DEFAULT NULL,
  `keterangan4` varchar(25) NOT NULL DEFAULT 'Icheck',
  `start_rscl` datetime DEFAULT NULL,
  `end_rscl` datetime DEFAULT NULL,
  `keterangan5` varchar(25) NOT NULL DEFAULT 'RSCL',
  `start_sika_operasi` datetime DEFAULT NULL,
  `end_sika_operasi` datetime DEFAULT NULL,
  `keterangan6` varchar(25) NOT NULL DEFAULT 'SIKA Operasi',
  `start_mulai_operasi` datetime DEFAULT NULL,
  `end_mulai_operasi` datetime DEFAULT NULL,
  `keterangan7` varchar(25) NOT NULL DEFAULT 'Hari Operasi',
  `start_release_rig_down` datetime DEFAULT NULL,
  `end_release_rig_down` datetime DEFAULT NULL,
  `keterangan8` varchar(25) NOT NULL DEFAULT 'R/D',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ba_keterangan`
--

INSERT INTO `ba_keterangan` (`id_ba`, `id_wonder`, `start_rig_down`, `end_rig_down`, `keterangan1`, `start_moving`, `end_moving`, `keterangan2`, `start_rig_up`, `end_rig_up`, `keterangan3`, `start_icheck`, `end_icheck`, `keterangan4`, `start_rscl`, `end_rscl`, `keterangan5`, `start_sika_operasi`, `end_sika_operasi`, `keterangan6`, `start_mulai_operasi`, `end_mulai_operasi`, `keterangan7`, `start_release_rig_down`, `end_release_rig_down`, `keterangan8`, `created_at`) VALUES
(1, 3, '2024-07-21 05:59:00', '2024-07-22 05:59:00', 'Rig down dari sumur sebelumnya', '2024-07-23T06:01', '2024-07-24 07:01:00', 'Moving', '2024-07-27 17:44:00', '2024-08-03 17:44:00', 'Rig Up', NULL, NULL, 'Icheck', NULL, NULL, 'RSCL', NULL, NULL, 'SIKA Operasi', '2024-07-01 06:03:00', '2024-08-02 10:03:00', 'Hari Operasi', '2024-08-01 06:03:00', '2024-08-02 11:03:00', 'R/D', '2024-07-27 17:49:09'),
(2, 4, '2024-07-21 14:17:00', '2024-07-22 15:17:00', 'Rig down dari sumur sebelumnya', '2024-07-22T14:18', '2024-07-25 14:18:00', 'Moving', '2024-07-23 14:19:00', '2024-08-01 14:19:00', 'Rig Up', '2024-07-24 14:19:00', '2024-07-25 14:19:00', 'Icheck', '2024-08-01 14:19:00', '2024-08-07 14:19:00', 'RSCL', '2024-08-07 20:19:00', '2024-08-10 14:25:00', 'SIKA Operasi', '2024-08-01 18:20:00', '2024-08-04 18:21:00', 'Hari Operasi', '2024-08-02 14:21:00', '2024-08-08 14:21:00', 'R/D', '2024-07-21 15:01:13'),
(3, 5, NULL, NULL, 'Rig down dari sumur sebelumnya', NULL, NULL, 'Moving', NULL, '0000-00-00 00:00:00', 'Rig Up', NULL, NULL, 'Icheck', NULL, NULL, 'RSCL', NULL, NULL, 'SIKA Operasi', NULL, NULL, 'Hari Operasi', NULL, NULL, 'R/D', '2024-08-01 22:01:47'),
(4, 6, NULL, NULL, 'Rig down dari sumur sebelumnya', NULL, NULL, 'Moving', NULL, '0000-00-00 00:00:00', 'Rig Up', NULL, NULL, 'Icheck', NULL, NULL, 'RSCL', NULL, NULL, 'SIKA Operasi', NULL, NULL, 'Hari Operasi', NULL, NULL, 'R/D', '2024-08-26 22:17:13'),
(5, 7, '2023-01-13 07:00:00', '2023-01-14 21:00:00', 'Moving', '2023-01-14T21:00', '2023-01-15 09:00:00', 'RIg up', '2023-01-15 09:00:00', '2023-01-15 16:00:00', 'Icheck', '2023-01-15 16:00:00', '2023-01-17 08:00:00', 'RSCL', '2023-01-17 08:00:00', '2023-01-17 19:00:00', 'Sika Operasi', NULL, NULL, 'SIKA Operasi', '2023-01-17 19:00:00', '2023-02-09 18:00:00', 'Hari Operasi', '2023-02-09 18:00:00', '2023-02-10 18:00:00', 'R/D', '2024-09-13 11:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `mulai` datetime NOT NULL,
  `selesai` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id_calendar`, `kegiatan`, `mulai`, `selesai`) VALUES
(6, 'test', '2024-06-02 21:49:00', '2024-06-03 21:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `data_berkas_pendukung`
--

CREATE TABLE `data_berkas_pendukung` (
  `id_data_berkas_pendukung` int(255) NOT NULL,
  `id_wonder` int(255) DEFAULT NULL,
  `jenis_berkas` varchar(255) NOT NULL,
  `nama_berkas` varchar(50) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_berkas_pendukung`
--

INSERT INTO `data_berkas_pendukung` (`id_data_berkas_pendukung`, `id_wonder`, `jenis_berkas`, `nama_berkas`, `created_at`) VALUES
(2, 4, 'Test ada perubahan pada data penunjang', '669cb94285485.pdf', '2024-07-21'),
(8, 3, 'PPP Form III A11 signed', '66a1fec55da75.png', '2024-07-25'),
(10, 3, 'test 2', '66a4c4b6b6b96.xlsx', '2024-07-27'),
(11, 3, 'Form PPP Excel', '66a4d508eae82.xlsx', '2024-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `evidence`
--

CREATE TABLE `evidence` (
  `id_evidence` int(11) NOT NULL,
  `id_wonder` int(25) NOT NULL,
  `id_item` int(255) NOT NULL,
  `remarks_uploader` varchar(255) DEFAULT NULL,
  `progress` int(25) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evidence`
--

INSERT INTO `evidence` (`id_evidence`, `id_wonder`, `id_item`, `remarks_uploader`, `progress`, `status`, `created_at`) VALUES
(8, 3, 10, 'test 214', 12, 0, '2024-07-26 20:47:09'),
(9, 4, 1, 'testupload dokumen ba1', NULL, 0, '2024-07-21 07:23:42'),
(10, 4, 13, 'test', 90, 0, '2024-07-21 07:46:11'),
(11, 3, 1, 'test 2', 100, 1, '2024-07-26 20:45:33'),
(17, 3, 2, '                                                                                                                                                                                                                                                               ', 100, 0, '2024-07-27 11:08:45'),
(18, 3, 3, '                                                                                                                                                                ', 100, 1, '2024-07-27 08:02:39'),
(19, 7, 1, '                                                                            ', 100, 1, '2024-09-17 13:51:30'),
(20, 7, 2, '                                                                            ', 100, 1, '2024-09-17 13:53:12'),
(21, 7, 3, '                                                                            ', NULL, 0, '2024-09-13 05:27:22'),
(22, 7, 7, ' dibawah terdapat keterangan BA                                                                           ', 50, 0, '2024-09-17 13:54:19'),
(23, 7, 11, '                                                                            ', NULL, 0, '2024-09-13 05:31:14'),
(24, 7, 10, 'keterangan BA dibawah                                                 ', NULL, 0, '2024-09-13 05:34:12'),
(25, 7, 13, '                                                                            ', NULL, 0, '2024-09-13 05:35:03'),
(26, 7, 18, '184 tubing bekas                                                ', NULL, 0, '2024-09-13 05:37:42'),
(27, 7, 19, '                                                                            ', NULL, 0, '2024-09-13 05:38:17'),
(28, 7, 14, '                                                                            ', NULL, 0, '2024-09-13 05:38:42'),
(29, 7, 15, '                                                                            ', NULL, 0, '2024-09-13 05:39:00'),
(30, 7, 17, '                                                                            ', NULL, 0, '2024-09-13 05:39:45'),
(31, 7, 20, '                                                                            ', NULL, 0, '2024-09-13 05:42:49'),
(32, 7, 21, '                                                                            ', NULL, 0, '2024-09-13 05:43:13'),
(33, 7, 22, '                                                                            ', NULL, 0, '2024-09-13 05:43:47'),
(34, 7, 23, '                                                                            ', NULL, 0, '2024-09-13 05:44:30'),
(35, 7, 24, '                                                                            ', NULL, 0, '2024-09-13 05:44:49'),
(36, 7, 33, '                                                                            ', NULL, 0, '2024-09-13 05:45:28'),
(37, 7, 28, '                                                                            ', NULL, 0, '2024-09-13 05:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `history_evidence`
--

CREATE TABLE `history_evidence` (
  `id_history` int(25) NOT NULL,
  `id_evidence` int(25) NOT NULL,
  `document` varchar(25) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reviewer` int(25) DEFAULT NULL,
  `uploader` int(25) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_evidence`
--

INSERT INTO `history_evidence` (`id_history`, `id_evidence`, `document`, `remarks`, `created_at`, `reviewer`, `uploader`, `deadline`) VALUES
(9, 8, '669c506256e54.pdf', 'test 2', '2024-07-26 20:47:09', 2, 1, '2024-07-25 11:09:00'),
(10, 9, '669cb77e65c26.pdf', NULL, '2024-07-21 07:23:43', NULL, 1, NULL),
(11, 10, '669cb80e01c78.jpg', 'update test review evidence', '2024-07-21 07:46:11', 1, 1, '2024-07-26 14:27:00'),
(12, 11, '66a1ce113ebc8.png', 'test', '2024-07-25 04:04:39', 1, 1, '2024-07-25 11:04:00'),
(13, 11, '66a3eb3ff28d0.jpg', NULL, '2024-07-26 18:30:24', NULL, 1, NULL),
(14, 11, '66a3eb8644598.jpg', 'sukses', '2024-07-26 20:45:33', 2, 1, '2024-07-27 03:45:00'),
(15, 17, 'Auto Confirm Berkas', '', '2024-07-27 05:35:00', 2, 2, '2024-07-27 12:34:00'),
(16, 18, 'Auto Confirm Berkas', NULL, '2024-07-26 21:41:49', NULL, 2, NULL),
(17, 17, '66a4a98c3fd34.pdf', NULL, '2024-07-27 08:02:20', NULL, 1, NULL),
(18, 18, '66a4a99f6211b.xlsx', NULL, '2024-07-27 08:02:39', NULL, 1, NULL),
(19, 17, '66a4d53d0becb.png', NULL, '2024-07-27 11:08:45', NULL, 3, NULL),
(20, 19, '66e3c407b89b6.pdf', 'sudah OK', '2024-09-17 13:51:30', 2, 3, '2024-09-17 20:51:00'),
(21, 20, '66e3c416c5c0b.pdf', 'sudah OK', '2024-09-17 13:53:12', 2, 3, '2024-09-17 20:53:00'),
(22, 21, '66e3cd3aba451.pdf', NULL, '2024-09-13 05:27:22', NULL, 3, NULL),
(23, 22, '66e3cde1726e4.pdf', 'pisahkan antara BA mulai operasi sendiri jangan digabung invoice', '2024-09-17 13:54:19', 2, 3, '2024-09-20 20:54:00'),
(24, 23, '66e3ce1d6d0fd.pdf', NULL, '2024-09-13 05:31:14', NULL, 3, NULL),
(25, 24, '66e3cece9fb93.pdf', NULL, '2024-09-13 05:34:12', NULL, 3, NULL),
(26, 25, '66e3cf062350b.pdf', NULL, '2024-09-13 05:35:03', NULL, 3, NULL),
(27, 26, '66e3cfa62879a.pdf', NULL, '2024-09-13 05:37:42', NULL, 3, NULL),
(28, 27, '66e3cfc3e08dc.xlsx', NULL, '2024-09-13 05:38:17', NULL, 3, NULL),
(29, 28, '66e3cfe1469a2.pdf', NULL, '2024-09-13 05:38:42', NULL, 3, NULL),
(30, 29, '66e3cff373cbb.pdf', NULL, '2024-09-13 05:39:00', NULL, 3, NULL),
(31, 30, '66e3d0128da70.pdf', NULL, '2024-09-13 05:39:35', NULL, 3, NULL),
(32, 30, '66e3d01c8bcbc.pdf', NULL, '2024-09-13 05:39:45', NULL, 3, NULL),
(33, 31, '66e3d0d935686.xlsx', NULL, '2024-09-13 05:42:49', NULL, 3, NULL),
(34, 32, '66e3d0ef37feb.xlsx', NULL, '2024-09-13 05:43:13', NULL, 3, NULL),
(35, 33, '66e3d11094c03.xlsx', NULL, '2024-09-13 05:43:47', NULL, 3, NULL),
(36, 34, '66e3d13e2a499.pdf', NULL, '2024-09-13 05:44:30', NULL, 3, NULL),
(37, 35, '66e3d1517c822.pdf', NULL, '2024-09-13 05:44:49', NULL, 3, NULL),
(38, 36, '66e3d17763dfa.pdf', NULL, '2024-09-13 05:45:28', NULL, 3, NULL),
(39, 37, '66e3d19e48005.xls', NULL, '2024-09-13 05:46:07', NULL, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id_info` int(11) NOT NULL,
  `heading` longtext DEFAULT NULL,
  `keterangan` longtext DEFAULT NULL,
  `gambar` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id_info`, `heading`, `keterangan`, `gambar`, `created_at`) VALUES
(3, 'test', 'test', '665c86c44f072.jpg', '2024-06-02 21:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `numbering` int(25) NOT NULL,
  `item` longtext NOT NULL,
  `bobot` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id_item`, `numbering`, `item`, `bobot`, `created_at`) VALUES
(1, 1, 'BA Assesment sebelum dan setelah dressing Lokasi', 2, '2024-07-17 11:35:41'),
(2, 2, 'BA Moving', 2, '2024-07-17 11:36:05'),
(3, 3, 'BA Rig Up 100%', 2, '2024-07-17 11:36:20'),
(4, 4, 'BA Verifikasi Closing Temuan RSCL', 1, '2024-07-17 11:36:41'),
(5, 5, 'BA Keterlambatan Moving', 2, '2024-07-17 11:37:01'),
(6, 6, 'BA Keterlambatan Rig Up ubah', 2, '2024-07-17 11:38:20'),
(7, 7, 'BA Mulai Operasi', 1, '2024-07-17 11:38:20'),
(8, 8, 'BA NPT Service Company', 3, '2024-07-17 11:46:29'),
(9, 9, 'BA NPT Rig', 3, '2024-07-17 11:46:29'),
(10, 10, 'BA Selesai Operasi', 1, '2024-07-17 11:46:29'),
(11, 11, 'BA Rig Down', 1, '2024-07-17 11:46:29'),
(12, 12, 'BA Serah Terima Sumur', 2, '2024-07-17 11:46:29'),
(13, 13, 'Program WO Ttd', 1, '2024-07-17 11:46:29'),
(14, 14, 'Laporan Material yang di TTD', 8, '2024-07-17 11:46:29'),
(15, 15, 'Laporan Solar yang di TTD', 3, '2024-07-17 11:46:29'),
(16, 16, 'MoM Keteknikan pdf', 1, '2024-07-17 11:46:29'),
(17, 17, 'BA Pemakaian Solar Services', 2, '2024-07-17 11:46:29'),
(18, 18, 'Tally RPP yang di TTD Coman', 4, '2024-07-17 11:46:29'),
(19, 19, 'Form PPP format terbaru sheet datetimeline diisi semua perline', 10, '2024-07-17 11:46:29'),
(20, 20, 'Workover Time Terakhir', 5, '2024-07-17 11:46:29'),
(21, 21, 'Workover Cost Terakhir', 5, '2024-07-17 11:46:29'),
(22, 22, 'AFE FEB', 1, '2024-07-17 11:46:29'),
(23, 23, 'Program Fract / Acid', 1, '2024-07-17 11:46:29'),
(24, 24, 'Post Job Report Fract / Acid', 3, '2024-07-17 11:46:29'),
(25, 25, 'Root Cause Analysis', 3, '2024-07-17 11:46:29'),
(26, 26, 'Slide Problem Occurred (buat pdf jika ada bukti problem operasi)', 1, '2024-07-17 11:46:29'),
(27, 27, 'Rekap Dokumentasi Fishing/Cutting/Milling dll', 3, '2024-07-17 11:46:29'),
(28, 28, 'Well Profile before after excel', 3, '2024-07-17 11:46:29'),
(29, 29, 'Problem Occurred 1 (Administration support/BA/RCA/Korespondensi SKK Migas) C/W kelebihan waktu ', 3, '2024-07-17 11:46:29'),
(30, 30, 'Problem Occurred 2 (Administration support/BA/RCA/Korespondensi SKK Migas) C/W kelebihan waktu ', 3, '2024-07-17 11:46:29'),
(31, 31, 'Problem Occurred 3 (Administration support/BA/RCA/Korespondensi SKK Migas) C/W kelebihan waktu', 3, '2024-07-17 11:46:29'),
(32, 32, 'Problem Occurred 4 (Administration support/BA/RCA/Korespondensi SKK Migas) C/W kelebihan waktu', 3, '2024-07-17 11:46:29'),
(33, 33, 'Change Of Program 1 (dokumentasi penggunaan material di luar program/ Korespondensi SKK Migas) C/W kelebihan waktu ', 3, '2024-07-17 11:46:29'),
(34, 34, 'Change Of Program 2 (dokumentasi penggunaan material di luar program/ Korespondensi SKK Migas) C/W kelebihan waktu ', 3, '2024-07-17 11:46:29'),
(35, 35, 'Change Of Program 3 (dokumentasi penggunaan material di luar program/ Korespondensi SKK Migas) C/W kelebihan waktu ', 3, '2024-07-17 11:46:29'),
(36, 36, 'Change Of Program 4 (dokumentasi penggunaan material di luar program/ Korespondensi SKK Migas) C/W kelebihan waktu', 3, '2024-07-17 11:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_user` int(25) NOT NULL,
  `type` varchar(20) NOT NULL,
  `text` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rig`
--

CREATE TABLE `rig` (
  `id_rig` int(11) NOT NULL,
  `rig` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rig`
--

INSERT INTO `rig` (`id_rig`, `rig`) VALUES
(1, 'ARJ'),
(2, 'GJE #11'),
(3, 'NREM'),
(4, 'PDSI#36.1'),
(5, 'GJE#04'),
(6, 'GJE#05');

-- --------------------------------------------------------

--
-- Table structure for table `sumur`
--

CREATE TABLE `sumur` (
  `id_sumur` int(11) NOT NULL,
  `nama_sumur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sumur`
--

INSERT INTO `sumur` (`id_sumur`, `nama_sumur`) VALUES
(5, 'JRK'),
(9, 'MSI'),
(12, 'BKB'),
(13, 'BTG'),
(14, 'TLJ'),
(15, 'BRG'),
(17, 'BN'),
(18, 'RB'),
(20, 'KLD'),
(21, 'KSB'),
(22, 'KST'),
(23, 'PRP'),
(24, 'SPA'),
(25, 'SBL'),
(27, 'WS'),
(28, 'WCF'),
(29, 'KWG'),
(30, 'TPN'),
(31, 'LDK'),
(32, 'SMG'),
(33, 'NGL'),
(34, 'BNG'),
(35, 'TBN'),
(36, 'MSB'),
(37, 'PMB'),
(39, 'TEST'),
(40, 'TPK'),
(41, 'SLL'),
(42, 'TMB'),
(43, 'TTB'),
(44, 'L5A');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) NOT NULL,
  `jk` enum('Laki-laki','Perempuan','','') NOT NULL,
  `no_hp` varchar(25) DEFAULT NULL,
  `foto` varchar(25) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`, `jabatan`, `jk`, `no_hp`, `foto`, `tanggal_lahir`, `created_at`) VALUES
(1, 'Fajar Alamsyah Ubah', 'admin', '$2y$10$PQfUP10oCRK/ClpyNAdehuTiZRK/JzVrFekBvokWoo7Ynj54ckOEq', 'superadmin', 'administrator master', 'Laki-laki', '+6281278564861', '66845b99c4101.jpg', '2002-01-24', '2024-05-14 07:01:45'),
(2, 'reviewer', 'reviewer', '$2y$10$v8oYxsYOVeuTbT0Gb5kLc.4Kp73/aKxtt8qemwfhFKSmMSecGaoYu', 'reviewer', 'reviewer', '', '081278564865', NULL, '2002-01-24', '2024-05-14 07:01:45'),
(3, 'uploader', 'uploader', '$2y$10$VlvNdfO3/ajOWZewtE4uQ.kW4l9gq.nCqtkSYgFxaJKOwL5SUkgQa', 'uploader', 'uploader update', '', '+6281278564865', '66845b6444577.jpg', '2002-01-24', '2024-05-14 07:01:45'),
(5, 'Fajar Alamsyah', 'fajar', '$2y$10$IA4ZamVDXTOpM4Y9imqXFuQOjgY5j2lBYs.TPhZr8H383t.ZAdKeG', 'reviewer', 'programmer', '', '+6281278564865', '665c2a561c1b4.jpg', '2002-01-24', '2024-06-02 08:16:22'),
(7, 'Test admin', 'admintest', '$2y$10$sAqVZ0OL/DxMgcYpz0CkE.HHawRfOVXiW/VvNxt0.QFidF909MC5K', 'superadmin', 'administrator', 'Laki-laki', '+6281278564861', '665d8de329f00.jpg', '2024-06-03', '2024-06-03 09:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `wonder`
--

CREATE TABLE `wonder` (
  `id_upload` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `no_afe` varchar(25) DEFAULT NULL,
  `tahun_pengerjaan` year(4) DEFAULT NULL,
  `id_sumur` int(11) DEFAULT NULL,
  `no_sumur` varchar(255) DEFAULT NULL,
  `tipe_pekerjaan` varchar(25) DEFAULT NULL,
  `id_rig` int(25) NOT NULL,
  `kapasitas_rig` varchar(255) NOT NULL,
  `jarak_moving` double DEFAULT NULL,
  `total_hari_moving_afe` float DEFAULT NULL,
  `jatah_moving` float DEFAULT NULL,
  `moving_days` float DEFAULT NULL,
  `operation_days_plan` float DEFAULT NULL,
  `operation_days` float DEFAULT NULL,
  `plan_budget` double DEFAULT NULL,
  `budget` double DEFAULT NULL,
  `progress` int(2) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wonder`
--

INSERT INTO `wonder` (`id_upload`, `id_user`, `no_afe`, `tahun_pengerjaan`, `id_sumur`, `no_sumur`, `tipe_pekerjaan`, `id_rig`, `kapasitas_rig`, `jarak_moving`, `total_hari_moving_afe`, `jatah_moving`, `moving_days`, `operation_days_plan`, `operation_days`, `plan_budget`, `budget`, `progress`, `created_at`, `updated_at`, `updated_by`, `deadline`, `keterangan`) VALUES
(3, 1, 'AFE123', '2024', 12, '123', '5', 1, '12', 12.3, 11, 32, 12, 12, 12, 123456, 123456, 0, '2024-07-20 21:22:55', '2024-07-27 18:08:45', 'uploader', '2024-09-09 19:25:00', NULL),
(4, 1, 'AFE1234', '2024', 9, '123', '2', 1, '12', 12.3, 10, 32, 20, 30, 20, 123456, 123456, 0, '2024-07-21 07:15:26', '2024-07-21 14:46:11', 'Fajar Alamsyah Ubah', '2024-08-03 16:28:00', NULL),
(5, 1, 'AFE12345', '2024', 9, '123', '2', 1, '12', 12.3, 12, 12, 12, 12, 12, 123456, 123456, 0, '2024-08-01 15:01:47', '2024-08-01 22:01:47', '1', '2024-08-02 23:33:36', NULL),
(6, 3, '24-190-212-OO ', '2024', 41, '32', '2', 4, '350', 2.9, 0, 4, 0, 0, 0, 0, 0, 0, '2024-08-26 15:17:13', '2024-08-26 22:17:13', '3', NULL, NULL),
(7, 3, '23-190-221-OO', '2022', 24, '34', '2', 2, '450', 4, 0, 1, 4.5, 18.7, 22.96, 470258.492766785, 316740.128409823, 0, '2024-09-13 04:30:11', '2024-09-17 20:54:19', 'reviewer', '2024-09-17 20:48:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ba_hambatan`
--
ALTER TABLE `ba_hambatan`
  ADD PRIMARY KEY (`id_ba_hambatan`),
  ADD KEY `id_wonder_ba_hambatan` (`id_wonder`);

--
-- Indexes for table `ba_keterangan`
--
ALTER TABLE `ba_keterangan`
  ADD PRIMARY KEY (`id_ba`),
  ADD KEY `id_wonder_ba_keterangan` (`id_wonder`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id_calendar`);

--
-- Indexes for table `data_berkas_pendukung`
--
ALTER TABLE `data_berkas_pendukung`
  ADD PRIMARY KEY (`id_data_berkas_pendukung`),
  ADD KEY `id_wonder_berkas` (`id_wonder`);

--
-- Indexes for table `evidence`
--
ALTER TABLE `evidence`
  ADD PRIMARY KEY (`id_evidence`),
  ADD KEY `id_wonder_fk` (`id_wonder`),
  ADD KEY `item_fk` (`id_item`);

--
-- Indexes for table `history_evidence`
--
ALTER TABLE `history_evidence`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_evidence_fk` (`id_evidence`),
  ADD KEY `reviewer_fk` (`reviewer`),
  ADD KEY `uploader_fk` (`uploader`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id_info`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user_fk` (`id_user`);

--
-- Indexes for table `rig`
--
ALTER TABLE `rig`
  ADD PRIMARY KEY (`id_rig`);

--
-- Indexes for table `sumur`
--
ALTER TABLE `sumur`
  ADD PRIMARY KEY (`id_sumur`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `wonder`
--
ALTER TABLE `wonder`
  ADD PRIMARY KEY (`id_upload`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_sumur` (`id_sumur`),
  ADD KEY `id_rig_fk` (`id_rig`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ba_hambatan`
--
ALTER TABLE `ba_hambatan`
  MODIFY `id_ba_hambatan` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ba_keterangan`
--
ALTER TABLE `ba_keterangan`
  MODIFY `id_ba` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_berkas_pendukung`
--
ALTER TABLE `data_berkas_pendukung`
  MODIFY `id_data_berkas_pendukung` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `evidence`
--
ALTER TABLE `evidence`
  MODIFY `id_evidence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `history_evidence`
--
ALTER TABLE `history_evidence`
  MODIFY `id_history` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rig`
--
ALTER TABLE `rig`
  MODIFY `id_rig` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sumur`
--
ALTER TABLE `sumur`
  MODIFY `id_sumur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wonder`
--
ALTER TABLE `wonder`
  MODIFY `id_upload` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ba_hambatan`
--
ALTER TABLE `ba_hambatan`
  ADD CONSTRAINT `id_wonder_ba_hambatan` FOREIGN KEY (`id_wonder`) REFERENCES `wonder` (`id_upload`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ba_keterangan`
--
ALTER TABLE `ba_keterangan`
  ADD CONSTRAINT `id_wonder_ba_keterangan` FOREIGN KEY (`id_wonder`) REFERENCES `wonder` (`id_upload`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_berkas_pendukung`
--
ALTER TABLE `data_berkas_pendukung`
  ADD CONSTRAINT `id_wonder_berkas` FOREIGN KEY (`id_wonder`) REFERENCES `wonder` (`id_upload`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evidence`
--
ALTER TABLE `evidence`
  ADD CONSTRAINT `id_wonder_fk` FOREIGN KEY (`id_wonder`) REFERENCES `wonder` (`id_upload`),
  ADD CONSTRAINT `item_fk` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`);

--
-- Constraints for table `history_evidence`
--
ALTER TABLE `history_evidence`
  ADD CONSTRAINT `id_evidence_fk` FOREIGN KEY (`id_evidence`) REFERENCES `evidence` (`id_evidence`),
  ADD CONSTRAINT `reviewer_fk` FOREIGN KEY (`reviewer`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `uploader_fk` FOREIGN KEY (`uploader`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wonder`
--
ALTER TABLE `wonder`
  ADD CONSTRAINT `id_rig_fk` FOREIGN KEY (`id_rig`) REFERENCES `rig` (`id_rig`),
  ADD CONSTRAINT `wonder_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `wonder_ibfk_2` FOREIGN KEY (`id_sumur`) REFERENCES `sumur` (`id_sumur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
