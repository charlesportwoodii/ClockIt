#Please keep this file clean
#one query per line
#MySQL only at the moment, could do more than one script or perhaps a more generic script to fix this issue
DROP TABLE IF EXISTS `watchdog`;
CREATE TABLE `watchdog` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `old_value` text NOT NULL, `new_value` text NOT NULL, `action` varchar(20) NOT NULL, `model` varchar(255) NOT NULL, `field` varchar(64) NOT NULL, `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `user_id` int(11) NOT NULL, `model_id` varchar(65) NOT NULL, PRIMARY KEY (`id`), KEY `idx_user_id` (`user_id`), KEY `idx_model_id` (`model_id`), KEY `idx_model` (`model`), KEY `idx_field` (`field`), KEY `idx_old_value` (`old_value`(16)), KEY `idx_new_value` (`new_value`(16)), KEY `idx_action` (`action`)) ENGINE=InnoDB;
