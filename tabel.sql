-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 20, 2021 at 08:29 AM
-- Server version: 8.0.22-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wpsipdkrw`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_akun`
--

DROP TABLE IF EXISTS `data_akun`;
CREATE TABLE `data_akun` (
  `id` int NOT NULL,
  `belanja` varchar(10) NOT NULL,
  `id_akun` int NOT NULL,
  `is_bagi_hasil` tinyint NOT NULL,
  `is_bankeu_khusus` tinyint NOT NULL,
  `is_bankeu_umum` tinyint NOT NULL,
  `is_barjas` tinyint NOT NULL,
  `is_bl` tinyint NOT NULL,
  `is_bos` tinyint NOT NULL,
  `is_btt` tinyint NOT NULL,
  `is_bunga` tinyint NOT NULL,
  `is_gaji_asn` tinyint NOT NULL,
  `is_hibah_brg` tinyint NOT NULL,
  `is_hibah_uang` tinyint NOT NULL,
  `is_locked` tinyint NOT NULL,
  `is_modal_tanah` tinyint NOT NULL,
  `is_pembiayaan` tinyint NOT NULL,
  `is_pendapatan` tinyint NOT NULL,
  `is_sosial_brg` tinyint NOT NULL,
  `is_sosial_uang` tinyint NOT NULL,
  `is_subsidi` tinyint NOT NULL,
  `kode_akun` varchar(50) NOT NULL,
  `nama_akun` text NOT NULL,
  `set_input` tinyint NOT NULL,
  `set_lokus` tinyint DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_akun`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_alamat`
--

DROP TABLE IF EXISTS `data_alamat`;
CREATE TABLE `data_alamat` (
  `id` int NOT NULL,
  `id_alamat` int NOT NULL,
  `nama` text NOT NULL,
  `id_prov` int NOT NULL,
  `id_kab` int NOT NULL,
  `id_kec` int NOT NULL,
  `is_prov` tinyint NOT NULL,
  `is_kab` tinyint NOT NULL,
  `is_kec` tinyint NOT NULL,
  `is_kel` tinyint NOT NULL,
  `updated_at` datetime NOT NULL,
  `tahun` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_alamat`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_anggaran_kas`
--

DROP TABLE IF EXISTS `data_anggaran_kas`;
CREATE TABLE `data_anggaran_kas` (
  `id` int NOT NULL,
  `bulan_1` double DEFAULT NULL,
  `bulan_2` double DEFAULT NULL,
  `bulan_3` double DEFAULT NULL,
  `bulan_4` double DEFAULT NULL,
  `bulan_5` double DEFAULT NULL,
  `bulan_6` double DEFAULT NULL,
  `bulan_7` double DEFAULT NULL,
  `bulan_8` double DEFAULT NULL,
  `bulan_9` double DEFAULT NULL,
  `bulan_10` double DEFAULT NULL,
  `bulan_11` double DEFAULT NULL,
  `bulan_12` double DEFAULT NULL,
  `id_akun` int DEFAULT NULL,
  `id_bidang_urusan` int DEFAULT NULL,
  `id_daerah` int DEFAULT NULL,
  `id_giat` int DEFAULT NULL,
  `id_program` int DEFAULT NULL,
  `id_skpd` int DEFAULT NULL,
  `id_sub_giat` int DEFAULT NULL,
  `id_sub_skpd` int DEFAULT NULL,
  `id_unit` int DEFAULT NULL,
  `kode_akun` varchar(50) DEFAULT NULL,
  `nama_akun` text,
  `selisih` double DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `total_akb` double DEFAULT NULL,
  `total_rincian` double DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `tahun_anggaran` year NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_anggaran_kas`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_capaian_prog_sub_keg`
--

DROP TABLE IF EXISTS `data_capaian_prog_sub_keg`;
CREATE TABLE `data_capaian_prog_sub_keg` (
  `id` int NOT NULL,
  `satuancapaian` varchar(50) DEFAULT NULL,
  `targetcapaianteks` varchar(50) DEFAULT NULL,
  `capaianteks` text,
  `targetcapaian` int DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_capaian_prog_sub_keg`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_dana_sub_keg`
--

DROP TABLE IF EXISTS `data_dana_sub_keg`;
CREATE TABLE `data_dana_sub_keg` (
  `id` int NOT NULL,
  `namadana` varchar(50) DEFAULT NULL,
  `kodedana` varchar(50) DEFAULT NULL,
  `iddana` int DEFAULT NULL,
  `iddanasubbl` int DEFAULT NULL,
  `pagudana` double(20,0) DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_dana_sub_keg`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_desa_kelurahan`
--

DROP TABLE IF EXISTS `data_desa_kelurahan`;
CREATE TABLE `data_desa_kelurahan` (
  `id` int NOT NULL,
  `camat_teks` varchar(50) DEFAULT NULL,
  `id_camat` int DEFAULT NULL,
  `id_daerah` int DEFAULT NULL,
  `id_level` varchar(50) DEFAULT NULL,
  `id_lurah` int DEFAULT NULL,
  `id_profil` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `is_desa` tinyint DEFAULT NULL,
  `is_locked` tinyint DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `jenis` int DEFAULT NULL,
  `kab_kota` varchar(50) DEFAULT NULL,
  `kode_lurah` varchar(50) DEFAULT NULL,
  `login_name` varchar(50) DEFAULT NULL,
  `lurah_teks` varchar(50) DEFAULT NULL,
  `nama_daerah` varchar(50) DEFAULT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `accasmas` tinyint DEFAULT NULL,
  `accbankeu` tinyint DEFAULT NULL,
  `accdisposisi` tinyint DEFAULT NULL,
  `accgiat` tinyint DEFAULT NULL,
  `acchibah` tinyint DEFAULT NULL,
  `accinput` tinyint DEFAULT NULL,
  `accjadwal` tinyint DEFAULT NULL,
  `acckunci` tinyint DEFAULT NULL,
  `accmaster` tinyint DEFAULT NULL,
  `accspv` tinyint DEFAULT NULL,
  `accunit` tinyint DEFAULT NULL,
  `accusulan` tinyint DEFAULT NULL,
  `alamatteks` text,
  `camatteks` varchar(50) DEFAULT NULL,
  `daerahpengusul` varchar(50) DEFAULT NULL,
  `dapil` varchar(50) DEFAULT NULL,
  `emailteks` varchar(50) DEFAULT NULL,
  `fraksi` varchar(50) DEFAULT NULL,
  `idcamat` int DEFAULT NULL,
  `iddaerahpengusul` int DEFAULT NULL,
  `idkabkota` int DEFAULT NULL,
  `idlevel` int DEFAULT NULL,
  `idlokasidesa` int DEFAULT NULL,
  `idlurah` int DEFAULT NULL,
  `idlurahpengusul` int DEFAULT NULL,
  `idprofil` int DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `loginname` varchar(50) DEFAULT NULL,
  `lokasidesateks` varchar(50) DEFAULT NULL,
  `lurahteks` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `namapengusul` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `notelp` varchar(50) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_desa_kelurahan`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_dewan`
--

DROP TABLE IF EXISTS `data_dewan`;
CREATE TABLE `data_dewan` (
  `id` int NOT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `accasmas` tinyint DEFAULT NULL,
  `accbankeu` tinyint DEFAULT NULL,
  `accdisposisi` tinyint DEFAULT NULL,
  `accgiat` tinyint DEFAULT NULL,
  `acchibah` tinyint DEFAULT NULL,
  `accinput` tinyint DEFAULT NULL,
  `accjadwal` tinyint DEFAULT NULL,
  `acckunci` tinyint DEFAULT NULL,
  `accmaster` tinyint DEFAULT NULL,
  `accspv` tinyint DEFAULT NULL,
  `accunit` tinyint DEFAULT NULL,
  `accusulan` tinyint DEFAULT NULL,
  `alamatteks` text,
  `camatteks` varchar(50) DEFAULT NULL,
  `daerahpengusul` varchar(50) DEFAULT NULL,
  `dapil` varchar(50) DEFAULT NULL,
  `emailteks` varchar(50) DEFAULT NULL,
  `fraksi` varchar(50) DEFAULT NULL,
  `idcamat` int DEFAULT NULL,
  `iddaerahpengusul` int DEFAULT NULL,
  `idkabkota` int DEFAULT NULL,
  `idlevel` int DEFAULT NULL,
  `idlokasidesa` int DEFAULT NULL,
  `idlurah` int DEFAULT NULL,
  `idlurahpengusul` int DEFAULT NULL,
  `idprofil` int DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `loginname` varchar(50) DEFAULT NULL,
  `lokasidesateks` varchar(50) DEFAULT NULL,
  `lurahteks` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `namapengusul` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `notelp` varchar(50) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_dewan`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_keg_indikator_hasil`
--

DROP TABLE IF EXISTS `data_keg_indikator_hasil`;
CREATE TABLE `data_keg_indikator_hasil` (
  `id` int NOT NULL,
  `hasilteks` text,
  `satuanhasil` varchar(50) DEFAULT NULL,
  `targethasil` varchar(50) DEFAULT NULL,
  `targethasilteks` varchar(50) DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` varchar(50) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_keg_indikator_hasil`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_lokasi_sub_keg`
--

DROP TABLE IF EXISTS `data_lokasi_sub_keg`;
CREATE TABLE `data_lokasi_sub_keg` (
  `id` int NOT NULL,
  `camatteks` text,
  `daerahteks` text,
  `idcamat` int DEFAULT NULL,
  `iddetillokasi` double DEFAULT NULL,
  `idkabkota` int DEFAULT NULL,
  `idlurah` int DEFAULT NULL,
  `lurahteks` text,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` int DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_lokasi_sub_keg`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_output_giat_sub_keg`
--

DROP TABLE IF EXISTS `data_output_giat_sub_keg`;
CREATE TABLE `data_output_giat_sub_keg` (
  `id` int NOT NULL,
  `outputteks` text,
  `satuanoutput` varchar(50) DEFAULT NULL,
  `targetoutput` int DEFAULT NULL,
  `targetoutputteks` varchar(50) DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_output_giat_sub_keg`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_pembiayaan`
--

DROP TABLE IF EXISTS `data_pembiayaan`;
CREATE TABLE `data_pembiayaan` (
  `id` int NOT NULL,
  `created_user` int DEFAULT NULL,
  `createddate` varchar(50) DEFAULT NULL,
  `createdtime` varchar(50) DEFAULT NULL,
  `id_pembiayaan` int DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `kode_akun` varchar(50) DEFAULT NULL,
  `nama_akun` text,
  `nilaimurni` int DEFAULT NULL,
  `program_koordinator` int DEFAULT NULL,
  `rekening` text,
  `skpd_koordinator` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  `updated_user` int DEFAULT NULL,
  `updateddate` varchar(50) DEFAULT NULL,
  `updatedtime` varchar(50) DEFAULT NULL,
  `uraian` text,
  `urusan_koordinator` int DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `user1` varchar(50) DEFAULT NULL,
  `user2` varchar(50) DEFAULT NULL,
  `id_skpd` int DEFAULT NULL,
  `active` tinyint NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_pembiayaan`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_pendapatan`
--

DROP TABLE IF EXISTS `data_pendapatan`;
CREATE TABLE `data_pendapatan` (
  `id` int NOT NULL,
  `created_user` int DEFAULT NULL,
  `createddate` varchar(50) DEFAULT NULL,
  `createdtime` varchar(50) DEFAULT NULL,
  `id_pendapatan` int DEFAULT NULL,
  `keterangan` text,
  `kode_akun` varchar(50) DEFAULT NULL,
  `nama_akun` text,
  `nilaimurni` int DEFAULT NULL,
  `program_koordinator` int DEFAULT NULL,
  `rekening` text,
  `skpd_koordinator` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  `updated_user` int DEFAULT NULL,
  `updateddate` varchar(50) DEFAULT NULL,
  `updatedtime` varchar(50) DEFAULT NULL,
  `uraian` text,
  `urusan_koordinator` int DEFAULT NULL,
  `user1` varchar(50) DEFAULT NULL,
  `user2` varchar(50) DEFAULT NULL,
  `id_skpd` int DEFAULT NULL,
  `active` tinyint NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_pendapatan`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_pengaturan_sipd`
--

DROP TABLE IF EXISTS `data_pengaturan_sipd`;
CREATE TABLE `data_pengaturan_sipd` (
  `id` int NOT NULL,
  `daerah` text,
  `kepala_daerah` text,
  `wakil_kepala_daerah` text,
  `awal_rpjmd` year DEFAULT NULL,
  `akhir_rpjmd` year DEFAULT NULL,
  `pelaksana_rkpd` tinyint DEFAULT NULL,
  `pelaksana_kua` tinyint DEFAULT NULL,
  `pelaksana_apbd` tinyint DEFAULT NULL,
  `set_kpa_sekda` tinyint DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_pengaturan_sipd`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_profile_penerima_bantuan`
--

DROP TABLE IF EXISTS `data_profile_penerima_bantuan`;
CREATE TABLE `data_profile_penerima_bantuan` (
  `id` int NOT NULL,
  `id_profil` int NOT NULL,
  `nama_teks` text NOT NULL,
  `alamat_teks` text NOT NULL,
  `jenis_penerima` text NOT NULL,
  `updated_at` datetime NOT NULL,
  `tahun` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_profile_penerima_bantuan`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_prog_keg`
--

DROP TABLE IF EXISTS `data_prog_keg`;
CREATE TABLE `data_prog_keg` (
  `id` int NOT NULL,
  `id_urusan` int NOT NULL,
  `id_bidang_urusan` int NOT NULL,
  `id_program` int NOT NULL,
  `id_giat` int NOT NULL,
  `id_sub_giat` int NOT NULL,
  `is_locked` int NOT NULL,
  `kode_bidang_urusan` varchar(50) NOT NULL,
  `kode_giat` varchar(50) NOT NULL,
  `kode_program` varchar(50) NOT NULL,
  `kode_sub_giat` varchar(50) NOT NULL,
  `kode_urusan` varchar(50) NOT NULL,
  `nama_bidang_urusan` text NOT NULL,
  `nama_giat` text NOT NULL,
  `nama_program` text NOT NULL,
  `nama_sub_giat` text NOT NULL,
  `nama_urusan` text NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_prog_keg`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_renstra`
--

DROP TABLE IF EXISTS `data_renstra`;
CREATE TABLE `data_renstra` (
  `id` int NOT NULL,
  `id_bidang_urusan` int DEFAULT NULL,
  `id_giat` int DEFAULT NULL,
  `id_program` int DEFAULT NULL,
  `id_renstra` int DEFAULT NULL,
  `id_rpjmd` int DEFAULT NULL,
  `id_sub_giat` int DEFAULT NULL,
  `id_unit` int DEFAULT NULL,
  `indikator` text,
  `indikator_sub` text,
  `is_locked` tinyint DEFAULT NULL,
  `kebijakan_teks` text,
  `kode_bidang_urusan` varchar(50) DEFAULT NULL,
  `kode_giat` varchar(50) DEFAULT NULL,
  `kode_program` varchar(50) DEFAULT NULL,
  `kode_skpd` varchar(50) DEFAULT NULL,
  `kode_sub_giat` varchar(50) DEFAULT NULL,
  `misi_teks` text,
  `nama_bidang_urusan` text,
  `nama_giat` text,
  `nama_program` text,
  `nama_skpd` text,
  `nama_sub_giat` text,
  `outcome` text,
  `pagu_1` double DEFAULT NULL,
  `pagu_2` double DEFAULT NULL,
  `pagu_3` double DEFAULT NULL,
  `pagu_4` double DEFAULT NULL,
  `pagu_5` double DEFAULT NULL,
  `pagu_sub_1` double DEFAULT NULL,
  `pagu_sub_2` double DEFAULT NULL,
  `pagu_sub_3` double DEFAULT NULL,
  `pagu_sub_4` double DEFAULT NULL,
  `pagu_sub_5` double DEFAULT NULL,
  `sasaran_teks` text,
  `satuan` varchar(50) DEFAULT NULL,
  `satuan_sub` varchar(50) DEFAULT NULL,
  `strategi_teks` text,
  `target_1` text,
  `target_2` text,
  `target_3` text,
  `target_4` text,
  `target_5` text,
  `target_sub_1` text,
  `target_sub_2` text,
  `target_sub_3` text,
  `target_sub_4` text,
  `target_sub_5` text,
  `tujuan_teks` text,
  `visi_teks` text,
  `active` tinyint NOT NULL DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_renstra`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_rka`
--

DROP TABLE IF EXISTS `data_rka`;
CREATE TABLE `data_rka` (
  `id` int NOT NULL,
  `created_user` int DEFAULT NULL,
  `createddate` varchar(10) DEFAULT NULL,
  `createdtime` varchar(10) DEFAULT NULL,
  `harga_satuan` double(20,0) NOT NULL,
  `id_daerah` int NOT NULL,
  `id_rinci_sub_bl` int NOT NULL,
  `id_standar_nfs` tinyint DEFAULT NULL,
  `is_locked` tinyint DEFAULT NULL,
  `jenis_bl` varchar(50) NOT NULL,
  `ket_bl_teks` text NOT NULL,
  `kode_akun` varchar(50) NOT NULL,
  `koefisien` text NOT NULL,
  `lokus_akun_teks` text NOT NULL,
  `nama_akun` text NOT NULL,
  `nama_komponen` text NOT NULL,
  `spek_komponen` text NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `spek` text NOT NULL,
  `sat1` text,
  `sat2` text,
  `sat3` text,
  `sat4` text,
  `volum1` text,
  `volum2` text,
  `volum3` text,
  `volum4` text,
  `subs_bl_teks` text NOT NULL,
  `total_harga` double(20,0) DEFAULT NULL,
  `rincian` double(20,0) NOT NULL,
  `totalpajak` double(20,0) NOT NULL,
  `updated_user` int DEFAULT NULL,
  `updateddate` varchar(20) DEFAULT NULL,
  `updatedtime` varchar(20) DEFAULT NULL,
  `user1` varchar(50) DEFAULT NULL,
  `user2` varchar(50) DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021',
  `idbl` int DEFAULT NULL,
  `idsubbl` int DEFAULT NULL,
  `kode_bl` varchar(50) NOT NULL,
  `kode_sbl` varchar(50) NOT NULL,
  `id_prop_penerima` int DEFAULT NULL,
  `id_camat_penerima` int DEFAULT NULL,
  `id_kokab_penerima` int DEFAULT NULL,
  `id_lurah_penerima` int DEFAULT NULL,
  `id_penerima` int DEFAULT NULL,
  `idkomponen` double(20,0) DEFAULT NULL,
  `idketerangan` int DEFAULT NULL,
  `idsubtitle` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_rka`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_rpjmd`
--

DROP TABLE IF EXISTS `data_rpjmd`;
CREATE TABLE `data_rpjmd` (
  `id` int NOT NULL,
  `id_bidang_urusan` int NOT NULL,
  `id_program` int NOT NULL,
  `id_rpjmd` int NOT NULL,
  `indikator` text NOT NULL,
  `kebijakan_teks` text NOT NULL,
  `kode_bidang_urusan` varchar(50) NOT NULL,
  `kode_program` varchar(50) NOT NULL,
  `kode_skpd` varchar(50) DEFAULT NULL,
  `misi_teks` text NOT NULL,
  `nama_bidang_urusan` varchar(100) NOT NULL,
  `nama_program` text NOT NULL,
  `nama_skpd` text NOT NULL,
  `pagu_1` varchar(50) NOT NULL,
  `pagu_2` varchar(50) NOT NULL,
  `pagu_3` varchar(50) NOT NULL,
  `pagu_4` varchar(50) NOT NULL,
  `pagu_5` varchar(50) NOT NULL,
  `sasaran_teks` text NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `strategi_teks` text NOT NULL,
  `target_1` varchar(50) NOT NULL,
  `target_2` varchar(50) NOT NULL,
  `target_3` varchar(50) NOT NULL,
  `target_4` varchar(50) NOT NULL,
  `target_5` varchar(50) NOT NULL,
  `tujuan_teks` text NOT NULL,
  `visi_teks` text NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_rpjmd`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_ssh`
--

DROP TABLE IF EXISTS `data_ssh`;
CREATE TABLE `data_ssh` (
  `id` int NOT NULL,
  `id_standar_harga` int NOT NULL,
  `kode_standar_harga` varchar(30) NOT NULL,
  `nama_standar_harga` text NOT NULL,
  `satuan` text NOT NULL,
  `spek` text NOT NULL,
  `is_deleted` tinyint NOT NULL,
  `is_locked` tinyint NOT NULL,
  `kelompok` tinyint NOT NULL,
  `harga` double(20,0) NOT NULL,
  `kode_kel_standar_harga` varchar(30) NOT NULL,
  `nama_kel_standar_harga` text NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2020'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_ssh`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_ssh_rek_belanja`
--

DROP TABLE IF EXISTS `data_ssh_rek_belanja`;
CREATE TABLE `data_ssh_rek_belanja` (
  `id` int NOT NULL,
  `id_akun` int NOT NULL,
  `kode_akun` varchar(50) NOT NULL,
  `nama_akun` text NOT NULL,
  `id_standar_harga` int NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_ssh_rek_belanja`:
--   `id_standar_harga`
--       `data_ssh` -> `id_standar_harga`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_sub_keg_bl`
--

DROP TABLE IF EXISTS `data_sub_keg_bl`;
CREATE TABLE `data_sub_keg_bl` (
  `id` int NOT NULL,
  `id_sub_skpd` int NOT NULL,
  `id_lokasi` int DEFAULT NULL,
  `id_label_kokab` int NOT NULL,
  `nama_dana` text,
  `no_sub_giat` varchar(20) NOT NULL,
  `kode_giat` varchar(50) NOT NULL,
  `id_program` int NOT NULL,
  `nama_lokasi` text,
  `waktu_akhir` int NOT NULL,
  `pagu_n_lalu` double(20,0) DEFAULT NULL,
  `id_urusan` int NOT NULL,
  `id_unik_sub_bl` text NOT NULL,
  `id_sub_giat` int NOT NULL,
  `label_prov` text,
  `kode_program` varchar(50) NOT NULL,
  `kode_sub_giat` varchar(50) NOT NULL,
  `no_program` varchar(20) NOT NULL,
  `kode_urusan` varchar(20) NOT NULL,
  `kode_bidang_urusan` varchar(20) NOT NULL,
  `nama_program` text NOT NULL,
  `target_4` text,
  `target_5` text,
  `id_bidang_urusan` int DEFAULT NULL,
  `nama_bidang_urusan` text,
  `target_3` text,
  `no_giat` varchar(50) NOT NULL,
  `id_label_prov` int NOT NULL,
  `waktu_awal` int NOT NULL,
  `pagu` double(20,0) NOT NULL,
  `output_sub_giat` text,
  `sasaran` text,
  `indikator` text,
  `id_dana` int DEFAULT NULL,
  `nama_sub_giat` text NOT NULL,
  `pagu_n_depan` double(20,0) NOT NULL,
  `satuan` text,
  `id_rpjmd` int NOT NULL,
  `id_giat` int NOT NULL,
  `id_label_pusat` int NOT NULL,
  `nama_giat` text NOT NULL,
  `kode_skpd` varchar(50) NOT NULL,
  `nama_skpd` text NOT NULL,
  `kode_sub_skpd` varchar(50) NOT NULL,
  `id_skpd` int NOT NULL,
  `id_sub_bl` int DEFAULT NULL,
  `nama_sub_skpd` text NOT NULL,
  `target_1` text,
  `nama_urusan` text NOT NULL,
  `target_2` text,
  `label_kokab` text,
  `label_pusat` text,
  `pagu_keg` double(20,0) NOT NULL,
  `id_bl` int DEFAULT NULL,
  `kode_bl` varchar(50) NOT NULL,
  `kode_sbl` varchar(50) NOT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_sub_keg_bl`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_sub_keg_indikator`
--

DROP TABLE IF EXISTS `data_sub_keg_indikator`;
CREATE TABLE `data_sub_keg_indikator` (
  `id` int NOT NULL,
  `outputteks` text NOT NULL,
  `targetoutput` int NOT NULL,
  `satuanoutput` text NOT NULL,
  `idoutputbl` int NOT NULL,
  `targetoutputteks` text NOT NULL,
  `kode_sbl` varchar(50) NOT NULL,
  `idsubbl` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_sub_keg_indikator`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_sumber_dana`
--

DROP TABLE IF EXISTS `data_sumber_dana`;
CREATE TABLE `data_sumber_dana` (
  `id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `created_user` int NOT NULL,
  `id_daerah` int NOT NULL,
  `id_dana` int NOT NULL,
  `id_unik` text NOT NULL,
  `is_locked` int NOT NULL,
  `kode_dana` varchar(50) NOT NULL,
  `nama_dana` text NOT NULL,
  `set_input` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `tahun` year NOT NULL DEFAULT '2021',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int NOT NULL DEFAULT '0',
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_sumber_dana`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_tag_sub_keg`
--

DROP TABLE IF EXISTS `data_tag_sub_keg`;
CREATE TABLE `data_tag_sub_keg` (
  `id` int NOT NULL,
  `idlabelgiat` int DEFAULT NULL,
  `namalabel` varchar(50) DEFAULT NULL,
  `idtagbl` int DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_tag_sub_keg`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_unit`
--

DROP TABLE IF EXISTS `data_unit`;
CREATE TABLE `data_unit` (
  `id` int NOT NULL,
  `id_setup_unit` int DEFAULT NULL COMMENT '0 jika bukan induk rka',
  `id_skpd` int DEFAULT NULL,
  `id_unit` int DEFAULT NULL,
  `is_skpd` smallint DEFAULT NULL,
  `kode_skpd` varchar(30) NOT NULL,
  `kunci_skpd` smallint DEFAULT NULL,
  `nama_skpd` text NOT NULL,
  `posisi` text NOT NULL,
  `status` varchar(25) NOT NULL,
  `bidur_1` smallint NOT NULL,
  `bidur_2` smallint DEFAULT NULL,
  `bidur_3` smallint DEFAULT NULL,
  `idinduk` int NOT NULL COMMENT 'jika setup unit = 0 maka induk rka = induk organisasi',
  `ispendapatan` tinyint NOT NULL,
  `isskpd` tinyint NOT NULL,
  `kode_skpd_1` varchar(10) NOT NULL,
  `kode_skpd_2` varchar(10) NOT NULL,
  `kodeunit` varchar(30) NOT NULL,
  `komisi` int DEFAULT NULL,
  `namabendahara` text,
  `namakepala` text NOT NULL,
  `namaunit` text NOT NULL,
  `nipbendahara` varchar(30) DEFAULT NULL,
  `nipkepala` varchar(30) NOT NULL,
  `pangkatkepala` varchar(50) NOT NULL,
  `setupunit` int NOT NULL,
  `statuskepala` varchar(20) NOT NULL,
  `active` smallint NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_unit`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_unit_pagu`
--

DROP TABLE IF EXISTS `data_unit_pagu`;
CREATE TABLE `data_unit_pagu` (
  `id` int NOT NULL,
  `batasanpagu` double(20,0) NOT NULL,
  `id_daerah` int NOT NULL,
  `id_level` int DEFAULT NULL,
  `id_skpd` int NOT NULL,
  `id_unit` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `is_anggaran` int DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `is_komponen` int DEFAULT NULL,
  `is_locked` int DEFAULT NULL,
  `is_skpd` tinyint NOT NULL,
  `kode_skpd` varchar(50) NOT NULL,
  `kunci_bl` tinyint NOT NULL,
  `kunci_bl_rinci` tinyint NOT NULL,
  `kuncibl` tinyint NOT NULL,
  `kunciblrinci` tinyint NOT NULL,
  `nilaipagu` double(20,0) NOT NULL,
  `nilaipagumurni` double(20,0) NOT NULL,
  `nilairincian` double(20,0) NOT NULL,
  `pagu_giat` double(20,0) NOT NULL,
  `realisasi` double(20,0) NOT NULL,
  `rinci_giat` double(20,0) NOT NULL,
  `set_pagu_giat` double(20,0) NOT NULL,
  `set_pagu_skpd` double(20,0) NOT NULL,
  `tahun` double(20,0) NOT NULL,
  `total_giat` double(20,0) NOT NULL,
  `totalgiat` double(20,0) NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_unit_pagu`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_user_penatausahaan`
--

DROP TABLE IF EXISTS `data_user_penatausahaan`;
CREATE TABLE `data_user_penatausahaan` (
  `id` int NOT NULL,
  `idSkpd` int DEFAULT NULL,
  `namaSkpd` text NOT NULL,
  `kodeSkpd` int DEFAULT NULL,
  `idDaerah` int DEFAULT NULL,
  `userName` text,
  `nip` varchar(50) DEFAULT NULL,
  `fullName` text,
  `nomorHp` int DEFAULT NULL,
  `rank` varchar(50) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `idJabatan` int DEFAULT NULL,
  `namaJabatan` varchar(50) DEFAULT NULL,
  `idRole` int DEFAULT NULL,
  `order` int DEFAULT NULL,
  `kpa` varchar(50) DEFAULT NULL,
  `bank` text,
  `group` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `konfirmasiPassword` varchar(50) DEFAULT NULL,
  `tahun` year NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_user_penatausahaan`:
--

-- --------------------------------------------------------

--
-- Table structure for table `data_usulan`
--

DROP TABLE IF EXISTS `data_usulan`;
CREATE TABLE `data_usulan` (
  `id` int NOT NULL,
  `alamat_teks` text DEFAULT NULL,
  `alamatteks` text NOT NULL,
  `camatteks` varchar(50) DEFAULT NULL,
  `lurahteks` varchar(50) DEFAULT NULL,
  `langpeta` double DEFAULT NULL,
  `latpeta` double DEFAULT NULL,
  `anggaran` double DEFAULT NULL,
  `bidang_urusan` varchar(50) DEFAULT NULL,
  `bidangurusan` varchar(50) DEFAULT NULL,
  `created_date` varchar(20) DEFAULT NULL,
  `createddate` varchar(20) NOT NULL,
  `created_user` int DEFAULT NULL,
  `file_foto` varchar(150) DEFAULT NULL,
  `filefoto` varchar(150) DEFAULT NULL,
  `filefoto2` varchar(150) DEFAULT NULL,
  `filefoto3` varchar(150) DEFAULT NULL,
  `file_pengantar` varchar(150) DEFAULT NULL,
  `filepengantar` varchar(150) DEFAULT NULL,
  `file_proposal` varchar(150) DEFAULT NULL,
  `fileproposal` varchar(150) DEFAULT NULL,
  `file_rab` varchar(150) DEFAULT NULL,
  `filerab` varchar(150) DEFAULT NULL,
  `giat_teks` varchar(150) DEFAULT NULL,
  `gagasan` varchar(150) DEFAULT NULL,
  `id_bidang_urusan` int DEFAULT NULL,
  `id_jenis_profil` int DEFAULT NULL,
  `id_jenis_usul` int DEFAULT NULL,
  `id_kab_kota` int DEFAULT NULL,
  `idkabkota` int DEFAULT NULL,
  `id_kamus` int DEFAULT NULL,
  `idkamus` int DEFAULT NULL,
  `id_kecamatan` int DEFAULT NULL,
  `idcamat` int DEFAULT NULL,
  `id_kelurahan` int DEFAULT NULL,
  `idlurah` int DEFAULT NULL,
  `id_pengusul` int DEFAULT NULL,
  `id_profil` int DEFAULT NULL,
  `id_usulan` int DEFAULT NULL,
  `id_reses` int DEFAULT NULL,
  `jenis_belanja` varchar(50) DEFAULT NULL,
  `jenisbelanja` varchar(50) DEFAULT NULL,
  `jenis_profil` varchar(50) DEFAULT NULL,
  `jenis_usul_teks` varchar(50) DEFAULT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  `id_unit` int DEFAULT NULL,
  `idskpd` int DEFAULT NULL,
  `kode_skpd` varchar(50) DEFAULT NULL,
  `kodeskpd` varchar(50) DEFAULT NULL,
  `koefisien` varchar(150) DEFAULT NULL,
  `lokus_usulan` varchar(250) DEFAULT NULL,
  `masalah` text DEFAULT NULL,
  `nama_daerah` varchar(50) DEFAULT NULL,
  `namakabkota` varchar(50) DEFAULT NULL,
  `nama_skpd` varchar(150) DEFAULT NULL,
  `namaskpd` varchar(150) DEFAULT NULL,
  `nip` int DEFAULT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `pengusul` varchar(50) DEFAULT NULL,
  `rekom_camat_anggaran` double DEFAULT NULL,
  `rekom_pagu_camat` double DEFAULT NULL,
  `rekom_setwan_anggaran` double DEFAULT NULL,
  `rekom_pagu_setwan` double DEFAULT NULL,
  `rekom_lurah_anggaran` double DEFAULT NULL,
  `rekom_pagu_lurah` double DEFAULT NULL,
  `rekom_mitra_anggaran` double DEFAULT NULL,
  `rekom_pagu_mitra` double DEFAULT NULL,
  `rekom_skpd_anggaran` double DEFAULT NULL,
  `rekom_pagu_skpd` double DEFAULT NULL,
  `rekom_tapd_anggaran` double DEFAULT NULL,
  `rekom_pagu_tapd` double DEFAULT NULL,
  `rekom_camat_rekomendasi` varchar(250) DEFAULT NULL,
  `rekom_teks_camat` varchar(250) DEFAULT NULL,
  `rekom_setwan_rekomendasi` varchar(250) DEFAULT NULL,
  `rekom_teks_setwan` varchar(250) DEFAULT NULL,
  `rekom_lurah_rekomendasi` varchar(250) DEFAULT NULL,
  `rekom_teks_lurah` varchar(250) DEFAULT NULL,
  `rekom_mitra_rekomendasi` varchar(250) DEFAULT NULL,
  `rekom_teks_mitra` varchar(250) DEFAULT NULL,
  `rekom_skpd_rekomendasi` varchar(250) DEFAULT NULL,
  `rekom_teks_skpd` varchar(250) DEFAULT NULL,
  `rekom_tapd_rekomendasi` varchar(250) DEFAULT NULL,
  `rekom_teks_tapd` varchar(250) DEFAULT NULL,
  `rekom_camat_koefisien` varchar(150) DEFAULT NULL,
  `rekom_vol_camat` varchar(150) DEFAULT NULL,
  `rekom_setwan_koefisien` varchar(150) DEFAULT NULL,
  `rekom_vol_setwan` varchar(150) DEFAULT NULL,
  `rekom_lurah_koefisien` varchar(150) DEFAULT NULL,
  `rekom_vol_lurah` varchar(150) DEFAULT NULL,
  `rekom_mitra_koefisien` varchar(150) DEFAULT NULL,
  `rekom_vol_mitra` varchar(150) DEFAULT NULL,
  `rekom_skpd_koefisien` varchar(150) DEFAULT NULL,
  `rekom_vol_skpd` varchar(150) DEFAULT NULL,
  `rekom_tapd_koefisien` varchar(150) DEFAULT NULL,
  `rekom_vol_tapd` varchar(150) DEFAULT NULL,
  `rev_skpd` varchar(150) DEFAULT NULL,
  `satuan` varchar(150) DEFAULT NULL,
  `status_usul` int DEFAULT NULL,
  `set_status_usul` int DEFAULT NULL,
  `setStatusUsul` int DEFAULT NULL,
  `tujuan_usul` varchar(50) DEFAULT NULL,
  `tujuanusul` varchar(50) DEFAULT NULL,
  `status_usul_teks` varchar(150) DEFAULT NULL,
  `fraksi_dewan` int DEFAULT NULL,
  `batal_teks` varchar(150) DEFAULT NULL,
  `tolak_teks` varchar(150) DEFAULT NULL,
  `is_batal` tinyint DEFAULT NULL,
  `is_tolak` tinyint DEFAULT NULL,
  `usulanggaran` double DEFAULT NULL,
  `usulvolume` varchar(50) DEFAULT NULL,
  `volume` varchar(50) DEFAULT NULL,
  `rekomteks` varchar(250) DEFAULT NULL,
  `subgiat` int DEFAULT NULL,
  `verif_skpd` tinyint DEFAULT NULL,
  `valid_tapd` tinyint DEFAULT NULL,
  `action` text NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `tahun_anggaran` year NOT NULL DEFAULT '2021'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `data_usulan`:
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_batuan_hibah_uang`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `vw_batuan_hibah_uang`;
CREATE TABLE `vw_batuan_hibah_uang` (
`kode_akun` varchar(50)
,`nama_akun` text
,`subs_bl_teks` text
,`ket_bl_teks` text
,`lokus_akun_teks` text
,`nama_komponen` text
,`koefisien` text
,`satuan` varchar(50)
,`harga_satuan` double(20,0)
,`rincian` double(20,0)
,`kode_sbl` varchar(50)
,`update_at` datetime
,`tahun_anggaran` year
,`deskel` text
,`kecamatan` text
,`kabupaten` text
,`provinsi` text
,`nama_penerima` text
,`alamat_penerima` text
,`jenis_penerima` text
);

-- --------------------------------------------------------

--
-- Structure for view `vw_batuan_hibah_uang`
--
DROP TABLE IF EXISTS `vw_batuan_hibah_uang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`maswie`@`localhost` SQL SECURITY DEFINER VIEW `vw_batuan_hibah_uang`  AS  select `a`.`kode_akun` AS `kode_akun`,`a`.`nama_akun` AS `nama_akun`,`r`.`subs_bl_teks` AS `subs_bl_teks`,`r`.`ket_bl_teks` AS `ket_bl_teks`,`r`.`lokus_akun_teks` AS `lokus_akun_teks`,`r`.`nama_komponen` AS `nama_komponen`,`r`.`koefisien` AS `koefisien`,`r`.`satuan` AS `satuan`,`r`.`harga_satuan` AS `harga_satuan`,`r`.`rincian` AS `rincian`,`r`.`kode_sbl` AS `kode_sbl`,`r`.`update_at` AS `update_at`,`r`.`tahun_anggaran` AS `tahun_anggaran`,`al`.`nama` AS `deskel`,(select `data_alamat`.`nama` from `data_alamat` where (`data_alamat`.`id_alamat` = `al`.`id_kec`)) AS `kecamatan`,(select `data_alamat`.`nama` from `data_alamat` where (`data_alamat`.`id_alamat` = `al`.`id_kab`)) AS `kabupaten`,(select `data_alamat`.`nama` from `data_alamat` where (`data_alamat`.`id_alamat` = `al`.`id_prov`)) AS `provinsi`,`p`.`nama_teks` AS `nama_penerima`,`p`.`alamat_teks` AS `alamat_penerima`,`p`.`jenis_penerima` AS `jenis_penerima` from (((`data_akun` `a` join `data_rka` `r` on((`a`.`kode_akun` = `r`.`kode_akun`))) left join `data_alamat` `al` on((`r`.`id_lurah_penerima` = `al`.`id_alamat`))) left join `data_profile_penerima_bantuan` `p` on((`r`.`id_penerima` = `p`.`id_profil`))) where (`a`.`is_hibah_uang` = 1) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_akun`
--
ALTER TABLE `data_akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_alamat`
--
ALTER TABLE `data_alamat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_anggaran_kas`
--
ALTER TABLE `data_anggaran_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_capaian_prog_sub_keg`
--
ALTER TABLE `data_capaian_prog_sub_keg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_dana_sub_keg`
--
ALTER TABLE `data_dana_sub_keg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_desa_kelurahan`
--
ALTER TABLE `data_desa_kelurahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_dewan`
--
ALTER TABLE `data_dewan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_keg_indikator_hasil`
--
ALTER TABLE `data_keg_indikator_hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_lokasi_sub_keg`
--
ALTER TABLE `data_lokasi_sub_keg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_output_giat_sub_keg`
--
ALTER TABLE `data_output_giat_sub_keg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pembiayaan`
--
ALTER TABLE `data_pembiayaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pendapatan`
--
ALTER TABLE `data_pendapatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pengaturan_sipd`
--
ALTER TABLE `data_pengaturan_sipd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_profile_penerima_bantuan`
--
ALTER TABLE `data_profile_penerima_bantuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_prog_keg`
--
ALTER TABLE `data_prog_keg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_renstra`
--
ALTER TABLE `data_renstra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_rka`
--
ALTER TABLE `data_rka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_rpjmd`
--
ALTER TABLE `data_rpjmd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_ssh`
--
ALTER TABLE `data_ssh`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_standar_harga` (`id_standar_harga`);

--
-- Indexes for table `data_ssh_rek_belanja`
--
ALTER TABLE `data_ssh_rek_belanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_standar_harga` (`id_standar_harga`);

--
-- Indexes for table `data_sub_keg_bl`
--
ALTER TABLE `data_sub_keg_bl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_sub_keg_indikator`
--
ALTER TABLE `data_sub_keg_indikator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_sumber_dana`
--
ALTER TABLE `data_sumber_dana`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_tag_sub_keg`
--
ALTER TABLE `data_tag_sub_keg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_unit`
--
ALTER TABLE `data_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_unit_pagu`
--
ALTER TABLE `data_unit_pagu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_user_penatausahaan`
--
ALTER TABLE `data_user_penatausahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_usulan`
--
ALTER TABLE `data_usulan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_akun`
--
ALTER TABLE `data_akun`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_alamat`
--
ALTER TABLE `data_alamat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_anggaran_kas`
--
ALTER TABLE `data_anggaran_kas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_capaian_prog_sub_keg`
--
ALTER TABLE `data_capaian_prog_sub_keg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_dana_sub_keg`
--
ALTER TABLE `data_dana_sub_keg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_desa_kelurahan`
--
ALTER TABLE `data_desa_kelurahan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_dewan`
--
ALTER TABLE `data_dewan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_keg_indikator_hasil`
--
ALTER TABLE `data_keg_indikator_hasil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lokasi_sub_keg`
--
ALTER TABLE `data_lokasi_sub_keg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_output_giat_sub_keg`
--
ALTER TABLE `data_output_giat_sub_keg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pembiayaan`
--
ALTER TABLE `data_pembiayaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pendapatan`
--
ALTER TABLE `data_pendapatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pengaturan_sipd`
--
ALTER TABLE `data_pengaturan_sipd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_profile_penerima_bantuan`
--
ALTER TABLE `data_profile_penerima_bantuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_prog_keg`
--
ALTER TABLE `data_prog_keg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_renstra`
--
ALTER TABLE `data_renstra`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_rka`
--
ALTER TABLE `data_rka`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_rpjmd`
--
ALTER TABLE `data_rpjmd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_ssh`
--
ALTER TABLE `data_ssh`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_ssh_rek_belanja`
--
ALTER TABLE `data_ssh_rek_belanja`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_sub_keg_bl`
--
ALTER TABLE `data_sub_keg_bl`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_sub_keg_indikator`
--
ALTER TABLE `data_sub_keg_indikator`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_sumber_dana`
--
ALTER TABLE `data_sumber_dana`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_tag_sub_keg`
--
ALTER TABLE `data_tag_sub_keg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_unit`
--
ALTER TABLE `data_unit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_unit_pagu`
--
ALTER TABLE `data_unit_pagu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_user_penatausahaan`
--
ALTER TABLE `data_user_penatausahaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_usulan`
--
ALTER TABLE `data_usulan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_ssh_rek_belanja`
--
ALTER TABLE `data_ssh_rek_belanja`
  ADD CONSTRAINT `data_ssh_rek_belanja_ibfk_1` FOREIGN KEY (`id_standar_harga`) REFERENCES `data_ssh` (`id_standar_harga`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
