/**
 * Author:  cevantime
 * Created: 23 mai 2017
 */
ALTER TABLE `users` ADD UNIQUE `email_unique` (`email`);

ALTER TABLE `users` ADD UNIQUE `username_unique` (`username`);