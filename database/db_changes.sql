
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

INSERT INTO `blood_groups` (`id`, `blood_group_name`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'A+', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
 (NULL, 'A-', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'B+', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  (NULL, 'B-', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'O+', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
   (NULL, 'O-', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'AB+', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
    (NULL, 'AB-', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


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
 
-- 02/03/24----

INSERT INTO `relationships` (`id`, `relation_name`, `status`, `created_at`, `updated_at`) 
VALUES (NULL, 'Mother-in-law', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `relationships` (`id`, `relation_name`, `status`, `created_at`, `updated_at`) 
VALUES (NULL, 'Brother', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


-- 04/03/24----

CREATE TABLE `organizations` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`organization_name` VARCHAR(256) NOT NULL , 
	`coordinator` VARCHAR(256) NULL , 
	`coordinator_phone_number` VARCHAR(256) NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));

CREATE TABLE `vicar_details` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`name` VARCHAR(256) NOT NULL , 
	`family_name` VARCHAR(256) NOT NULL , 
	`dob` DATE NOT NULL , 
	`designation` VARCHAR(256) NOT NULL , 
	`date_of_joining` DATE NOT NULL , 
	`date_of_relieving` DATE NULL DEFAULT NULL , 
	`email` VARCHAR(256) NOT NULL , 
	`mobile` VARCHAR(256) NULL DEFAULT NULL , 
	`photo` VARCHAR(256) NULL DEFAULT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

-- 05/03/24----

CREATE TABLE `email_verifications` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`email` VARCHAR(256) NOT NULL , 
	`otp` VARCHAR(4) NOT NULL , 
	`otp_expiry` TIMESTAMP NOT NULL , 
	`otp_used` INT NOT NULL DEFAULT '0' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));

-- 06/03/24----

CREATE TABLE `vicar_messages` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`subject` VARCHAR(256) NOT NULL , 
	`message_body` TEXT NOT NULL , 
	`image` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

-- 06/03/24----

CREATE TABLE `bible_verses` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`verse` TEXT NOT NULL , 
	`ref` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

-- 07/03/24----

CREATE TABLE `events` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`event_name` VARCHAR(256) NOT NULL , 
	`date` DATE NOT NULL , 
	`venue` VARCHAR(256) NULL DEFAULT NULL , 
	`details` TEXT NULL DEFAULT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

-- 07/03/24----

CREATE TABLE `news_announcements` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`type` INT NOT NULL , 
	`heading` VARCHAR(256) NOT NULL , 
	`body` TEXT NOT NULL , `
	image` VARCHAR(256) NULL DEFAULT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

ALTER TABLE `news_announcements` CHANGE `type` `type` INT NULL;

-- 08/03/24----

CREATE TABLE `obituaries` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`name_of_member` VARCHAR(256) NOT NULL , 
	`date_of_death` DATE NOT NULL , 
	`funeral_date` DATE NULL DEFAULT NULL , 
	`funeral_time` TIME NULL DEFAULT NULL , 
	`display_till_date` DATE NOT NULL , 
	`notes` TEXT NULL DEFAULT NULL , 
	`photo` VARCHAR(256) NULL DEFAULT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

-- 10/03/24----

CREATE TABLE ``notifications` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`title` VARCHAR(256) NOT NULL , 
	`content` TEXT NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

ALTER TABLE `notifications` ADD `type` INT NULL DEFAULT NULL AFTER `content`;



CREATE TABLE `payment_details` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`member` VARCHAR(256) NOT NULL , 
	`purpose` VARCHAR(256) NOT NULL , 
	`date` DATE NOT NULL , 
	`amount` DOUBLE(8,2) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

ALTER TABLE `payment_details` ADD `member_id` INT NOT NULL AFTER `id`;

ALTER TABLE `obituaries` ADD `member_id` INT NOT NULL AFTER `id`;

-- 12/03/24----

ALTER TABLE `families` DROP `family_email`;

ALTER TABLE `vicar_messages` CHANGE `image` `image` VARCHAR(256)  NULL DEFAULT NULL;

-- 13/03/24----

update `family_members` set status=1;

ALTER TABLE `events` ADD `image` VARCHAR(256) NULL DEFAULT NULL AFTER `details`;

ALTER TABLE `family_members` CHANGE `status` `status` INT(11) NULL DEFAULT '1';


-- 16/03/24----

ALTER TABLE `family_members` ADD `user_type` INT NOT NULL DEFAULT '1'
	 COMMENT '1-members,2-vicar/asst vicar' AFTER `status`;

INSERT INTO `relationships` (`id`, `relation_name`, `status`, `created_at`, `updated_at`)
 VALUES (NULL, 'Vicar', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

ALTER TABLE `vicar_details` ADD `member_id` INT NULL DEFAULT NULL AFTER `id`;

-- 18/03/24----

CREATE TABLE `downloads` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`title` VARCHAR(256) NOT NULL , 
	`file` VARCHAR(256) NOT NULL , 
	`type` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

ALTER TABLE `downloads` ADD `details` TEXT NULL DEFAULT NULL AFTER `type`;

-- 21/03/24----

ALTER TABLE `news_announcements` ADD `group_org_id` INT NULL DEFAULT NULL AFTER `type`;
ALTER TABLE `notifications` ADD `group_org_id` INT NULL DEFAULT NULL AFTER `status`;


-- 22/03/24----

CREATE TABLE `biblical_citations` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`date` DATE NOT NULL , 
	`reference` VARCHAR(256) NOT NULL , 
	`note1` TEXT NULL DEFAULT NULL , 
	`note2` TEXT NULL DEFAULT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));


CREATE TABLE `memory_types` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`type_name` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));


INSERT INTO `memory_types` (`id`, `type_name`, `status`, `created_at`, `updated_at`, `deleted_at`) 
VALUES (NULL, 'Memorial Historical Days', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL),
(NULL, 'Ancestral Days', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL),
 (NULL, 'Remembrance Days', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL);


 CREATE TABLE `memory_days` (
 	`id` INT NOT NULL AUTO_INCREMENT , 
 	`memory_type_id` INT NOT NULL , 
 	`date` DATE NOT NULL , 
 	`title` TEXT NOT NULL , 
 	`note1` TEXT NULL DEFAULT NULL , 
 	`note2` TEXT NULL DEFAULT NULL , 
 	`status` INT NOT NULL DEFAULT '1' , 
 	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
 	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
 	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));

-- 22/03/24----

CREATE TABLE `daily_schedules` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`type` INT NOT NULL COMMENT '1-Normal_day,2-Special_day' , 
	`day_category` INT NOT NULL COMMENT '1-Mon_to_Sat,2-Sunday' , 
	`date` DATE NOT NULL , `details` TEXT NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`deleted_at` TIMESTAMP NULL DEFAULT NULL , PRIMARY KEY (`id`));


ALTER TABLE `day_category` CHANGE `day_category` `day_category` DATE NULL DEFAULT NULL;
ALTER TABLE `daily_schedules` CHANGE `date` `date` DATE NULL DEFAULT NULL;

-- 28/03/24----

ALTER TABLE `vicar_details` ADD `title` VARCHAR(100) NULL DEFAULT NULL AFTER `member_id`;

-- 30/03/24----

ALTER TABLE `events` ADD `time` TIME NULL DEFAULT NULL AFTER `date`;

-- 13/04/24----

ALTER TABLE `bible_verses` ADD `date` DATE NOT NULL DEFAULT '2024-11-15' AFTER `id`;
ALTER TABLE `bible_verses` DROP `deleted_at`;

ALTER TABLE `family_members` ADD `remark` INT NULL DEFAULT NULL AFTER `marital_status_id`, 
ADD `marr_memb_id` INT NULL DEFAULT NULL AFTER `remark`;

-- 16/04/24----

ALTER TABLE `events` ADD `link` VARCHAR(256) NULL DEFAULT NULL AFTER `venue`;

ALTER TABLE `news_announcements` DROP `deleted_at`;

ALTER TABLE `news_announcements` ADD `link` VARCHAR(256) NULL DEFAULT NULL AFTER `body`;


-- 19/04/24----

ALTER TABLE `prayer_groups` ADD `leader_id` INT NULL DEFAULT NULL AFTER `group_name`;

ALTER TABLE `prayer_groups` ADD `coordinator_id` INT NULL DEFAULT NULL AFTER `leader_phone_number`, 
ADD `coordinator_name` VARCHAR(256) NULL DEFAULT NULL AFTER `coordinator_id`, 
ADD `coordinator_phone` VARCHAR(256) NULL DEFAULT NULL AFTER `coordinator_name`;


-- 27/04/24----


CREATE TABLE `organization_officers` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`organization_id` INT NOT NULL , 
	`member_id` INT NOT NULL , 
	`member_name` VARCHAR(256) NOT NULL , 
	`position` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));

ALTER TABLE `organization_officers` ADD `officer_phone_number` VARCHAR(11) NOT NULL AFTER `position`;

ALTER TABLE `organizations` CHANGE `coordinator_id` `coordinator_id` INT NULL DEFAULT NULL;
ALTER TABLE `organizations` CHANGE `coordinator_id` `coordinator_id` INT NULL DEFAULT NULL;


-- 7/05/24----

INSERT INTO `relationships` (`id`, `relation_name`, `status`, `created_at`, `updated_at`) 
VALUES (NULL, 'Others', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- 1/06/24----

ALTER TABLE `email_verifications` ADD `family_code` VARCHAR(256) NULL DEFAULT NULL AFTER `id`;

ALTER TABLE `family_members` DROP `deleted_at`;

-- 2/06/24----

ALTER TABLE `family_members` ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;

-- 06/06/24----

ALTER TABLE `news_announcements` ADD `type_name` VARCHAR(256) NULL DEFAULT NULL AFTER `type`;
ALTER TABLE `notifications` ADD `type_name` VARCHAR(256) NOT NULL AFTER `type`;

ALTER TABLE `family_members` ADD `device_id` VARCHAR(256) NULL DEFAULT NULL AFTER `user_type`;
ALTER TABLE `family_members` ADD `refresh_token` VARCHAR(512) NULL DEFAULT NULL AFTER `device_id`;

-- 08/06/24----

ALTER TABLE `family_members` CHANGE `user_type` `user_type` INT NOT NULL DEFAULT '1' COMMENT '1-family members,2-church members';

UPDATE `relationships` SET `relation_name` = 'Church members' WHERE `relationships`.`id` = 14;

-- 12/06/24----

ALTER TABLE `daily_schedules` DROP `type`;
ALTER TABLE `daily_schedules` DROP `day_category`;

-- 17/06/24----

CREATE TABLE `payment_categories` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`name` VARCHAR(256) NOT NULL , 
	`status` INT NOT NULL DEFAULT '1' , 
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`));

INSERT INTO `payment_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) 
VALUES (NULL, 'Monthly Subscription', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, 'Parish Feast', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
 (NULL, 'Parish Day', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
 (NULL, 'First Offering', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
  (NULL, 'Carol', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
   (NULL, 'Good Friday', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
   (NULL, '8 Nombu', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
   (NULL, 'Mission Sunday', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
   (NULL, 'Education Help', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
   (NULL, 'SEMINARY DAY', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
   (NULL, 'Others', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);


ALTER TABLE `payment_details` CHANGE `member_id` `family_id` INT NOT NULL;
ALTER TABLE `payment_details` DROP `member`;
ALTER TABLE `payment_details` ADD `family_head_id` INT NOT NULL AFTER `family_id`;
ALTER TABLE `payment_details` DROP `purpose`;
ALTER TABLE `payment_details` ADD `category_id` INT NOT NULL AFTER `family_head_id`;
ALTER TABLE `payment_details` DROP `date`;

-- 17/06/24----


INSERT INTO `relationships` (`id`, `relation_name`, `status`, `created_at`, `updated_at`) 
VALUES (NULL, 'Grandson-in-law', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
 (NULL, 'Granddaughter-in-law', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);