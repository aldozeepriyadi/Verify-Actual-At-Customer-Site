-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 15. Maret 2024 jam 17:21
-- Versi Server: 5.1.37
-- Versi PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `verifyarrival`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver`
--  

CREATE TABLE IF NOT EXISTS `driver` (
  `id_driver` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `cycle` varchar(255) NOT NULL,
  PRIMARY KEY (`id_driver`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `driver`
--

INSERT INTO `driver` (`id_driver`, `username`, `password`, `nama`, `no_hp`, `cycle`) VALUES
(2, 'aldofernando17', '$2a$10$oif5ytKj.2VmVzVkarAZpOHKyslESvcM3nm5TeKlpr0YPkK.zwYmC', 'Aldo Fernando', '085656482282', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_lokasi`
--

CREATE TABLE IF NOT EXISTS `master_lokasi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bpid` varchar(20) NOT NULL,
  `longi` varchar(255) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `status` int(10) NOT NULL,
  `ins_dt` datetime NOT NULL,
  `ins_usr` varchar(20) NOT NULL,
  `modify_dt` datetime NOT NULL,
  `modify_usr` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `master_lokasi`
--

INSERT INTO `master_lokasi` (`id`, `bpid`, `longi`, `lat`, `status`, `ins_dt`, `ins_usr`, `modify_dt`, `modify_usr`) VALUES
(1, 'CLIDTAM50', '107.09335431395259', '-6.308498398070111', 1, '2024-02-27 08:30:40', 'Aldo Fernando', '2024-02-27 08:31:01', 'Aldo Fernando'),
(2, 'CLIDTAM51', '107.09646381135548', '-6.322937570236813', 1, '2024-02-28 22:07:41', 'Aldo Fernando', '2024-02-28 22:07:47', 'Aldo Fernando');

-- --------------------------------------------------------

--
-- Struktur dari tabel `problem_delivery`
--

CREATE TABLE IF NOT EXISTS `problem_delivery` (
  `id_problem` int(11) NOT NULL AUTO_INCREMENT,
  `id_schedule` int(11) NOT NULL,
  `ins_dt` datetime DEFAULT NULL,
  `inst_usr` varchar(20) DEFAULT NULL,
  `lat` varchar(255) NOT NULL,
  `longi` varchar(255) NOT NULL,
  `bukti_foto` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  PRIMARY KEY (`id_problem`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=156 ;

--
-- Dumping data untuk tabel `problem_delivery`
--

INSERT INTO `problem_delivery` (`id_problem`, `id_schedule`, `ins_dt`, `inst_usr`, `lat`, `longi`, `bukti_foto`, `problem`) VALUES
(42, 1, '2024-03-04 05:04:32', '2', '-6.22592', '106.8302336', '../uploads/image_65e4f408a00fa.png', 'sadsadsa'),
(61, 4, '2024-03-05 16:56:36', '2', '-6.22592', '106.8302336', '../uploads/image_65e6ec6cdd1c2.png', 'jjjjjsad'),
(60, 1, '2024-03-05 16:51:24', '2', '-6.22592', '106.8302336', '../uploads/image_65e6eb3405498.png', 'dsdsadsa'),
(59, 1, '2024-03-05 16:27:53', '2', '-6.22592', '106.8302336', '../uploads/image_65e6e5b1a5d03.png', 'dsdsadsa'),
(58, 5, '2024-03-05 16:22:05', '2', '-6.22592', '106.8302336', '../uploads/image_65e6e455d4745.png', 'dadssadas'),
(57, 1, '2024-03-05 13:46:21', '2', '-6.22592', '106.8302336', '../uploads/image_65e6bfd54c916.png', 'Macet Mas'),
(56, 5, '2024-03-04 08:32:01', '2', '-6.22592', '106.8302336', '../uploads/image_65e524a9558e5.png', 'asdsadsa'),
(54, 5, '2024-03-04 08:31:13', '2', '-6.3107038', '107.100598', '../uploads/image_65e52479acf7e.png', 'dsadsadsa'),
(55, 5, '2024-03-04 08:31:47', '2', '-6.3107038', '107.100598', '../uploads/image_65e5249bb829e.png', 'dsadsadsa'),
(62, 4, '2024-03-05 17:00:51', '2', '-6.22592', '106.8302336', '../uploads/image_65e6ed6be4b9a.png', 'lhadskjhdsl'),
(63, 4, '2024-03-05 17:02:12', '2', '-6.22592', '106.8302336', '../uploads/image_65e6edbcc0a5c.png', 'lhadskjhdsl'),
(64, 5, '2024-03-05 17:02:58', '2', '-6.22592', '106.8302336', '../uploads/image_65e6edea8906a.png', 'asdsdsa'),
(65, 0, '2024-03-05 17:03:06', '2', '-6.22592', '106.8302336', '../uploads/image_65e6edf26dbb9.png', 'sadsad'),
(66, 0, '2024-03-05 17:03:11', '2', '-6.22592', '106.8302336', '../uploads/image_65e6edf7e1a7b.png', 'sadsad'),
(67, 0, '2024-03-05 17:06:03', '2', '-6.22592', '106.8302336', '../uploads/image_65e6eea3bda66.png', 'sadsad'),
(68, 5, '2024-03-05 17:13:15', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f0534ba7d.png', 'asdsdsa'),
(69, 5, '2024-03-05 17:13:36', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f0687309e.png', 'asdsdsa'),
(70, 5, '2024-03-05 17:24:04', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f2dcae7cc.png', 'asdsdsa'),
(71, 5, '2024-03-05 17:24:20', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f2ec8d11e.png', 'asdsdsa'),
(72, 1, '2024-03-05 17:26:14', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f35eefe81.png', 'lksadsad'),
(73, 1, '2024-03-05 17:26:43', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f37b65ce5.png', 'lksadsad'),
(74, 1, '2024-03-05 17:27:33', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f3ad94fba.png', 'lksadsad'),
(75, 1, '2024-03-05 17:27:42', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f3b647f4f.png', 'lksadsad'),
(76, 1, '2024-03-05 17:27:46', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f3ba19a6d.png', 'lksadsad'),
(77, 4, '2024-03-05 17:28:01', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f3c95d2d5.png', 'lhadskjhdsl'),
(78, 6, '2024-03-05 17:40:53', '2', '-6.1944491', '106.8229198', '../uploads/image_65e6f6cd6bcd0.png', 'sadsad'),
(79, 6, '2024-03-05 17:41:01', '2', '-6.1944491', '106.8229198', '../uploads/image_65e6f6d581755.png', 'sadsad'),
(80, 6, '2024-03-05 17:41:18', '2', '-6.1944491', '106.8229198', '../uploads/image_65e6f6e6933f0.png', 'zcxcasds'),
(81, 6, '2024-03-05 17:41:52', '2', '-6.1944491', '106.8229198', '../uploads/image_65e6f708a4d98.png', 'adaDSADSA'),
(82, 6, '2024-03-05 17:47:38', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f8628d616.png', 'ADSadas'),
(83, 6, '2024-03-05 17:49:29', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f8d13e3e6.png', 'ADSadas'),
(84, 6, '2024-03-05 17:49:45', '2', '-6.22592', '106.8302336', '../uploads/image_65e6f8e13810d.png', 'dsasd'),
(85, 5, '2024-03-05 18:10:37', '2', '-6.1944491', '106.8229198', '../uploads/image_65e6fdc5596cb.png', 'jlasdhjhdsaj'),
(86, 4, '2024-03-05 18:11:05', '2', '-6.1944491', '106.8229198', '../uploads/image_65e6fde178bc9.png', 'dshjsah'),
(87, 1, '2024-03-05 18:25:53', '2', '-6.1944491', '106.8229198', '../uploads/image_65e70159d40f0.png', 'skjkasdjkasj'),
(88, 6, '2024-03-05 19:31:33', '2', '-6.22592', '106.8302336', '../uploads/image_65e710bddc04b.png', 'kkashkhdsahjkdsh'),
(89, 4, '2024-03-05 19:31:43', '2', '-6.22592', '106.8302336', '../uploads/image_65e710c78d1f2.png', 'dsadsa'),
(90, 6, '2024-03-05 19:31:56', '2', '-6.22592', '106.8302336', '../uploads/image_65e710d4b0dc0.png', 'kkashkhdsahjkdsh'),
(91, 1, '2024-03-05 19:32:09', '2', '-6.1944491', '106.8229198', '../uploads/image_65e710e1a83f4.png', 'sddsadsadsa'),
(92, 5, '2024-03-05 19:32:25', '2', '-6.1944491', '106.8229198', '../uploads/image_65e710f1568f3.png', 'sdsadsadsa'),
(93, 1, '2024-03-05 22:56:13', '2', '-6.22592', '106.8302336', '../uploads/image_65e740b56d7c9.png', 'kjkaskjdjsa'),
(94, 4, '2024-03-05 23:33:33', '2', '-6.1944491', '106.8229198', '../uploads/image_65e74975b517e.png', 'dsadsa'),
(95, 6, '2024-03-05 23:44:09', '2', '-6.22592', '106.8302336', '../uploads/image_65e74bf18dca2.png', 'dsasadasdsa'),
(96, 6, '2024-03-05 23:44:33', '2', '-6.22592', '106.8302336', '../uploads/image_65e74c0977171.png', 'asdSADA'),
(97, 6, '2024-03-05 23:46:19', '2', '-6.22592', '106.8302336', '../uploads/image_65e74c739e67c.png', 'asdsadsa'),
(98, 6, '2024-03-05 23:49:58', '2', '-6.22592', '106.8302336', '../uploads/image_65e74d4e6a1c1.png', 'dsads'),
(99, 6, '2024-03-05 23:56:46', '2', '-6.22592', '106.8302336', '../uploads/image_65e74ee6eb2a0.png', 'asddsa'),
(100, 1, '2024-03-06 05:50:02', '2', '-6.1944491', '106.8229198', '../uploads/image_65e7a1b2611c2.png', 'dsadsa'),
(101, 1, '2024-03-06 05:54:37', '2', '-6.1944491', '106.8229198', '../uploads/image_65e7a2c5049c4.png', 'dsadsa'),
(102, 1, '2024-03-06 05:54:40', '2', '-6.1944491', '106.8229198', '../uploads/image_65e7a2c8bb287.png', 'dsadsa'),
(103, 5, '2024-03-06 05:55:05', '2', '-6.1944491', '106.8229198', '../uploads/image_65e7a2e1123c2.png', 'asdasd'),
(104, 6, '2024-03-06 05:55:35', '2', '-6.1944491', '106.8229198', '../uploads/image_65e7a2ffc7bc1.png', 'dsadsadsa'),
(105, 1, '2024-03-06 07:35:28', '2', '-6.3107105', '107.1005807', '../uploads/image_65e7ba68eaba6.png', 'sddsdsa'),
(106, 4, '2024-03-06 07:36:07', '2', '-6.3107176', '107.1005938', '../uploads/image_65e7ba8f42ac1.png', 'adADa'),
(117, 0, '2024-03-06 10:57:47', '2', '-6.3203199', '107.0893914', '../uploads/image_65e7e9d3ad029.png', 'adsadsa'),
(116, 6, '2024-03-06 10:35:44', '2', '-6.3203199', '107.0893914', '../uploads/image_65e7e4a861a59.png', 'sadsadsa'),
(115, 5, '2024-03-06 10:32:23', '2', '-6.3203199', '107.0893914', '../uploads/image_65e7e3df7bef6.png', 'dsadsa'),
(118, 0, '2024-03-06 10:57:57', '2', '-6.3203199', '107.0893914', '../uploads/image_65e7e9dd0358d.png', 'adsadsa'),
(119, 0, '2024-03-06 10:59:47', '2', '-6.3203199', '107.0893914', '../uploads/image_65e7ea4b178fa.png', 'Macet MAs'),
(120, 4, '2024-03-06 11:17:15', '2', '-6.3107207', '107.1006124', '../uploads/image_65e7ee631f33d.png', 'Macet di daerah sunter'),
(121, 1, '2024-03-06 12:04:00', '2', '-6.3107093', '107.1005912', '../uploads/image_65e7f958e69ca.png', 'Macet Mas'),
(122, 1, '2024-03-06 12:04:08', '2', '-6.3107093', '107.1005912', '../uploads/image_65e7f9607030e.png', 'Macet Mas'),
(123, 5, '2024-03-06 12:05:01', '2', '-6.3107093', '107.1005912', '../uploads/image_65e7f9952c4a9.png', 'Ban Bocor Ya Mas'),
(124, 6, '2024-03-06 12:05:43', '2', '-6.3107093', '107.1005912', '../uploads/image_65e7f9bfb7be2.png', 'Lempuyangan Macet'),
(125, 1, '2024-03-06 13:38:28', '2', '-6.3107072', '107.1005976', '../uploads/image_65e80f7c9b92f.png', 'sdsadsa'),
(126, 1, '2024-03-06 13:50:54', '2', '-6.3107072', '107.1005976', '../uploads/image_65e81266a5ccc.png', 'sdsadsa'),
(127, 5, '2024-03-06 13:57:41', '2', '-6.3107301', '107.1006215', '../uploads/image_65e813fdee183.png', 'dsadsadsad'),
(128, 4, '2024-03-06 14:39:34', '2', '-6.3107301', '107.1006215', '../uploads/image_65e81dceda0c2.png', 'dsdsadsa'),
(129, 6, '2024-03-06 15:07:08', '2', '-6.3107375', '107.1006349', '../uploads/image_65e824449268f.png', 'Macet Mas'),
(130, 5, '2024-03-06 15:30:27', '2', '-6.3107375', '107.1006349', '../uploads/image_65e829bb259c4.png', 'Macet Mas'),
(131, 1, '2024-03-06 15:37:34', '2', '-6.3107375', '107.1006349', '../uploads/image_65e82b66c8dee.png', 'Tangerang Macet Mas'),
(132, 4, '2024-03-06 15:50:39', '2', '-6.3107221', '107.1006098', '../uploads/image_65e82e77ddfc2.png', 'Macet mas'),
(133, 1, '2024-03-07 07:38:35', '2', '-6.3107172', '107.1006013', '../uploads/image_65e90ca33d137.png', 'Macet Mas'),
(134, 4, '2024-03-07 08:48:05', '2', '-6.3209389', '107.0893913', '../uploads/image_65e91cedc4a91.png', 'aDadADS'),
(135, 5, '2024-03-07 09:17:50', '2', '-6.3209389', '107.0893913', '../uploads/image_65e923e687ced.png', 'Aasdsa'),
(136, 4, '2024-03-07 09:52:33', '2', '-6.3107174', '107.1006063', '../uploads/image_65e92c095339a.png', 'Halo'),
(137, 4, '2024-03-07 11:31:25', '2', '-6.3209389', '107.0893913', '../uploads/image_65e943351300a.png', 'sadsadsa'),
(138, 5, '2024-03-07 12:01:28', '2', '-6.3209389', '107.0893913', '../uploads/image_65e94a4037f07.png', 'dsadsadsa'),
(139, 5, '2024-03-07 12:04:40', '2', '-6.3209389', '107.0893913', '../uploads/image_65e94b002ec6f.png', 'dsadsadsa'),
(140, 4, '2024-03-07 12:51:56', '2', '-6.3107174', '107.1006063', '../uploads/image_65e956145b353.png', 'dADSASSAAS'),
(141, 6, '2024-03-08 13:34:35', '2', '-6.3203199', '107.0893914', '../uploads/image_65eab19345f84.png', 'Macet mas Di daerah mm 2100'),
(142, 6, '2024-03-08 15:11:15', '2', '-6.3203199', '107.0893914', '../uploads/image_65eac83bbee5e.png', 'Macet Mas'),
(143, 5, '2024-03-09 11:15:39', '2', '-6.9173248', '107.610112', '../uploads/image_65ebe283c9312.png', 'Masih Ngopi Mas'),
(144, 5, '2024-03-12 07:45:15', '2', '-6.3107134', '107.1005939', '../uploads/image_65efa5b3e3c06.png', 'Macet Mas'),
(145, 5, '2024-03-12 07:45:36', '2', '-6.3107134', '107.1005939', '../uploads/image_65efa5c821e0f.png', 'Macet Mas'),
(146, 5, '2024-03-12 07:47:02', '2', '-6.3107134', '107.1005939', '../uploads/image_65efa61e796f8.png', 'Macet Mas'),
(150, 4, '2024-03-12 10:07:19', '2', '-6.3172135', '107.1093267', '../uploads/image_65efc6ff14273.png', 'Macet Mas'),
(151, 5, '2024-03-12 10:14:41', '2', '-6.3172135', '107.1093267', '../uploads/image_65efc8b977405.png', 'Madet Mas'),
(149, 5, '2024-03-12 07:51:52', '2', '-6.3107134', '107.1005939', '../uploads/image_65efa7408b566.png', 'sadas'),
(152, 5, '2024-03-12 11:44:12', '2', '-6.3203199', '107.0893914', '../uploads/image_65efddb45c6b4.png', 'Pakeee'),
(153, 5, '2024-03-12 11:59:07', '2', '-6.3203199', '107.0893914', '../uploads/image_65efe13330d67.png', 'Macet Mas'),
(154, 5, '2024-03-12 13:58:06', '2', '-6.3172135', '107.1093267', '../uploads/image_65effd16cc614.png', 'Macet'),
(155, 5, '2024-03-14 09:02:21', '2', '-6.3203199', '107.0893914', '../uploads/image_65f25ac524601.png', 'Macet Mas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule_delivery`
--

CREATE TABLE IF NOT EXISTS `schedule_delivery` (
  `id_schedule` int(10) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `bpid` varchar(20) NOT NULL,
  `cycle` varchar(20) NOT NULL,
  `dock_customer` varchar(20) NOT NULL,
  `dock_kybi` varchar(20) NOT NULL,
  `plan_arrival` datetime NOT NULL,
  `waktu` time NOT NULL,
  `qty_palet` int(10) NOT NULL,
  `ins_dt` datetime NOT NULL,
  PRIMARY KEY (`id_schedule`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `schedule_delivery`
--

INSERT INTO `schedule_delivery` (`id_schedule`, `tanggal`, `bpid`, `cycle`, `dock_customer`, `dock_kybi`, `plan_arrival`, `waktu`, `qty_palet`, `ins_dt`) VALUES
(1, '2024-02-26', 'CLIDTAM50', '1', 'TAMGP', 'DOCK 3', '2024-03-18 15:01:16', '07:38:47', 18, '2024-02-26 12:01:35'),
(5, '2024-03-10', 'CLIDTAM51', '2', 'TAMGP', 'DOCK 3', '2024-03-10 22:03:38', '11:15:38', 20, '2024-02-28 22:03:53'),
(4, '2024-03-08', 'CLIDTAM51', '2', 'TAMGP', 'DOCK 3', '2024-03-25 16:00:00', '12:52:03', 20, '2024-02-28 14:01:07'),
(6, '2024-03-29', 'CLIDTAM51', '2', 'TAMGP', 'DOCK 3', '2024-03-12 08:33:27', '15:11:22', 20, '2024-03-01 08:33:40'),
(7, '2024-03-29', 'CLIDTAM50', '2', 'TAMGP', 'DOCK 3', '2024-03-18 19:00:00', '06:36:25', 20, '2024-03-12 08:36:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifikasi_delivery`
--

CREATE TABLE IF NOT EXISTS `verifikasi_delivery` (
  `id_verifikasi` int(10) NOT NULL AUTO_INCREMENT,
  `id_schedule` int(10) NOT NULL,
  `id_driver` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `actual_arrival` datetime DEFAULT NULL,
  `longi` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `bukti_foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id_verifikasi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data untuk tabel `verifikasi_delivery`
--

INSERT INTO `verifikasi_delivery` (`id_verifikasi`, `id_schedule`, `id_driver`, `status`, `actual_arrival`, `longi`, `lat`, `bukti_foto`) VALUES
(40, 5, 2, 0, '2024-03-12 08:27:42', '107.0893914', '-6.3203199', '../uploads/image_65efafa6caca3.png'),
(46, 7, 2, 0, '2024-03-28 08:38:24', '107.09646381135548', '-6.308498398070111', ''),
(43, 6, 2, 1, '2024-03-12 08:19:00', '107.0893914', '-6.3203199', '../uploads/image_65efad9c90b80.png'),
(44, 4, 2, 0, '2024-03-07 13:24:44', '107.0893913', '-6.3209389', '../uploads/image_65e95dc4df1a6.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
