ALTER TABLE `mob_vendor` ADD `photo` VARCHAR(255) NULL AFTER `location`, ADD `image_path` VARCHAR(255) NULL AFTER `photo`;
ALTER TABLE `mob_vendor` CHANGE `status` `status` INT(11) NULL DEFAULT '0';
ALTER TABLE `mob_users` CHANGE `status` `status` INT(1) NOT NULL DEFAULT '0' COMMENT '0=>inactive,1=>active';s
ALTER TABLE `mob_product` CHANGE `status` `status` INT(11) NULL DEFAULT '0';
ALTER TABLE `mob_order` CHANGE `status` `status` INT(11) NULL DEFAULT '1';
-- =====================================================================================
ALTER TABLE `mob_users` ADD `facebook_id` VARCHAR(50) NULL AFTER `username`;