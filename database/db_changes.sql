
-- 18/02/24----

CREATE TABLE `admins` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`name` VARCHAR(256) NOT NULL , 
	`email` VARCHAR(256) NOT NULL , 
	`password` VARCHAR(256) NOT NULL , 
	`remember_token` VARCHAR(100) NULL DEFAULT NULL , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));
