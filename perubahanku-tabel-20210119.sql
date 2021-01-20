
ALTER TABLE `data_desa_kelurahan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `data_alamat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `data_dewan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `data_unit_pagu` CHANGE `id_user` `id_user` INT NULL;
ALTER TABLE `data_unit_pagu` CHANGE `is_anggaran` `is_anggaran` INT NULL;
ALTER TABLE `data_unit_pagu` CHANGE `is_deleted` `is_deleted` INT NULL;
ALTER TABLE `data_unit_pagu` CHANGE `is_komponen` `is_komponen` INT NULL;
ALTER TABLE `data_unit_pagu` CHANGE `is_locked` `is_locked` INT NULL;
ALTER TABLE `data_unit_pagu` CHANGE `id_level` `id_level` INT NULL;

ALTER TABLE `data_unit` CHANGE `bidur_2` `bidur_2` SMALLINT NULL;
ALTER TABLE `data_unit` CHANGE `bidur_3` `bidur_3` SMALLINT NULL;

ALTER TABLE `data_unit` ADD `id_setup_unit` int NOT NULL AFTER `id`;
ALTER TABLE `data_unit` ADD `id_skpd` int NOT NULL AFTER `id_setup_unit`;
ALTER TABLE `data_unit` ADD `id_unit` int NOT NULL AFTER `id_skpd`;
ALTER TABLE `data_unit` ADD `is_skpd` int NOT NULL AFTER `id_unit`;
ALTER TABLE `data_unit` ADD `kode_skpd` VARCHAR(30) NOT NULL AFTER `is_skpd`;
ALTER TABLE `data_unit` ADD `kunci_skpd` SMALLINT NOT NULL AFTER `kode_skpd`;
ALTER TABLE `data_unit` ADD `nama_skpd` VARCHAR(255) NOT NULL AFTER `kunci_skpd`;
ALTER TABLE `data_unit` ADD `posisi` VARCHAR(25) NOT NULL AFTER `nama_skpd`;
ALTER TABLE `data_unit` ADD `status` VARCHAR(25) NOT NULL AFTER `posisi`;
ALTER TABLE `data_unit` ADD `active` SMALLINT NOT NULL AFTER `statuskepala`;

ALTER TABLE `data_prog_keg` ADD `id_giat` INT NOT NULL AFTER `id_sub_giat`;

ALTER TABLE `data_dana_sub_keg` ADD `pagudana` double(20, 0) DEFAULT NULL AFTER `iddanasubbl`;


--
-- Table structure for table `data_keg_indikator_hasil`
--

CREATE TABLE `data_keg_indikator_hasil` (
  `id` int(11) NOT NULL,
  `hasilteks` text,
  `satuanhasil` varchar(50) DEFAULT NULL,
  `targethasil` varchar(50) DEFAULT NULL,
  `targethasilteks` varchar(50) DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` varchar(50) DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `data_user_penatausahaan`
--

CREATE TABLE `data_user_penatausahaan` (
  `id` int(11) NOT NULL,
  `idSkpd` int(11) DEFAULT NULL,
  `namaSkpd` text NOT NULL,
  `kodeSkpd` int(50) DEFAULT NULL,
  `idDaerah` int(11) DEFAULT NULL,
  `userName` text,
  `nip` varchar(50) DEFAULT NULL,
  `fullName` text,
  `nomorHp` int(50) DEFAULT NULL,
  `rank` varchar(50) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `idJabatan` int(11) DEFAULT NULL,
  `namaJabatan` varchar(50) DEFAULT NULL,
  `idRole` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `kpa` varchar(50) DEFAULT NULL,
  `bank` text,
  `group` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `konfirmasiPassword` varchar(50) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `data_renstra`
--

CREATE TABLE `data_renstra` (
  `id` int(11) NOT NULL,
  `id_bidang_urusan` int(11) DEFAULT NULL,
  `id_giat` int(11) DEFAULT NULL,
  `id_program` int(11) DEFAULT NULL,
  `id_renstra` int(11) DEFAULT NULL,
  `id_rpjmd` int(11) DEFAULT NULL,
  `id_sub_giat` int(11) DEFAULT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `indikator` text,
  `indikator_sub` text,
  `is_locked` tinyint(4) DEFAULT NULL,
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
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `data_lokasi_sub_keg`
--

CREATE TABLE `data_lokasi_sub_keg` (
  `id` int(11) NOT NULL,
  `camatteks` text,
  `daerahteks` text,
  `idcamat` int(11) DEFAULT NULL,
  `iddetillokasi` double DEFAULT NULL,
  `idkabkota` int(11) DEFAULT NULL,
  `idlurah` int(11) DEFAULT NULL,
  `lurahteks` text,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `idsubbl` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `data_anggaran_kas`
--

CREATE TABLE `data_anggaran_kas` (
  `id` int(11) NOT NULL,
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
  `id_akun` int(11) DEFAULT NULL,
  `id_bidang_urusan` int(11) DEFAULT NULL,
  `id_daerah` int(11) DEFAULT NULL,
  `id_giat` int(11) DEFAULT NULL,
  `id_program` int(11) DEFAULT NULL,
  `id_skpd` int(11) DEFAULT NULL,
  `id_sub_giat` int(11) DEFAULT NULL,
  `id_sub_skpd` int(11) DEFAULT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `kode_akun` varchar(50) DEFAULT NULL,
  `nama_akun` text,
  `selisih` double DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `total_akb` double DEFAULT NULL,
  `total_rincian` double DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `kode_sbl` varchar(50) DEFAULT NULL,
  `tahun_anggaran` year(4) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `data_pembiayaan`
--

CREATE TABLE `data_pembiayaan` (
  `id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `createddate` varchar(50) DEFAULT NULL,
  `createdtime` varchar(50) DEFAULT NULL,
  `id_pembiayaan` int(11) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `kode_akun` varchar(50) DEFAULT NULL,
  `nama_akun` text,
  `nilaimurni` int(11) DEFAULT NULL,
  `program_koordinator` int(11) DEFAULT NULL,
  `rekening` text,
  `skpd_koordinator` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `updateddate` varchar(50) DEFAULT NULL,
  `updatedtime` varchar(50) DEFAULT NULL,
  `uraian` text,
  `urusan_koordinator` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `user1` varchar(50) DEFAULT NULL,
  `user2` varchar(50) DEFAULT NULL,
  `id_skpd` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `data_pendapatan`
--

CREATE TABLE `data_pendapatan` (
  `id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `createddate` varchar(50) DEFAULT NULL,
  `createdtime` varchar(50) DEFAULT NULL,
  `id_pendapatan` int(11) DEFAULT NULL,
  `keterangan` text,
  `kode_akun` varchar(50) DEFAULT NULL,
  `nama_akun` text,
  `nilaimurni` int(11) DEFAULT NULL,
  `program_koordinator` int(11) DEFAULT NULL,
  `rekening` text,
  `skpd_koordinator` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `updated_user` int(11) DEFAULT NULL,
  `updateddate` varchar(50) DEFAULT NULL,
  `updatedtime` varchar(50) DEFAULT NULL,
  `uraian` text,
  `urusan_koordinator` int(11) DEFAULT NULL,
  `user1` varchar(50) DEFAULT NULL,
  `user2` varchar(50) DEFAULT NULL,
  `id_skpd` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  `update_at` datetime NOT NULL,
  `tahun_anggaran` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indexes for table `data_pendapatan`
--
ALTER TABLE `data_pendapatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pembiayaan`
--
ALTER TABLE `data_pembiayaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_anggaran_kas`
--
ALTER TABLE `data_anggaran_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_lokasi_sub_keg`
--
ALTER TABLE `data_lokasi_sub_keg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_renstra`
--
ALTER TABLE `data_renstra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_keg_indikator_hasil`
--
ALTER TABLE `data_keg_indikator_hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_user_penatausahaan`
--
ALTER TABLE `data_user_penatausahaan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `data_user_penatausahaan`
--
ALTER TABLE `data_user_penatausahaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_keg_indikator_hasil`
--
ALTER TABLE `data_keg_indikator_hasil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_renstra`
--
ALTER TABLE `data_renstra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lokasi_sub_keg`
--
ALTER TABLE `data_lokasi_sub_keg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_anggaran_kas`
--
ALTER TABLE `data_anggaran_kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pembiayaan`
--
ALTER TABLE `data_pembiayaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pendapatan`
--
ALTER TABLE `data_pendapatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


