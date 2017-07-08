ALTER TABLE `mob_user_address` ADD `state_id` INT NOT NULL AFTER `user_id`, ADD `city` INT NOT NULL AFTER `state_id`, ADD `zipcode` INT NOT NULL AFTER `city`, ADD `country_id` INT NOT NULL AFTER `zipcode`, ADD `name` INT NOT NULL AFTER `country_id`;
ALTER TABLE `mob_user_address` CHANGE `is_default` `is_default` INT(11) NULL DEFAULT '0';
ALTER TABLE `mob_user_address` CHANGE `name` `name` VARCHAR(255) NOT NULL;
ALTER TABLE `mob_user_address` CHANGE `city` `city` VARCHAR(255) NOT NULL;