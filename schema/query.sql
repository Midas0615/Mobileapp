ALTER TABLE `mob_product` CHANGE `is_deleted` `is_deleted` INT(11) NULL DEFAULT '0';
ALTER TABLE `mob_review` CHANGE `is_deleted` `is_deleted` INT(11) NULL DEFAULT '0';
ALTER TABLE `mob_rating` CHANGE `is_deleted` `is_deleted` INT(11) NULL DEFAULT '0';
ALTER TABLE `mob_vendor` CHANGE `is_deleted` `is_deleted` INT(11) NULL DEFAULT '0';
ALTER TABLE `mob_order` CHANGE `is_deleted` `is_deleted` INT(11) NULL DEFAULT '0';

ALTER TABLE `mob_review` ADD `name` VARCHAR(255) NULL AFTER `order_id`;
ALTER TABLE `mob_product` ADD `image_path` VARCHAR(255) NULL AFTER `photo`;