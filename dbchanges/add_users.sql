/**
 * Author:  cevantime
 * Created: 23 mai 2017
 */

CREATE TABLE `users` ( 
	`id` INT NOT NULL AUTO_INCREMENT , 
	`username` VARCHAR(50) NOT NULL , 
	`password` VARCHAR(255) NOT NULL , 
	`email` VARCHAR(150) NOT NULL , 
	`role` VARCHAR(30) NOT NULL , 
	`salt` VARCHAR(50) NOT NULL , 
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;