
CREATE TABLE `jokes` ( 
	`id` INT NOT NULL AUTO_INCREMENT , 
	`title` VARCHAR(50) NOT NULL,
	`text` TEXT NOT NULL , 
	`image` VARCHAR(255) NOT NULL , 
	`category_id` INT NOT NULL , 
PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `jokes` ADD INDEX (`category_id`);

ALTER TABLE `jokes` ADD FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;