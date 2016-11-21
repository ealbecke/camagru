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
  login TEXT NOT NULL,
  mail TEXT NOT NULL,
  password TEXT NOT NULL,
  token TEXT NOT NULL,
  actif TINYINT(1) DEFAULT NULL,
  create_date DATETIME NOT NULL,
  PRIMARY KEY (id)
);";

$req .= "CREATE TABLE IF NOT EXISTS pictures (
  id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  name_member TEXT NOT NULL,
  name_picture TEXT NOT NULL,
  PRIMARY KEY (id)
);";

$req .= "CREATE TABLE IF NOT EXISTS comments (
  id_comment INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  sender TEXT NOT NULL,
  recipient TEXT NOT NULL,
  id_picture INT(6) NOT NULL,
  name_picture VARCHAR(255) NOT NULL,
  commentaire TEXT NOT NULL,
  PRIMARY KEY (id_comment));";

$req .= "CREATE TABLE IF NOT EXISTS likes (
  id_like INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  sender TEXT NOT NULL,
  recipient TEXT NOT NULL,
  id_picture INT(6) NOT NULL,
  name_picture VARCHAR(255) NOT NULL,
  active TINYINT(1) NOT NULL,
  PRIMARY KEY (id_like));";

$bdd->prepare($req)->execute();
?>