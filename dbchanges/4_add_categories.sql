CREATE TABLE `categories` (
	`id` INT NOT NULL AUTO_INCREMENT , 
	`name` VARCHAR(50) NOT NULL , 
	`icon` VARCHAR(255) NULL , 
PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `categories` ADD UNIQUE (`name`);

