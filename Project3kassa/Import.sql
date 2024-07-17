CREATE DATABASE IF NOT EXISTS CashFlow;

USE CashFlow;

CREATE TABLE `verkopen`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `artiekelnummer` INT NOT NULL,
    `aantalverkocht` INT NOT NULL
);
CREATE TABLE `inlog`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `inlognaam` VARCHAR(255) NOT NULL,
    `wachtwoord` VARCHAR(255) NOT NULL,
    `rol_id` INT NOT NULL
);
CREATE TABLE `artiekel`(
    `artiekelnummer` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `omschrijving` VARCHAR(255) NOT NULL,
    `leverancier` VARCHAR(255) NOT NULL,
    `artiekel groep` VARCHAR(255) NOT NULL,
    `eenheid` VARCHAR(255) NOT NULL,
    `prijs` DOUBLE(8, 2) NOT NULL,
    `aantal` INT NOT NULL
);
CREATE TABLE `functie`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `rol_id` INT NOT NULL,
    `functie` INT NOT NULL
);
ALTER TABLE
    `verkopen` ADD CONSTRAINT `verkopen_artiekelnummer_foreign` FOREIGN KEY(`artiekelnummer`) REFERENCES `artiekel`(`artiekelnummer`);
ALTER TABLE
    `functie` ADD CONSTRAINT `functie_rol_id_foreign` FOREIGN KEY(`rol_id`) REFERENCES `inlog`(`rol_id`);






    USE CashFlow;

CREATE TABLE IF NOT EXISTS login (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'manager', 'cashier', 'warehouse') NOT NULL
);

INSERT INTO login (username, password, role) VALUES 
('admin_user', 'admin_password', 'admin'),
('manager_user', 'manager_password', 'manager'),
('cashier_user', 'cashier_password', 'cashier'),
('warehouse_user', 'warehouse_password', 'warehouse');
