/**
 * Author:  cevantime
 * Created: 23 mai 2017
 */

CREATE USER 'sellajoke'@'localhost' IDENTIFIED WITH mysql_native_password AS 'MAzMFWAJsdOBcJ0I';
GRANT USAGE ON *.* TO 'sellajoke'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
CREATE DATABASE IF NOT EXISTS `sellajoke`;
GRANT ALL PRIVILEGES ON `sellajoke`.* TO 'sellajoke'@'localhost';