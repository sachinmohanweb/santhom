
-- 17/02/24----

CREATE TABLE `admins` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`name` VARCHAR(256) NOT NULL , 
	`email` VARCHAR(256) NOT NULL , 
	`password` VARCHAR(256) NOT NULL , 
	`remember_token` VARCHAR(100) NULL DEFAULT NULL , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));


-- 19/02/24----

CREATE TABLE `families` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`family_code` VARCHAR(256) NOT NULL , 
	`family_name` VARCHAR(256) NOT NULL , 
	`family_email` VARCHAR(256) NOT NULL , 
	`head_of_family` VARCHAR(256) NOT NULL , 
	`prayer_group` INT NOT NULL , 
	`address1` VARCHAR(512) NOT NULL , 
	`address2` VARCHAR(512) NOT NULL , 
	`pincode` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

