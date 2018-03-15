DROP DATABASE IF EXISTS `bilderdb`;
CREATE DATABASE IF NOT EXISTS `bilderdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_german2_ci;
CREATE TABLE benutzer( ID INT AUTO_INCREMENT PRIMARY KEY, EMAIL VARCHAR(45), PASSWORD LONGTEXT, NICKNAME VARCHAR(45));
CREATE TABLE GALERIE(ID INT AUTO_INCREMENT PRIMARY KEY, Name VARCHAR(45), Beschreibung LONGTEXT, BID INT NOT NULL, FOREIGN KEY(BID) REFERENCES benutzer(ID));
CREATE TABLE BILDER( ID INT AUTO_INCREMENT PRIMARY KEY, NAME VARCHAR(45), LINK LONGTEXT, GID INT NOT NULL,  FOREIGN KEY (GID) REFERENCES GALERIE(GID));
