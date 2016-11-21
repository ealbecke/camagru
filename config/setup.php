<?php
require 'database.php';
try {
	$bdd = new PDO('mysql:host=localhost;charset=utf8', $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$req = "CREATE DATABASE IF NOT EXISTS CAMAGRU;";

$req .= "USE CAMAGRU;";

$req .= "CREATE TABLE IF NOT EXISTS members (
  id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  login VARCHAR(255) NOT NULL,
  mail VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  token VARCHAR(255) NOT NULL,
  actif TINYINT(1) DEFAULT NULL,
  create_date DATETIME NOT NULL,
  PRIMARY KEY (id)
);";

$req .= "CREATE TABLE IF NOT EXISTS pictures (
  id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  name_member VARCHAR(255) NOT NULL,
  name_picture VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);";

$req .= "CREATE TABLE IF NOT EXISTS comments (
  id_comment INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  sender VARCHAR(255) NOT NULL,
  recipient VARCHAR(255) NOT NULL,
  id_picture INT(6) NOT NULL, name_picture VARCHAR(255) NOT NULL,
  commentaire VARCHAR(255) NOT NULL,
  PRIMARY KEY (id_comment));";

$req .= "CREATE TABLE IF NOT EXISTS likes (
  id_like INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  sender VARCHAR(255) NOT NULL,
  recipient VARCHAR(255) NOT NULL,
  id_picture INT(6) NOT NULL,
  name_picture VARCHAR(255) NOT NULL,
  active TINYINT(1) NOT NULL,
  PRIMARY KEY (id_like));";

$bdd->prepare($req)->execute();
?>