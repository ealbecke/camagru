/* create databases */
CREATE DATABASE IF NOT EXISTS CAMAGRU;

/* create table */
USE CAMAGRU;

CREATE TABLE IF NOT EXISTS members (
	id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	login VARCHAR(255) NOT NULL,
	mail VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	token VARCHAR(255) NOT NULL,
	actif TINYINT(1) DEFAULT NULL,
	create_date DATETIME NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS pictures (
	id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	name_member VARCHAR(255) NOT NULL,
	name_picture VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS comments (id_comment INT(6) UNSIGNED NOT NULL AUTO_INCREMENT, sender VARCHAR(255) NOT NULL, recipient VARCHAR(255) NOT NULL, id_picture INT(6) NOT NULL, name_picture VARCHAR(255) NOT NULL, commentaire VARCHAR(255) NOT NULL, PRIMARY KEY (id_comment));


INSERT INTO comments (sender, recipient, id_picture, name_picture, commentaire) VALUES ("eliot", "Tom", 83, "tom_14793886077", "Ceci est mon commentaire ;)");