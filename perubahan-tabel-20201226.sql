
--
-- AUTO_INCREMENT for table `data_desa_kelurahan`
--
ALTER TABLE `data_desa_kelurahan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `data_alamat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `data_dewan`
--
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
ALTER TABLE `data_unit` ADD `active` SMALLINT NOT NULL AFTER `statuskepala`;
ALTER TABLE `data_unit` ADD `status` VARCHAR(25) NOT NULL AFTER `posisi`;

