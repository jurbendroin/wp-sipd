
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

