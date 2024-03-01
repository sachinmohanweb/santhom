
-- 17/02/24----

CREATE TABLE `admins` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`name` VARCHAR(256) NOT NULL , 
	`email` VARCHAR(256) NOT NULL , 
	`password` VARCHAR(256) NOT NULL , 
	`remember_token` VARCHAR(100) NULL DEFAULT NULL , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@santhom.com', '$2y$12$8b5SCDK.GrK3ncuJBYA7E.vqyprzlptFCeqQE8mKXCdurrSmKU7Rm', 'jNMj8IJRcJTmyyQiCbMlM9J9qNN791z2RtH0CRCJ3FNzUdf2G3Cf84Tbu6he', '2024-02-18 16:48:04', '2024-02-18 16:48:04');

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


-- 21/02/24----

CREATE TABLE `family_members` (
	`id` BIGINT NOT NULL AUTO_INCREMENT , 
	`title` VARCHAR(100) NULL , 
	`name` VARCHAR(256) NOT NULL , 
	`nickname` VARCHAR(256) NULL , 
	`gender` VARCHAR(100) NOT NULL , 
	`dob` DATE NOT NULL , 
	`date_of_baptism` DATE NULL , 
	`blood_group_id` VARCHAR(100) NULL , 
	`marital_status_id` INT NOT NULL , 
	`date_of_marriage` DATE NULL , 
	`relationship_id` INT NOT NULL , 
	`qualification` VARCHAR(256) NULL , 
	`occupation` VARCHAR(256) NULL , 
	`company_name` VARCHAR(256) NULL , 
	`email` VARCHAR(256) NULL , 
	`mobile` VARCHAR(256) NULL , 
	`alt_contact_no` VARCHAR(256) NULL , 
	`date_of_death` DATE NULL , 
	`image` VARCHAR(512) NULL , 
	`status` INT NULL , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));


ALTER TABLE `family_members` 
	ADD `family_id` INT NOT NULL AFTER `nickname`, 
	ADD `head_of_family` INT NOT NULL DEFAULT '0' AFTER `family_id`;

ALTER TABLE `family_members` CHANGE `blood_group_id` `blood_group_id` INT NULL DEFAULT NULL;



-- 23/02/24----

CREATE TABLE `prayer_groups` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`group_name` VARCHAR(256) NOT NULL , 
	`leader` VARCHAR(256) NULL , 
	`leader_phone_number` VARCHAR(256) NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));


CREATE TABLE `blood_groups` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`blood_group_name` VARCHAR(100) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));

INSERT INTO `blood_groups` (`id`, `blood_group_name`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'A+ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
 (NULL, 'A-ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'B+ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  (NULL, 'B-ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'O+ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
   (NULL, 'O-ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'AB+ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
    (NULL, 'Ab-ve', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


CREATE TABLE `marital_statuses` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`marital_status_name` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));


INSERT INTO `marital_statuses` (`id`, `marital_status_name`, `status`, `created_at`, `updated_at`) VALUES 
(NULL, 'Unmarried', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, 'Married', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, 'Widower', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, 'Widow', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


CREATE TABLE `relationships` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`relation_name` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));

INSERT INTO `relationships` (`id`, `relation_name`, `status`, `created_at`, `updated_at`) VALUES  (NULL, 'Head of family', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, 'Father', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
 (NULL, 'Mother', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Husband', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
 (NULL, 'Wife', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Son', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
 (NULL, 'Daughter', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Daughter-in-law', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
 (NULL, 'Grandson', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Granddaughter', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


-- 27/02/24----

ALTER TABLE `families` DROP `head_of_family`;
ALTER TABLE `families` ADD `post_office` VARCHAR(256) NULL DEFAULT NULL AFTER `address2`;
ALTER TABLE `families` ADD `map_location` VARCHAR(256) NULL DEFAULT NULL AFTER `pincode`;
ALTER TABLE `families` CHANGE `address2` `address2` VARCHAR(512) NULL DEFAULT NULL;
ALTER TABLE `families` CHANGE `prayer_group` `prayer_group_id` INT NOT NULL;
ALTER TABLE `family_members` CHANGE `marital_status_id` `marital_status_id` INT NULL DEFAULT NULL;

-- 29/02/24----

INSERT INTO `relationships` (`id`, `relation_name`, `status`, `created_at`, `updated_at`)
 VALUES (NULL, 'Son-in-law', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);